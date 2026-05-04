"""
API Routes cho phân tích khách hàng - Phase 4.
"""
from flask import Blueprint, jsonify, request
from services.customer_analysis import (
    get_customer_overview,
    get_top_customers,
    get_abandoned_carts,
    get_rfm_segmentation,
    get_customer_lifetime_value,
    get_customer_distribution,
)

customer_bp = Blueprint('customers', __name__, url_prefix='/api/customers')


@customer_bp.route('/overview')
def overview():
    data = get_customer_overview()
    return jsonify(data)


@customer_bp.route('/top-customers')
def top_customers():
    limit = request.args.get('limit', 10, type=int)
    data = get_top_customers(limit=limit)
    return jsonify(data)


@customer_bp.route('/abandoned-carts')
def abandoned_carts():
    data = get_abandoned_carts()
    return jsonify(data)


@customer_bp.route('/rfm')
def rfm():
    """Phan khuc khach hang RFM."""
    data = get_rfm_segmentation()
    return jsonify(data)


@customer_bp.route('/clv')
def clv():
    """Customer Lifetime Value."""
    data = get_customer_lifetime_value()
    return jsonify(data)


@customer_bp.route('/distribution')
def distribution():
    """Phan bo khach hang."""
    data = get_customer_distribution()
    return jsonify(data)
