FROM lalyos/rpi-nginx

ADD cloud-config /usr/share/nginx/html/
ADD ipxe /usr/share/nginx/html/
