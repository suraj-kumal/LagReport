FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    mbstring \
    bcmath \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --chown=www-data:www-data . /var/www/html

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

RUN chown -R www-data:www-data storage bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

RUN a2enmod rewrite

RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
