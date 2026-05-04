"""
Module phân tích doanh thu.
"""
import pandas as pd
import numpy as np
from models.database import SessionLocal, Order, OrderDetail, Product, Category


def get_revenue_overview():
    """Tổng quan doanh thu: tổng doanh thu, số đơn, AOV, trạng thái."""
    session = SessionLocal()
    try:
        orders = session.query(Order).all()
        if not orders:
            return {
                'total_revenue': 0,
                'total_orders': 0,
                'average_order_value': 0,
                'status_distribution': {},
                'max_order': 0,
                'min_order': 0,
            }

        df = pd.DataFrame([{
            'id': o.id,
            'total_price': o.total_price or 0,
            'status': o.status or 'unknown',
            'city': o.city or 'N/A',
            'user_id': o.user_id,
        } for o in orders])

        # Doanh thu thực tế (không tính đơn đã hủy)
        revenue_df = df[~df['status'].isin(['canceled', 'đã hủy'])]
        
        total_revenue = float(revenue_df['total_price'].sum())
        total_orders = len(df) # Vẫn đếm tổng đơn để biết quy mô
        aov = float(revenue_df['total_price'].mean()) if len(revenue_df) > 0 else 0

        # Phân bố trạng thái
        status_counts = df['status'].value_counts().to_dict()
        status_distribution = {k: int(v) for k, v in status_counts.items()}

        return {
            'total_revenue': total_revenue,
            'total_orders': total_orders,
            'average_order_value': round(aov, 0),
            'status_distribution': status_distribution,
            'max_order': float(df['total_price'].max()),
            'min_order': float(df['total_price'].min()),
        }
    finally:
        session.close()


def get_revenue_by_category():
    """Doanh thu theo danh mục sản phẩm."""
    session = SessionLocal()
    try:
        details = session.query(
            OrderDetail.quanlity,
            OrderDetail.price,
            Product.name.label('product_name'),
            Category.name.label('category_name'),
        ).join(Product, OrderDetail.product_id == Product.id) \
         .join(Category, Product.category_id == Category.id) \
         .all()

        if not details:
            return {'labels': [], 'data': [], 'details': []}

        df = pd.DataFrame([{
            'category': d.category_name,
            'revenue': (d.price or 0) * (d.quanlity or 0),
            'quantity': d.quanlity or 0,
        } for d in details])

        grouped = df.groupby('category').agg(
            total_revenue=('revenue', 'sum'),
            total_quantity=('quantity', 'sum'),
            order_count=('revenue', 'count'),
        ).reset_index()

        grouped = grouped.sort_values('total_revenue', ascending=False)

        return {
            'labels': grouped['category'].tolist(),
            'data': grouped['total_revenue'].tolist(),
            'details': grouped.to_dict('records'),
        }
    finally:
        session.close()


def get_revenue_by_city():
    """Doanh thu theo thành phố."""
    session = SessionLocal()
    try:
        orders = session.query(Order).filter(Order.city.isnot(None)).all()

        if not orders:
            return {'labels': [], 'data': []}

        df = pd.DataFrame([{
            'city': o.city or 'Khác',
            'total_price': o.total_price or 0,
        } for o in orders])

        grouped = df.groupby('city').agg(
            total_revenue=('total_price', 'sum'),
            order_count=('total_price', 'count'),
        ).reset_index()

        grouped = grouped.sort_values('total_revenue', ascending=False).head(10)

        return {
            'labels': grouped['city'].tolist(),
            'data': grouped['total_revenue'].tolist(),
            'details': grouped.to_dict('records'),
        }
    finally:
        session.close()


def get_order_status_distribution():
    """Phân bố trạng thái đơn hàng (cho donut chart)."""
    session = SessionLocal()
    try:
        orders = session.query(Order).all()

        if not orders:
            return {'labels': [], 'data': [], 'colors': []}

        df = pd.DataFrame([{'status': o.status or 'unknown'} for o in orders])
        status_counts = df['status'].value_counts()

        # Màu sắc cho từng trạng thái (Hỗ trợ cả Tiếng Việt và English keys)
        color_map = {
            # Tiếng Việt
            'đang xử lý': '#f59e0b',
            'hoàn thành': '#10b981',
            'đã hủy': '#ef4444',
            'đang giao': '#3b82f6',
            # English (mới)
            'pending': '#f59e0b',
            'processing': '#3b82f6',
            'completed': '#10b981',
            'canceled': '#ef4444',
            'unknown': '#94a3b8',
        }

        labels = status_counts.index.tolist()
        colors = [color_map.get(s, '#94a3b8') for s in labels]

        return {
            'labels': labels,
            'data': status_counts.values.tolist(),
            'colors': colors,
        }
    finally:
        session.close()


def get_revenue_statistics():
    """Thống kê chi tiết doanh thu: median, std, phân vị."""
    session = SessionLocal()
    try:
        orders = session.query(Order).all()

        if not orders:
            return {
                'mean': 0, 'median': 0, 'std': 0,
                'q25': 0, 'q75': 0,
                'histogram': {'bins': [], 'counts': []},
            }

        prices = pd.Series([o.total_price or 0 for o in orders])

        # Histogram data cho chart
        counts, bin_edges = np.histogram(prices, bins=8)
        bin_labels = [f"{int(bin_edges[i]/1000)}k-{int(bin_edges[i+1]/1000)}k"
                      for i in range(len(counts))]

        return {
            'mean': round(float(prices.mean()), 0),
            'median': round(float(prices.median()), 0),
            'std': round(float(prices.std()), 0),
            'q25': round(float(prices.quantile(0.25)), 0),
            'q75': round(float(prices.quantile(0.75)), 0),
            'histogram': {
                'bins': bin_labels,
                'counts': counts.tolist(),
            },
        }
    finally:
        session.close()
