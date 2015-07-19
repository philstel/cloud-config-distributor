FROM resin/rpi-raspbian

RUN apt-get update && apt-get install -y nginx php5-fpm php5-cgi php5-cli php5-common

WORKDIR /tmp
ADD www /var/www
ADD nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD service php5-fpm start && nginx -c /etc/nginx/nginx.conf
