FROM wordpress:php8.0

COPY --chown=www-data:www-data html/wp-content/. /usr/src/wordpress/wp-content/
