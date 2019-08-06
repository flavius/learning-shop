#!/usr/bin/env bash

docker run -ti -v /Users/flavius.aspra/workspace/learning-shop:/srv/http:rw --name php-dev --rm -p 9001:9001 -p 80:80 wirecard/php-dev -n
