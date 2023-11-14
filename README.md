<<<<<<< HEAD
# Welcome in Drupal 10 project

This is the drupal 10 project main repository. It contains everything to build, run and maintain the drupal8 project main site.

## Repository architecture overview

### Docker folder

The docker folder contains the infrastructure docker files to build a fully running development platform. It includes

* Apache
* MySQL 5.7
* PHP 8.2
* PhpMyAdmin
* Redis
* ElasticSearch 7.17.7
* Kibana 7.10.2
* Maildev

For more information, read `README.md` within this folder

### Sources folder

The `sources` folder contains the website sources in itself. This folder is the one deployed in the various environment. It contains a multi-install Drupal platform built over drupal-composer/drupal-project composer project.

For brief technical insights, read `README.md` within this folder.

### Web folder

Located at `sources/web` is the `web` folder. This folder is from now on called  the _docroot_ folder also known as your _Drupal install base directory_.


## Project first install

Once project is pulled from git, you will notice all sources are stored in `sources` directory. It is advised to use this directory as you [PHPStorm](https://www.jetbrains.com/phpstorm/) IDE project folder.

### 1. Configure your project to use env files.


The project is configured to use a local environment you will be required to create a `.env` file. To do so, please use `.env.example` as a base file:
```
cp .env.example .env
```

Edit the new `.env` file appropriately using your local database credentials.
On local environment your file will have the following variables
```
# Uncomment and populate as needed.
MYSQL_HOSTNAME=mysql
MYSQL_PASSWORD=root
MYSQL_PORT=3306
MYSQL_USER=root

# Databases names
MYSQL_DATABASE=drupal
```

### 2. Install your project environment


In the folder `docker` create a new file named `.env` with the following code inside : 
```
BASE_URL=local
WEBSITE=drupal10
URL_PROJECT=drupal10.localhost
```

And then execute the following command `make init`

### 3. Init your project for frontend development

For new Drupal projects, please use this [blank theme](https://gitlab.lyon.sqli.com/websol/frontend/starter-kit/-/tree/drupal).

* Put starter kit content on Drupal project theme (`sources/web/themes/custom/project_theme`).
* Make sure you have the right version of npm with `nvm use` and then run `npm install`.

## Project pull branch update
Once you have finished your first install and want to pull new update from GIT you have some commands to launch to get correctly all the modifications.
To do it you have two choice :

### 1. Do it manually

In the first place before you pull the last modifications you have to export you own configuration to avoid it to be crushed.
In your docker container on the folder `web/sites/default` you have to execute this command : `../../../vendor/drush/drush/drush cex -y`

Once this command is finish, you can push the new code from GIT, and then execute the following commands :

On your docker container in the folder `web` execute : `composer install`  
Once this command finish in the folder `web/sites/default` execute : `../../../vendor/drush/drush/drush cr`  
Then in the same folder execute the following commands :
*  `../../../vendor/drush/drush/drush updb -y`
*  `../../../vendor/drush/drush/drush cim`

### 2. Do it programmatically

Go inside the `docker` folder and execute this command : 
``` make updateproject ```

Be careful, if you already use the git push command before using this make command, you could have some issues with you update.

## Disable cache on development environment
For disabling cache on your local post you have to create a file named `settings.local.php` in the folder `web/sites/default`
And then put this code in the file : 
```
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';
$settings['cache']['bins']['render'] = 'cache.backend.null';
$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
$settings['cache']['bins']['page'] = 'cache.backend.null';
```

## Code analysis
To ensure good quality code we add some tools to analyse code.

You can use this 'make' commands to verify code for all the website :
``` 
make grumphp
make phpstan
```

## Enable redis cache
To enable redis cache, first you need to enable the [redis](https://www.drupal.org/project/redis) module on drupal.
Then once it's enabled you juste have to add this code in the file `settings.local.php` :
```
$settings['redis.connection']['host'] = 'redis';
$settings['redis.connection']['port'] = 6379;
$settings['cache']['default'] = 'cache.backend.redis';
```

## Use ElascticSearch on Drupal
To use elasticsearch for search API, first you have to enable the [elasticsearch_connector](https://www.drupal.org/project/elasticsearch_connector) module on drupal.
Once it's enabled on Drupal you have to configured it with this url on your cluster:
```
http://localhost:9200
```

## PhpMyAdmin, Kibana and Maildev
You can access to this tools directly with your browser. 
The differents url are :
```
http://phpmyadmin-drupal10.localhost
http://kibana-drupal10.localhost
http://maildev-drupal10.localhost
```# drupalTeste
# drupalTeste
