#!/usr/bin/env bash

#Usage:
# sh gen_http_file.sh <proxy_dns> <server_ip>

block="server {
    
    listen 80;
    server_name $1;

    location / {
      proxy_pass http://${2};
      include /etc/nginx/proxy_params;
    }

    access_log off;
    error_log  /var/log/nginx/$1-error.log error;
}
"

echo "$block" > "/etc/nginx/sites-available/$1"
ln -fs "/etc/nginx/sites-available/$1" "/etc/nginx/sites-enabled/$1"
