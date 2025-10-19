FROM php:8.4-fpm

ARG APP_ENV

ENV UID=33 \
    GID=33

# Install system dependencies, PHP extensions, and clean up in single layer
RUN apt-get update && apt-get clean && apt-get install -y \
        build-essential \
        cron \
        curl \
        gifsicle \
        graphviz \
        libavif-bin \
        libfreetype6-dev \
        libsqlite3-dev \
        libjpeg-dev \
        libonig-dev \
        libpng-dev \
        libpq-dev \
        libsodium-dev \
        libuv1-dev \
        libxml2-dev \
        libzip-dev \
        libicu-dev \
        nginx \
        supervisor \
        unzip \
        zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    pecl install channel://pecl.php.net/uv-0.3.0 && \
    docker-php-ext-install bcmath exif intl mbstring opcache pcntl pdo pdo_sqlite sodium xml zip && \
    docker-php-ext-enable opcache pcntl uv && \
    mkdir -p /var/www/html

# Copy configuration files
COPY .docker/nginx/default.conf /etc/nginx/sites-available/default
COPY .docker/php/conf.d/php.ini /usr/local/etc/php/conf.d/php.ini
COPY .docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY .docker/supervisor/conf.d/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY entrypoint.sh /usr/local/bin/

# Setup entrypoint and cron
RUN chmod 755 /usr/local/bin/entrypoint.sh && \
    ln -s /usr/local/bin/entrypoint.sh / && \
    touch /var/log/cron.log

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY --chown=www-data:www-data . .

# Install dependencies based on environment
RUN echo "Installing dependencies for environment ($APP_ENV)..."

RUN if [ "$APP_ENV" = "local" ]; then \
      pecl install xdebug && \
      docker-php-ext-enable xdebug; \
    fi

RUN echo 'alias a="php artisan"' >> ~/.bashrc

# Setup cron job
COPY .docker/cron/cronjob /etc/cron.d/cronjob

RUN chmod 644 /etc/cron.d/cronjob
RUN crontab /etc/cron.d/cronjob

ENTRYPOINT ["entrypoint.sh"]

CMD ["php-fpm"]
