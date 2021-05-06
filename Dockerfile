FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - && \
	apt-get install -yq nodejs build-essential && \
	npm install -g npm

RUN a2enmod rewrite

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/oe40
COPY ./ ./

RUN composer global require "laravel/installer" && \
	composer install

RUN npm install && npm run dev

CMD ["apache2-foreground"]
