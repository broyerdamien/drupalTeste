# protège les appels aux commandes make xxx
.PHONY: clean restart start stop run

include .env
export

DOCKER_PROJECT = ${BASE_URL}_${WEBSITE}
DOCKER_COMPOSE = -p ${DOCKER_PROJECT} -f docker-compose.yml

UNAME_M = $(shell uname -m)
ifeq ($(UNAME_M), arm64)
	DOCKER_COMPOSE += -f docker-compose.m1.yml
endif

init: build init-drupal install-project
	cd .. && git config core.hooksPath .githooks && git config core.filemode false

start:
	docker-compose ${DOCKER_COMPOSE} start

stop:
	docker-compose ${DOCKER_COMPOSE} stop

restart:
	docker-compose ${DOCKER_COMPOSE} restart

clean: stop
	docker-compose ${DOCKER_COMPOSE} rm -f

build: clean
	docker-compose ${DOCKER_COMPOSE} up -d --remove-orphans --build --force-recreate
	docker-compose ${DOCKER_COMPOSE} exec apache /usr/sbin/a2enmod rewrite
	docker-compose ${DOCKER_COMPOSE} restart apache

init-drupal:
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/projet/ apache composer install
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/ apache composer install
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/ apache chmod a+wX -R web/sites/default
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/ apache php -d memory_limit=-1 vendor/bin/drush site-install sqlidrupal --db-url='mysql://root:root@mysql/drupal' --account-name=admin --account-pass=admin

install-project:
	#docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/web apache ../vendor/bin/drush config-set "system.site" uuid "WEBSITE-UUID" -y
	#docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/web apache ../vendor/bin/drush cr
	#docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/web apache php -d memory_limit=-1 ../vendor/bin/drush cim -y

ps:
	docker-compose ${DOCKER_COMPOSE} ps

logs:
	docker-compose ${DOCKER_COMPOSE} logs -f

updateproject: # update project
	docker-compose ${DOCKER_COMPOSE} exec  -w /var/www/drupal/web apache ../vendor/bin/drush cex
	git checkout $(branch)
	git add ../sources/config/sync
	git reset --hard
	git pull
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/ apache composer install
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/web apache ../vendor/bin/drush cr
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/web apache ../vendor/bin/drush cim
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/web apache ../vendor/bin/drush updb

drush:
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/web apache ../vendor/bin/drush $(command)

import:
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/web apache ../vendor/bin/drush cim

export:
	docker-compose ${DOCKER_COMPOSE} exec  -w /var/www/drupal/web apache ../vendor/bin/drush cex

clear-cache:
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/web apache ../vendor/bin/drush cr

bash:
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/web apache bash

composer-require:
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/ apache composer require $(module)

composer-remove:
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/ apache composer remove $(module)

grumphp:
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/projet/ apache php vendor/phpro/grumphp/bin/grumphp run

phpstan:
	docker-compose ${DOCKER_COMPOSE} exec -w /var/www/drupal/ apache php -d memory_limit=-1 vendor/bin/phpstan.phar
