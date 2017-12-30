#!/usr/bin/env bash

/etc/init.d/nginx start
/etc/init.d/php5.6-fpm start

chmod a+w -R storage
chmod a+w -R bootstrap/cache

touch remains

tail -f remains