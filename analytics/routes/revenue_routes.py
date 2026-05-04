"""
API Routes cho phân tích doanh thu.
"""
from flask import Blueprint, jsonify
from services.revenue_analysis import (
    get_revenue_overview,
    get_revenue_by_category,
    get_revenue_by_city,
    get_order_status_distribution,
    get_revenue_statistics,
)

revenue_bp = Blueprint('revenue', __name__, url_prefix='/api/revenue')


@revenue_bp.route('/overview')
def overview():
    """Tổng quan doanh thu."""
    data = get_revenue_overview()
    return jsonify(data)


@revenue_bp.route('/by-category')
def by_category():
    """Doanh thu theo danh mục."""
    data = get_revenue_by_category()
    return jsonify(data)


@revenue_bp.route('/by-city')
def by_city():
    """Doanh thu theo thành phố."""
    data = get_revenue_by_city()
    return jsonify(data)


@revenue_bp.route('/status-distribution')
def status_distribution():
    """Phân bố trạng thái đơn hàng."""
    data = get_order_status_distribution()
    return jsonify(data)


@revenue_bp.route('/statistics')
def statistics():
    """Thống kê chi tiết doanh thu."""
    data = get_revenue_statistics()
    return jsonify(data)
