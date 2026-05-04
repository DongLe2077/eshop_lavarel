"""
API Routes cho ML & Du doan - Phase 5.
"""
from flask import Blueprint, jsonify
from services.prediction import (
    predict_revenue,
    get_product_recommendations,
    detect_anomalies,
)

prediction_bp = Blueprint('predict', __name__, url_prefix='/api/predict')


@prediction_bp.route('/revenue')
def revenue():
    """Du doan doanh thu."""
    data = predict_revenue()
    return jsonify(data)


@prediction_bp.route('/recommendations')
def recommendations():
    """San pham thuong mua cung nhau."""
    data = get_product_recommendations()
    return jsonify(data)


@prediction_bp.route('/anomalies')
def anomalies():
    """Phat hien bat thuong."""
    data = detect_anomalies()
    return jsonify(data)
