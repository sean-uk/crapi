# CRapi

An example of a basic HTTP API based on the [Zend Expressive Skeleton](https://github.com/zendframework/zend-expressive-skeleton).

## Installation

A standard LAMP setup with a VHost pointing at `public/index.php` will do.
Just go to the parent folder and run a plain old `compoer install`

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