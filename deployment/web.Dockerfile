FROM nginx:1.17-alpine

COPY ./public /var/www/public

COPY ./deployment/vhost.conf /etc/nginx/conf.d/default.conf
