#!/bin/sh
# Setting permission of /dev/dio-* devices
/bin/chmod a+rw /dev/dio-*
/usr/sbin/httpd -D FOREGROUND -e debug
