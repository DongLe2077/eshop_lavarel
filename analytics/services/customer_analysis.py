"""
Module phân tích khách hàng - Phase 4.
Bao gồm: Overview, Top customers, Abandoned carts, RFM Segmentation, CLV.
"""
import pandas as pd
import numpy as np
import json
from models.database import SessionLocal, User, Order, OrderDetail


def get_customer_overview():
    """Tổng quan khách hàng."""
    session = SessionLocal()
    try:
        users = session.query(User).all()
        orders = session.query(Order).all()

        total_users = len(users)
        total_customers = len([u for u in users if u.role == 'customer'])
        total_admins = len([u for u in users if u.role == 'admin'])

        buyer_ids = set(o.user_id for o in orders if o.user_id)
        buyers_count = len(buyer_ids)

        return {
            'total_users': total_users,
            'total_customers': total_customers,
            'total_admins': total_admins,
            'buyers_count': buyers_count,
            'non_buyers_count': max(0, total_customers - buyers_count),
            'purchase_rate': round((buyers_count / total_customers * 100), 1) if total_customers > 0 else 0,
        }
    finally:
        session.close()


def get_top_customers(limit=10):
    """Top khách hàng chi tiêu nhiều nhất."""
    session = SessionLocal()
    try:
        orders = session.query(Order).filter(Order.user_id.isnot(None)).all()

        if not orders:
            return {'customers': [], 'labels': [], 'data': []}

        df = pd.DataFrame([{
            'user_id': o.user_id,
            'email': o.email,
            'name': f"{o.first_name or ''} {o.last_name or ''}".strip(),
            'total_price': o.total_price or 0,
        } for o in orders])

        grouped = df.groupby(['user_id', 'email']).agg(
            total_spent=('total_price', 'sum'),
            order_count=('total_price', 'count'),
            avg_order_value=('total_price', 'mean'),
        ).reset_index()

        grouped = grouped.sort_values('total_spent', ascending=False).head(limit)
        grouped['avg_order_value'] = grouped['avg_order_value'].round(0)

        return {
            'customers': grouped.to_dict('records'),
            'labels': grouped['email'].tolist(),
            'data': grouped['total_spent'].tolist(),
        }
    finally:
        session.close()


def get_abandoned_carts():
    """Phân tích giỏ hàng bị bỏ."""
    session = SessionLocal()
    try:
        users = session.query(User).filter(User.cart_data.isnot(None)).all()

        abandoned = []
        total_value = 0

        for user in users:
            try:
                cart = json.loads(user.cart_data) if user.cart_data else None
                if cart and len(cart) > 0:
                    cart_value = sum(
                        item.get('price', 0) * item.get('quantity', 0)
                        for item in (cart if isinstance(cart, list) else cart.values())
                    )
                    if cart_value > 0:
                        abandoned.append({
                            'user_id': user.id,
                            'email': user.email,
                            'items_count': len(cart) if isinstance(cart, list) else len(cart.keys()),
                            'cart_value': cart_value,
                        })
                        total_value += cart_value
            except (json.JSONDecodeError, TypeError):
                continue

        return {
            'abandoned_carts': abandoned,
            'total_abandoned': len(abandoned),
            'total_value': total_value,
        }
    finally:
        session.close()


def get_rfm_segmentation():
    """
    Phân khúc khách hàng theo mô hình RFM.
    R (Recency): Đơn gần đây nhất
    F (Frequency): Số lần mua
    M (Monetary): Tổng chi tiêu
    """
    session = SessionLocal()
    try:
        orders = session.query(Order).filter(Order.user_id.isnot(None)).all()

        if not orders or len(orders) < 2:
            return {
                'segments': {},
                'customers': [],
                'segment_chart': {'labels': [], 'data': [], 'colors': []},
            }

        df = pd.DataFrame([{
            'user_id': o.user_id,
            'order_id': o.id,
            'total_price': o.total_price or 0,
            'email': o.email or '',
        } for o in orders])

        # Tính RFM
        rfm = df.groupby('user_id').agg(
            recency=('order_id', 'max'),       # ID lớn nhất = đơn gần nhất
            frequency=('order_id', 'count'),    # Số đơn hàng
            monetary=('total_price', 'sum'),    # Tổng chi tiêu
        ).reset_index()

        # Lấy email cho mỗi user
        email_map = df.drop_duplicates('user_id').set_index('user_id')['email'].to_dict()
        rfm['email'] = rfm['user_id'].map(email_map)

        # Scoring (chia 3 nhóm đơn giản dựa trên quantile hoặc rank)
        for col in ['recency', 'frequency', 'monetary']:
            if rfm[col].nunique() > 1:
                try:
                    rfm[f'{col}_score'] = pd.qcut(rfm[col], q=3, labels=[1, 2, 3], duplicates='drop').astype(int)
                except ValueError:
                    rfm[f'{col}_score'] = pd.cut(rfm[col], bins=3, labels=[1, 2, 3], duplicates='drop').astype(int)
            else:
                rfm[f'{col}_score'] = 2

        rfm['rfm_score'] = rfm['recency_score'] + rfm['frequency_score'] + rfm['monetary_score']

        # Phân khúc
        def segment(score):
            if score >= 8:
                return 'VIP'
            elif score >= 6:
                return 'Trung thành'
            elif score >= 4:
                return 'Tiềm năng'
            else:
                return 'Cần giữ chân'

        rfm['segment'] = rfm['rfm_score'].apply(segment)

        # Thống kê phân khúc
        segment_counts = rfm['segment'].value_counts().to_dict()

        color_map = {
            'VIP': '#8b5cf6',
            'Trung thành': '#3b82f6',
            'Tiềm năng': '#10b981',
            'Cần giữ chân': '#f59e0b',
        }

        segment_labels = list(segment_counts.keys())
        segment_colors = [color_map.get(s, '#94a3b8') for s in segment_labels]

        # Chi tiết khách hàng
        customers = rfm[['user_id', 'email', 'recency', 'frequency', 'monetary', 'rfm_score', 'segment']].to_dict('records')
        for c in customers:
            c['monetary'] = round(c['monetary'], 0)

        return {
            'segments': segment_counts,
            'customers': customers,
            'segment_chart': {
                'labels': segment_labels,
                'data': list(segment_counts.values()),
                'colors': segment_colors,
            },
        }
    finally:
        session.close()


