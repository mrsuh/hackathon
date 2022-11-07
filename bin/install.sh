#!/bin/sh

cd "$( cd `dirname $0` && pwd )/.."

php bin/console doctrine:database:drop --force

php bin/console doctrine:database:create
php bin/console doctrine:schema:create

php bin/console app:init:city
php bin/console app:init:subway
php bin/console app:init:source
php bin/console app:init:pharmacy
