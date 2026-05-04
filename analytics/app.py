"""
Flask Analytics Service - Entry Point
Chạy trên port 5000, cung cấp API phân tích dữ liệu cho Laravel.
"""
from flask import Flask, jsonify
from flask_cors import CORS
from config import FLASK_HOST, FLASK_PORT, FLASK_DEBUG

# Import blueprints
from routes.revenue_routes import revenue_bp
from routes.product_routes import product_bp
from routes.customer_routes import customer_bp
from routes.prediction_routes import prediction_bp

app = Flask(__name__)
CORS(app)  # Cho phép Laravel gọi API

# Đăng ký blueprints
app.register_blueprint(revenue_bp)
app.register_blueprint(product_bp)
app.register_blueprint(customer_bp)
app.register_blueprint(prediction_bp)


@app.route('/')
def index():
    """Health check endpoint."""
    return jsonify({
        'service': 'EShop Analytics API',
        'status': 'running',
        'version': '1.0.0',
        'endpoints': {
            'revenue': [
                '/api/revenue/overview',
                '/api/revenue/by-category',
                '/api/revenue/by-city',
                '/api/revenue/status-distribution',
                '/api/revenue/statistics',
            ],
            'products': [
                '/api/products/overview',
                '/api/products/top-sellers',
                '/api/products/conversion-rate',
                '/api/products/price-distribution',
                '/api/products/stock-alerts',
            ],
            'customers': [
                '/api/customers/overview',
                '/api/customers/top-customers',
                '/api/customers/abandoned-carts',
                '/api/customers/rfm',
                '/api/customers/clv',
                '/api/customers/distribution',
            ],
            'predict': [
                '/api/predict/revenue',
                '/api/predict/recommendations',
                '/api/predict/anomalies',
            ],
        }
    })


if __name__ == '__main__':
    print(f"[OK] EShop Analytics API running on http://{FLASK_HOST}:{FLASK_PORT}")
    app.run(host=FLASK_HOST, port=FLASK_PORT, debug=FLASK_DEBUG)
