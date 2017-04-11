#!/usr/bin/env bash

block="$1";
echo "$block" > "/etc/nginx/routes/${2}.conf";
