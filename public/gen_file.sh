#!/usr/bin/env bash

#Usage: sh gen_file.sh <content> <path>

block="$1";
echo "$block" > "${2}";
