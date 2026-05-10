#!/bin/bash

echo "=== FashionGZ Startup Script ==="

# Chạy từng migration riêng lẻ, bỏ qua lỗi nếu bảng đã tồn tại
echo ">> Chạy migrations..."
for migration in database/migrations/*.php; do
    php artisan migrate --path="$migration" --force 2>&1 || true
done

# Seed roles & permissions
echo ">> Seed roles & permissions..."
php artisan db:seed --class=RolePermissionSeeder --force 2>&1 || true

# Xóa cache cũ
echo ">> Xóa cache..."
php artisan config:clear 2>&1 || true
php artisan cache:clear 2>&1 || true

echo ">> Khởi động Apache..."
apache2-foreground
