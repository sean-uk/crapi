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

### Dummy Auth Header

A dummy auth header middleware has been added to the api routes. 
To try it out, add a header in your request called "Auth", with the value simply "false".  

### 'Forbidden Words'

As an example of input filtering middleware, the app checks api input against the list in the config setting `forbidden_words`
You can copy `config/autoload/forbidden-words.local.php.dist` as `config/autoload/forbidden-words.local.php` and define it there if you like.

Forbidden words in the URI params will result in an error response, but if they're in the request body they'll just be 
replaced with asterisks.

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

...

8. Configure [route-specific middleware](https://docs.zendframework.com/zend-expressive/cookbook/route-specific-pipeline/) for authentication.

...

9. Add an additional piece of input filter / validator middleware \App\Middleware\ForbiddenWordsFilterMiddleware.

...

10. Begin adding [PHPUnit](https://phpunit.de/) tests using [Phake](http://phake.readthedocs.io/en/2.1/introduction.html) for cleaner mocking.