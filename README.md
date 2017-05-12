# CRapi

An example of a basic HTTP API based on the [Zend Expressive Skeleton](https://github.com/zendframework/zend-expressive-skeleton).

## Installation & Config

A standard LAMP setup with a VHost pointing at `public/index.php` will do.
Just go to the parent folder and run a plain old `compoer install`

### Database

You'll need a database compatible with Doctrine ORM. SQLite is suggested for simplicity of setup.

Don't forget to install the appropriate php module, ie; _php-sqlite3_.

Next copy the file `config/autoload/doctrine.local.php.dist` as `config/autoload/doctrine.local.php`,
then you can update the db url as you see fit.

Once that's done, from the project root (ie; the folder composer.json is in) and run `vendor/bin/doctrine orm:schema-tool:create`
to build the schema.

## Usage

Open up your faviourite API Client (ie; Postman / RESTClient) and make a request to "/api" on the VHost you set up.
It will reply with JSON API documentation. You can explore the API's functionality from there!

## What I Did:

This is based on the [Expressive Skeleton Quick Start](http://zendframework.github.io/zend-expressive/getting-started/skeleton/).

1. Add route(s) to config/routes.php
2. Create corresponding action class \App\Action\ListAction 
3. Create a \App\ConfigProvider, along with it's `::__invoke()` method.
4. Add our ConfigProvider to the config setup in config/config.php
5. Add the ListAction as an invokable, as in [Quickstart Next Steps](http://zendframework.github.io/zend-expressive/getting-started/skeleton/#next-steps)

...

6. Start adding some RESTful API documentation using [swagger-php](https://github.com/zircote/swagger-php/blob/master/docs/Getting-started.md).
7. Start setting up [Doctrine ORM for Zend Expressive](https://www.jamestitcumb.com/posts/integrating-doctrine-expressive-easier)