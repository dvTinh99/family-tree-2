# -------- BUILD STAGE --------
FROM webdevops/php-nginx:8.4 AS build

WORKDIR /app

# Install Node.js 22.x (required for modern Vite/Laravel 12 toolchain)
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get update \
    && apt-get install -y --no-install-recommends nodejs \
    && node -v \
    && npm -v \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy full application source into the build stage
COPY . .

# Install PHP dependencies for production
RUN composer install --optimize-autoloader --no-interaction --no-progress

# Install frontend dependencies and build assets (Laravel 12 uses Vite by default)
RUN npm ci \
    && npm run build


# -------- RUNTIME STAGE --------
FROM webdevops/php-nginx:8.4

# Set document root and Laravel env
ENV WEB_DOCUMENT_ROOT=/app/public
ENV WEB_DOCUMENT_INDEX=index.php
ENV APP_DEBUG=false

WORKDIR /app

# Copy built application from the build stage
COPY --from=build /app /app

# Ensure correct permissions for webdevops `application` user
RUN chown -R application:application .