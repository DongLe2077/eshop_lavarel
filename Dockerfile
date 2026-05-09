# Sử dụng PHP 8.2 với Apache
FROM php:8.2-apache

# Cài đặt các thư viện hệ thống cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip exif bcmath

# Bật mod_rewrite cho Apache (quan trọng cho Laravel)
RUN a2enmod rewrite

# Thay đổi DocumentRoot của Apache sang thư mục public của Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ code vào container
COPY . .

# Cài đặt PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Cài đặt Node.js 18 và npm để build assets
RUN curl -fsSL https://deb.nodesource.com/setup_18.x -o nodesource_setup.sh && \
    bash nodesource_setup.sh && \
    apt-get install -y nodejs && \
    rm nodesource_setup.sh && \
    npm install && \
    npm run build

# Cấp quyền cho thư mục storage và bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Port mặc định của Render là 80 hoặc 10000, Apache mặc định chạy 80
EXPOSE 80

# Chạy Apache ở chế độ foreground
CMD ["apache2-foreground"]
