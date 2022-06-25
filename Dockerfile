FROM php:8.1-apache
WORKDIR /var/www/html
EXPOSE 80
COPY . .
COPY apache2/ /etc/
RUN a2enmod rewrite && a2dissite 000-default && service apache2 restart
RUN useradd -ms /bin/bash admin
RUN chown -R admin:admin /var/www/html
RUN chmod 777 /var/www/html
# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Use development configuration
# RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

USER admin