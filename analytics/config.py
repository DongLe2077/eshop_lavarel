"""
Cấu hình cho Analytics Service.
Đọc thông tin kết nối DB từ file .env của Laravel.
"""
import os
from dotenv import load_dotenv
from pathlib import Path

# Đọc file .env từ thư mục gốc Laravel (parent của analytics/)
env_path = Path(__file__).resolve().parent.parent / '.env'
load_dotenv(dotenv_path=env_path)

# Database config
DB_HOST = os.getenv('DB_HOST', '127.0.0.1')
DB_PORT = os.getenv('DB_PORT', '3306')
DB_DATABASE = os.getenv('DB_DATABASE', 'eshop_lavarel')
DB_USERNAME = os.getenv('DB_USERNAME', 'root')
DB_PASSWORD = os.getenv('DB_PASSWORD', '')

# SQLAlchemy connection string
# TiDB Cloud yêu cầu SSL
SQLALCHEMY_DATABASE_URI = f"mysql+pymysql://{DB_USERNAME}:{DB_PASSWORD}@{DB_HOST}:{DB_PORT}/{DB_DATABASE}?charset=utf8mb4&ssl_verify_cert=true"

# Flask config
FLASK_HOST = os.getenv('FLASK_HOST', '127.0.0.1')
FLASK_PORT = int(os.getenv('FLASK_PORT', '5000'))
FLASK_DEBUG = os.getenv('FLASK_DEBUG', 'true').lower() == 'true'
