"""
Module phân tích sản phẩm.
"""
import pandas as pd
import numpy as np
from models.database import SessionLocal, Product, Category, OrderDetail, Order


def get_top_sellers(limit=10):
    """Top sản phẩm bán chạy nhất."""
    session = SessionLocal()
    try:
        details = session.query(
            Product.id,
            Product.name,
            Product.price,
            Product.image,
            Category.name.label('category_name'),
            OrderDetail.quanlity,
        ).join(Product, OrderDetail.product_id == Product.id) \
         .join(Category, Product.category_id == Category.id) \
         .all()

        if not details:
            return {'products': [], 'labels': [], 'data': []}

        df = pd.DataFrame([{
            'product_id': d.id,
            'name': d.name,
            'price': d.price,
            'image': d.image,
            'category': d.category_name,
            'quantity_sold': d.quanlity or 0,
        } for d in details])

        grouped = df.groupby(['product_id', 'name', 'price', 'image', 'category']).agg(
            total_sold=('quantity_sold', 'sum'),
        ).reset_index()

        grouped = grouped.sort_values('total_sold', ascending=False).head(limit)

        return {
            'products': grouped.to_dict('records'),
            'labels': grouped['name'].tolist(),
            'data': grouped['total_sold'].tolist(),
        }
    finally:
        session.close()


def get_conversion_rate():
    """Tỷ lệ chuyển đổi: view → buy cho mỗi sản phẩm."""
    session = SessionLocal()
    try:
        products = session.query(Product).all()
        details = session.query(
            OrderDetail.product_id,
            OrderDetail.quanlity,
        ).all()

        if not products:
            return {'products': [], 'labels': [], 'rates': []}

        # Tổng số bán cho từng sản phẩm
        sold_df = pd.DataFrame([{
            'product_id': d.product_id,
            'quantity': d.quanlity or 0,
        } for d in details]) if details else pd.DataFrame(columns=['product_id', 'quantity'])

        sold_summary = sold_df.groupby('product_id')['quantity'].sum().to_dict() if len(sold_df) > 0 else {}

        results = []
        for p in products:
            total_sold = sold_summary.get(p.id, 0)
            views = p.view or 1  # Tránh chia cho 0
            rate = round((total_sold / views) * 100, 2)
            results.append({
                'name': p.name,
                'views': p.view or 0,
                'sold': total_sold,
                'conversion_rate': rate,
                'category': p.category.name if p.category else 'N/A',
            })

        df = pd.DataFrame(results)
        df = df.sort_values('conversion_rate', ascending=False)

        return {
            'products': df.to_dict('records'),
            'labels': df['name'].tolist(),
            'rates': df['conversion_rate'].tolist(),
        }
    finally:
        session.close()


def get_price_distribution():
    """Phân bố giá sản phẩm theo danh mục."""
    session = SessionLocal()
    try:
        products = session.query(
            Product.name,
            Product.price,
            Category.name.label('category_name'),
        ).join(Category, Product.category_id == Category.id).all()

        if not products:
            return {'categories': {}, 'overall': {}}

        df = pd.DataFrame([{
            'name': p.name,
            'price': p.price,
            'category': p.category_name,
        } for p in products])

        # Thống kê giá theo danh mục
        cat_stats = df.groupby('category')['price'].agg(['mean', 'min', 'max', 'count']).reset_index()
        cat_stats.columns = ['category', 'avg_price', 'min_price', 'max_price', 'count']

        # Phân bố tổng thể
        counts, bin_edges = np.histogram(df['price'], bins=6)
        bin_labels = [f"{int(bin_edges[i]/1000)}k-{int(bin_edges[i+1]/1000)}k"
                      for i in range(len(counts))]

        return {
            'categories': {
                'labels': cat_stats['category'].tolist(),
                'avg_prices': [round(x, 0) for x in cat_stats['avg_price'].tolist()],
                'min_prices': cat_stats['min_price'].tolist(),
                'max_prices': cat_stats['max_price'].tolist(),
            },
            'overall': {
                'bins': bin_labels,
                'counts': counts.tolist(),
            },
        }
    finally:
        session.close()


def get_stock_alerts(threshold=10):
    """Cảnh báo sản phẩm sắp hết hàng."""
    session = SessionLocal()
    try:
        products = session.query(
            Product.id,
            Product.name,
            Product.quanlity,
            Product.price,
            Product.image,
            Category.name.label('category_name'),
        ).join(Category, Product.category_id == Category.id) \
         .filter(Product.quanlity <= threshold) \
         .order_by(Product.quanlity.asc()) \
         .all()

        results = [{
            'id': p.id,
            'name': p.name,
            'stock': p.quanlity,
            'price': p.price,
            'image': p.image,
            'category': p.category_name,
            'status': 'Hết hàng' if p.quanlity == 0 else ('Sắp hết' if p.quanlity <= 5 else 'Thấp'),
        } for p in products]

        return {
            'products': results,
            'total_alerts': len(results),
            'out_of_stock': sum(1 for r in results if r['status'] == 'Hết hàng'),
            'low_stock': sum(1 for r in results if r['status'] != 'Hết hàng'),
        }
    finally:
        session.close()


