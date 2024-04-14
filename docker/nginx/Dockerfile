FROM nginx:stable-alpine

# Create a directory for the html files on image.
RUN mkdir -p /var/www

# Add default nginx configuration into image.
ADD default.conf /etc/nginx/conf.d/default.conf
