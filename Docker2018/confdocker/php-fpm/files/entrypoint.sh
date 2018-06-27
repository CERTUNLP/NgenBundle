#!/bin/bash

source "/root/.env"

BINARIOS_PATH="$PATH_WEB/binarios";

cd $PATH_WEB/ngen_basic

### deploy

rm -rf app/logs/* app/cache/*;

mkdir -p app/cache app/logs
chgrp -R www-data .
chmod -R g+w app/cache app/logs

# setfacl -R -m u:0:rwx -m u:www-data:rwx  app/cache app/logs  app/Resources/feed/ app/Resources/incident/;
# setfacl -dR -m u:0:rwx -m u:www-data:rwx  app/cache app/logs  app/Resources/feed/ app/Resources/incident/;

php $BINARIOS_PATH/composer.phar install --optimize-autoloader
php app/console cache:clear --env=prod --no-debug
php app/console assetic:dump --env=prod --no-debug
php app/console assets:install --symlink
php app/console braincrafted:bootstrap:install
php app/console braincrafted:bootstrap:generate

chown www-data . -R
