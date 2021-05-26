FROM wordpress:php8.0

COPY html/wp-content/themes/. /var/www/html/wp-content/themes
COPY html/wp-content/plugins/. /var/www/html/wp-content/plugins
