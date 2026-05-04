"""
Module ML & Dự đoán - Phase 5.
Bao gồm: Dự đoán doanh thu, Đề xuất sản phẩm, Phát hiện bất thường.
"""
import pandas as pd
import numpy as np
from sklearn.linear_model import LinearRegression
from sklearn.ensemble import IsolationForest
from sklearn.preprocessing import StandardScaler
from collections import Counter
from itertools import combinations
from models.database import SessionLocal, Order, OrderDetail, Product, Category


def predict_revenue():
    """
    Dự đoán doanh thu sử dụng Linear Regression.
    Dựa trên xu hướng đơn hàng hiện tại để dự báo.
    """
    session = SessionLocal()
    try:
        orders = session.query(Order).all()

        if not orders or len(orders) < 2:
            return {
                'prediction': [],
                'model_info': {'type': 'Linear Regression', 'data_points': 0, 'status': 'Khong du du lieu'},
                'current_data': {'labels': [], 'values': []},
            }

        # Tạo dữ liệu theo thứ tự đơn hàng
        df = pd.DataFrame([{
            'order_index': i + 1,
            'total_price': o.total_price or 0,
        } for i, o in enumerate(orders)])

        # Doanh thu tích lũy
        df['cumulative_revenue'] = df['total_price'].cumsum()

        # Train model
        X = df[['order_index']].values
        y = df['cumulative_revenue'].values

        model = LinearRegression()
        model.fit(X, y)

        r2_score = round(model.score(X, y), 4)

        # Dự đoán cho 5 đơn tiếp theo
        current_count = len(orders)
        future_indices = np.array([[i] for i in range(current_count + 1, current_count + 6)])
        predictions = model.predict(future_indices)

        # Doanh thu dự đoán cho mỗi đơn tiếp theo
        predicted_incremental = []
        prev = float(df['cumulative_revenue'].iloc[-1])
        for p in predictions:
            increment = max(0, float(p) - prev)
            predicted_incremental.append(round(increment, 0))
            prev = float(p)

        return {
            'current_data': {
                'labels': [f"Don {i+1}" for i in range(current_count)],
                'values': df['total_price'].tolist(),
                'cumulative': df['cumulative_revenue'].tolist(),
            },
            'prediction': {
                'labels': [f"Don {i}" for i in range(current_count + 1, current_count + 6)],
                'cumulative': [round(float(p), 0) for p in predictions],
                'incremental': predicted_incremental,
            },
            'model_info': {
                'type': 'Linear Regression',
                'r2_score': r2_score,
                'coefficient': round(float(model.coef_[0]), 2),
                'intercept': round(float(model.intercept_), 2),
                'data_points': current_count,
                'avg_order_value': round(float(df['total_price'].mean()), 0),
                'predicted_next_order': predicted_incremental[0] if predicted_incremental else 0,
            },
        }
    finally:
        session.close()


def get_product_recommendations():
    """
    Sản phẩm thường được mua cùng nhau (Frequent Itemsets).
    Phân tích giỏ hàng (Market Basket Analysis đơn giản).
    """
    session = SessionLocal()
    try:
        orders = session.query(Order).all()
        details = session.query(OrderDetail).all()

        if not details:
            return {'pairs': [], 'message': 'Chua co du lieu don hang'}

        # Nhóm sản phẩm theo đơn hàng
        order_products = {}
        for d in details:
            if d.order_id not in order_products:
                order_products[d.order_id] = set()
            order_products[d.order_id].add(d.product_id)

        # Tìm các cặp sản phẩm hay mua cùng
        pair_counter = Counter()
        for order_id, products in order_products.items():
            if len(products) >= 2:
                for pair in combinations(sorted(products), 2):
                    pair_counter[pair] += 1

        if not pair_counter:
            # Nếu không có cặp, đề xuất sản phẩm phổ biến nhất
            product_counter = Counter()
            for d in details:
                product_counter[d.product_id] += d.quanlity or 1

            # Lấy tên sản phẩm
            products = session.query(Product).all()
            product_map = {p.id: p.name for p in products}

            popular = product_counter.most_common(5)
            return {
                'pairs': [],
                'popular_products': [
                    {'product': product_map.get(pid, f'SP #{pid}'), 'times_bought': count}
                    for pid, count in popular
                ],
                'message': 'Chua co du cap san pham mua cung. Hien thi san pham pho bien.',
            }

        # Lấy tên sản phẩm
        products = session.query(Product).all()
        product_map = {p.id: {'name': p.name, 'price': p.price} for p in products}

        top_pairs = pair_counter.most_common(10)
        pairs_data = []
        for (p1, p2), count in top_pairs:
            info1 = product_map.get(p1, {'name': f'SP #{p1}', 'price': 0})
            info2 = product_map.get(p2, {'name': f'SP #{p2}', 'price': 0})
            pairs_data.append({
                'product_1': info1['name'],
                'product_2': info2['name'],
                'times_bought_together': count,
                'bundle_price': info1['price'] + info2['price'],
            })

        return {
            'pairs': pairs_data,
            'total_orders_analyzed': len(order_products),
            'orders_with_multiple_items': sum(1 for p in order_products.values() if len(p) >= 2),
        }
    finally:
        session.close()


