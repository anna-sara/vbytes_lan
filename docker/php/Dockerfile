FROM php:8.4-apache


## Copy the entire Laravel application code into the container
COPY . /var/www/html

# Apache vhost & entry script
COPY docker/apache/default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/scripts/start.sh /usr/local/bin/start


RUN chown -R www-data:www-data /var/www/html \
    && chmod u+x /usr/local/bin/start \
    && a2enmod rewrite

RUN apt-get update \
    && apt-get install -y gnupg2 zlib1g-dev libzip-dev zlib1g-dev  libicu-dev  libpng-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libxml2-dev curl unzip
RUN docker-php-ext-install zip mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql sodium
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

# Install Node.js and build tools
RUN apt-get update && apt-get install -y --no-install-recommends \
    nodejs \
    npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Add Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer  \
    && composer install --no-interaction --no-progress

# Install Node.js dependencies and build assets
RUN npm install && npm run build

RUN chown -R www-data:www-data /var/www/html


WORKDIR /var/www/html

CMD ["/usr/local/bin/start"]