def get_customer_lifetime_value():
    """
    Ước tính Customer Lifetime Value (CLV) đơn giản.
    CLV = AOV x Frequency x Estimated Lifespan
    """
    session = SessionLocal()
    try:
        orders = session.query(Order).filter(Order.user_id.isnot(None)).all()

        if not orders:
            return {
                'avg_clv': 0,
                'total_clv': 0,
                'customers': [],
                'distribution': {'bins': [], 'counts': []},
            }

        df = pd.DataFrame([{
            'user_id': o.user_id,
            'total_price': o.total_price or 0,
            'email': o.email or '',
        } for o in orders])

        customer_stats = df.groupby(['user_id', 'email']).agg(
            total_spent=('total_price', 'sum'),
            order_count=('total_price', 'count'),
            avg_order_value=('total_price', 'mean'),
        ).reset_index()

        # CLV đơn giản: AOV * Frequency * 12 (giả định 12 tháng)
        estimated_lifespan = 12
        customer_stats['clv'] = (customer_stats['avg_order_value'] * customer_stats['order_count'] * estimated_lifespan / max(1, customer_stats['order_count'].max()))
        customer_stats['clv'] = customer_stats['clv'].round(0)

        avg_clv = float(customer_stats['clv'].mean())
        total_clv = float(customer_stats['clv'].sum())

        # CLV distribution
        if len(customer_stats) > 1:
            counts, bin_edges = np.histogram(customer_stats['clv'], bins=min(5, len(customer_stats)))
            bin_labels = [f"{int(bin_edges[i]/1000000)}M-{int(bin_edges[i+1]/1000000)}M"
                          for i in range(len(counts))]
        else:
            bin_labels = [f"{int(customer_stats['clv'].iloc[0]/1000)}k"]
            counts = np.array([1])

        return {
            'avg_clv': round(avg_clv, 0),
            'total_clv': round(total_clv, 0),
            'estimated_lifespan_months': estimated_lifespan,
            'customers': customer_stats.sort_values('clv', ascending=False).to_dict('records'),
            'distribution': {
                'bins': bin_labels,
                'counts': counts.tolist(),
            },
        }
    finally:
        session.close()


def get_customer_distribution():
    """Phân bố khách hàng theo số đơn hàng và chi tiêu."""
    session = SessionLocal()
    try:
        orders = session.query(Order).filter(Order.user_id.isnot(None)).all()

        if not orders:
            return {'order_dist': {'labels': [], 'data': []}, 'spend_dist': {'labels': [], 'data': []}}

        df = pd.DataFrame([{
            'user_id': o.user_id,
            'total_price': o.total_price or 0,
        } for o in orders])

        customer_stats = df.groupby('user_id').agg(
            order_count=('total_price', 'count'),
            total_spent=('total_price', 'sum'),
        ).reset_index()

        # Phân bố theo số đơn
        order_dist = customer_stats['order_count'].value_counts().sort_index()

        return {
            'order_dist': {
                'labels': [f"{v} don" for v in order_dist.index.tolist()],
                'data': order_dist.values.tolist(),
            },
            'total_customers_with_orders': len(customer_stats),
            'avg_orders_per_customer': round(float(customer_stats['order_count'].mean()), 1),
            'avg_spend_per_customer': round(float(customer_stats['total_spent'].mean()), 0),
        }
    finally:
        session.close()
