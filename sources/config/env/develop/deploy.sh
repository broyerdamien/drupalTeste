#!/usr/bin/env bash

cd /var/www/drupal
composer install
cd web
../vendor/drush/drush/drush cr
../vendor/drush/drush/drush cim -y
../vendor/drush/drush/drush updb -y
