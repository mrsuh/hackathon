#!/bin/sh

cd "$( cd `dirname $0` && pwd )/.."

composer install --prefer-dist --no-interaction
composer dumpautoload -o

time="$(date +"%s")";
sed -i "s/assets.version: \(.*\)/assets.version: v$time/" app/config/parameters.yml

php bin/console app:init:less --env=prod
php bin/console cache:clear --env=prod
