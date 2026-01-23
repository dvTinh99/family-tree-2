FROM php:8.4-apache
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@latest
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
COPY .docker/apache/apache-config.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html/

RUN touch /var/www/html/storage/logs/laravel.log && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod 664 /var/www/html/storage/logs/laravel.log

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html
RUN composer install --no-interaction --optimize-autoloader
RUN npm i \
    && npm run build
EXPOSE 80
CMD ["apache2-foreground"]