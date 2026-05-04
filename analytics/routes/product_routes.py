"""
API Routes cho phân tích sản phẩm.
"""
from flask import Blueprint, jsonify, request
from services.product_analysis import (
    get_top_sellers,
    get_conversion_rate,
    get_price_distribution,
    get_stock_alerts,
    get_product_overview,
    get_profitability,
)

product_bp = Blueprint('products', __name__, url_prefix='/api/products')


@product_bp.route('/overview')
def overview():
    """Tổng quan sản phẩm."""
    data = get_product_overview()
    return jsonify(data)


@product_bp.route('/top-sellers')
def top_sellers():
    """Top sản phẩm bán chạy."""
    limit = request.args.get('limit', 10, type=int)
    data = get_top_sellers(limit=limit)
    return jsonify(data)


@product_bp.route('/conversion-rate')
def conversion_rate():
    """Tỷ lệ chuyển đổi view → buy."""
    data = get_conversion_rate()
    return jsonify(data)


@product_bp.route('/price-distribution')
def price_distribution():
    """Phân bố giá sản phẩm."""
    data = get_price_distribution()
    return jsonify(data)


@product_bp.route('/stock-alerts')
def stock_alerts():
    """Cảnh báo tồn kho."""
    threshold = request.args.get('threshold', 10, type=int)
    data = get_stock_alerts(threshold=threshold)
    return jsonify(data)


@product_bp.route('/profitability')
def profitability():
    """Phân tích lợi nhuận theo sản phẩm và danh mục."""
    data = get_profitability()
    return jsonify(data)
