#!/usr/bin/env bash

#Usage:
# sh gen_ssl_file.sh <proxy_dns> <server_ip>

#TODO: Replace openssl for letsencrypt


mkdir /etc/nginx/ssl 2>/dev/null

PATH_SSL="/etc/nginx/ssl"
PATH_KEY="${PATH_SSL}/${1}.key"
PATH_CSR="${PATH_SSL}/${1}.csr"
PATH_CRT="${PATH_SSL}/${1}.crt"

if [ ! -f $PATH_KEY ] || [ ! -f $PATH_CSR ] || [ ! -f $PATH_CRT ]
then
  openssl genrsa -out "$PATH_KEY" 2048 2>/dev/null
  openssl req -new -key "$PATH_KEY" -out "$PATH_CSR" -subj "/CN=$1/O=UPR/C=CU" 2>/dev/null
  openssl x509 -req -days 365 -in "$PATH_CSR" -signkey "$PATH_KEY" -out "$PATH_CRT" 2>/dev/null
fi

block="server {

    listen 443 ssl;
    server_name $1;

    location / {
      proxy_pass http://${2};
      include /etc/nginx/proxy_params;
      include /etc/nginx/routes/${3}.conf;
    }

    access_log off;
    error_log  /var/log/nginx/$1-error.log error;

    ssl_certificate     /etc/nginx/ssl/$1.crt;
    ssl_certificate_key /etc/nginx/ssl/$1.key;
}
"

echo "$block" > "/etc/nginx/sites-available/$1"
ln -fs "/etc/nginx/sites-available/$1" "/etc/nginx/sites-enabled/$1"