def detect_anomalies():
    """
    Phát hiện đơn hàng / giá trị bất thường sử dụng IsolationForest
    và phương pháp thống kê (IQR).
    """
    session = SessionLocal()
    try:
        orders = session.query(Order).all()

        if not orders or len(orders) < 3:
            return {
                'anomalies': [],
                'statistics': {},
                'method': 'Khong du du lieu',
            }

        df = pd.DataFrame([{
            'id': o.id,
            'code': o.code,
            'total_price': o.total_price or 0,
            'email': o.email or '',
            'city': o.city or '',
            'status': o.status or '',
        } for o in orders])

        # Method 1: IQR (Interquartile Range)
        Q1 = df['total_price'].quantile(0.25)
        Q3 = df['total_price'].quantile(0.75)
        IQR = Q3 - Q1
        lower_bound = Q1 - 1.5 * IQR
        upper_bound = Q3 + 1.5 * IQR

        iqr_anomalies = df[(df['total_price'] < lower_bound) | (df['total_price'] > upper_bound)]

        # Method 2: IsolationForest (nếu đủ dữ liệu)
        ml_anomalies = pd.DataFrame()
        if len(df) >= 5:
            try:
                X = df[['total_price']].values
                scaler = StandardScaler()
                X_scaled = scaler.fit_transform(X)

                iso_forest = IsolationForest(contamination=0.2, random_state=42, n_estimators=100)
                df['ml_anomaly'] = iso_forest.fit_predict(X_scaled)
                ml_anomalies = df[df['ml_anomaly'] == -1]
            except Exception:
                pass

        # Kết hợp kết quả
        all_anomaly_ids = set(iqr_anomalies['id'].tolist())
        if len(ml_anomalies) > 0:
            all_anomaly_ids.update(ml_anomalies['id'].tolist())

        anomaly_orders = df[df['id'].isin(all_anomaly_ids)]

        anomalies_list = []
        for _, row in anomaly_orders.iterrows():
            reason = []
            if row['total_price'] > upper_bound:
                reason.append('Gia tri cao bat thuong')
            elif row['total_price'] < lower_bound:
                reason.append('Gia tri thap bat thuong')
            if len(ml_anomalies) > 0 and row['id'] in ml_anomalies['id'].values:
                reason.append('ML phat hien')

            anomalies_list.append({
                'order_id': int(row['id']),
                'code': row['code'],
                'total_price': float(row['total_price']),
                'email': row['email'],
                'reason': ' + '.join(reason) if reason else 'IQR outlier',
            })

        return {
            'anomalies': anomalies_list,
            'total_anomalies': len(anomalies_list),
            'total_orders': len(df),
            'anomaly_rate': round(len(anomalies_list) / len(df) * 100, 1) if len(df) > 0 else 0,
            'statistics': {
                'mean': round(float(df['total_price'].mean()), 0),
                'std': round(float(df['total_price'].std()), 0),
                'Q1': round(float(Q1), 0),
                'Q3': round(float(Q3), 0),
                'IQR': round(float(IQR), 0),
                'lower_bound': round(float(lower_bound), 0),
                'upper_bound': round(float(upper_bound), 0),
            },
            'methods': ['IQR (Interquartile Range)', 'Isolation Forest (ML)'],
        }
    finally:
        session.close()
