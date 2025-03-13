# Use official PHP image with extensions
FROM php:8.2-fpm

# Install system dependencies
RUN apt update -y && \
    apt install -y \
    zip unzip libzip-dev libpng-dev libicu-dev libpq-dev libmagickwand-dev curl libcurl4-openssl-dev libxml2-dev \
    jpegoptim optipng pngquant gifsicle \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libgd-dev \
    libonig-dev


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install pdo pdo_pgsql zip gd curl soap bcmath pcntl exif

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel project files
COPY app /var/www

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

CMD ["php-fpm"]