def get_product_overview():
    """Tổng quan sản phẩm: số lượng theo danh mục, giá trị kho hàng."""
    session = SessionLocal()
    try:
        products = session.query(
            Product.price,
            Product.quanlity,
            Product.view,
            Category.name.label('category_name'),
        ).join(Category, Product.category_id == Category.id).all()

        if not products:
            return {
                'total_products': 0,
                'total_inventory_value': 0,
                'total_views': 0,
                'by_category': {'labels': [], 'counts': [], 'values': []},
            }

        df = pd.DataFrame([{
            'price': p.price,
            'stock': p.quanlity,
            'views': p.view,
            'category': p.category_name,
            'inventory_value': (p.price or 0) * (p.quanlity or 0),
        } for p in products])

        cat_summary = df.groupby('category').agg(
            count=('price', 'count'),
            total_value=('inventory_value', 'sum'),
            total_views=('views', 'sum'),
        ).reset_index()

        return {
            'total_products': len(df),
            'total_inventory_value': float(df['inventory_value'].sum()),
            'total_views': int(df['views'].sum()),
            'avg_price': round(float(df['price'].mean()), 0),
            'by_category': {
                'labels': cat_summary['category'].tolist(),
                'counts': cat_summary['count'].tolist(),
                'values': cat_summary['total_value'].tolist(),
            },
        }
    finally:
        session.close()


def get_profitability():
    """
    Phân tích lợi nhuận ước tính theo sản phẩm và danh mục.
    Vì không có giá vốn (cost_price) trong DB, ta dùng biên lợi nhuận
    ngành thời trang Việt Nam (gross margin ~35-45%, trung bình 40%).
    """
    GROSS_MARGIN = 0.40  # 40% biên lợi nhuận gộp

    session = SessionLocal()
    try:
        details = session.query(
            Product.id,
            Product.name,
            Product.price,
            Category.name.label('category_name'),
            OrderDetail.quanlity,
            OrderDetail.price.label('sale_price'),
            Order.status,
        ).join(Product, OrderDetail.product_id == Product.id) \
         .join(Category, Product.category_id == Category.id) \
         .join(Order, OrderDetail.order_id == Order.id) \
         .filter(~Order.status.in_(['canceled', 'đã hủy'])) \
         .all()

        if not details:
            return {
                'by_product': [],
                'by_category': {'labels': [], 'revenue': [], 'profit': [], 'margin': []},
                'summary': {},
                'gross_margin_rate': GROSS_MARGIN,
            }

        df = pd.DataFrame([{
            'product_id': d.id,
            'name': d.name,
            'category': d.category_name,
            'quantity': d.quanlity or 0,
            'sale_price': d.sale_price or d.price or 0,
        } for d in details])

        df['revenue'] = df['quantity'] * df['sale_price']
        df['estimated_cost'] = df['revenue'] * (1 - GROSS_MARGIN)
        df['gross_profit'] = df['revenue'] * GROSS_MARGIN

        # Lợi nhuận theo sản phẩm
        by_product = df.groupby(['product_id', 'name', 'category']).agg(
            total_quantity=('quantity', 'sum'),
            total_revenue=('revenue', 'sum'),
            total_profit=('gross_profit', 'sum'),
        ).reset_index()

        by_product['margin_pct'] = GROSS_MARGIN * 100
        by_product['profit_per_unit'] = (by_product['total_profit'] / by_product['total_quantity']).round(0)
        by_product = by_product.sort_values('total_profit', ascending=False)

        # Lợi nhuận theo danh mục
        by_category = df.groupby('category').agg(
            total_revenue=('revenue', 'sum'),
            total_profit=('gross_profit', 'sum'),
        ).reset_index()

        by_category['margin_pct'] = GROSS_MARGIN * 100
        by_category = by_category.sort_values('total_profit', ascending=False)

        total_revenue = float(df['revenue'].sum())
        total_profit = float(df['gross_profit'].sum())
        total_cost = float(df['estimated_cost'].sum())

        return {
            'by_product': by_product.to_dict('records'),
            'by_category': {
                'labels': by_category['category'].tolist(),
                'revenue': [round(x, 0) for x in by_category['total_revenue'].tolist()],
                'profit': [round(x, 0) for x in by_category['total_profit'].tolist()],
                'margin': [GROSS_MARGIN * 100] * len(by_category),
            },
            'summary': {
                'total_revenue': round(total_revenue, 0),
                'total_profit': round(total_profit, 0),
                'total_cost': round(total_cost, 0),
                'overall_margin': round(GROSS_MARGIN * 100, 1),
                'most_profitable_product': by_product.iloc[0]['name'] if len(by_product) > 0 else None,
                'most_profitable_category': by_category.iloc[0]['category'] if len(by_category) > 0 else None,
            },
            'gross_margin_rate': GROSS_MARGIN,
            'note': 'Loi nhuan uoc tinh voi bien 40% nganh thoi trang',
        }
    finally:
        session.close()
