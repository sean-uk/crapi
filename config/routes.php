<?php
/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Action\HomePageAction::class, 'home');
 * $app->post('/album', App\Action\AlbumCreateAction::class, 'album.create');
 * $app->put('/album/:id', App\Action\AlbumUpdateAction::class, 'album.put');
 * $app->patch('/album/:id', App\Action\AlbumUpdateAction::class, 'album.patch');
 * $app->delete('/album/:id', App\Action\AlbumDeleteAction::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Action\ContactAction::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Action\ContactAction::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
$app->any('/api', App\Action\ApiDocAction::class, 'api.doc');
$app->get('/api/types', App\Action\ListTypesAction::class, 'types.list');
$app->get('/api/{type}', App\Action\ListAction::class, 'type.list');
$app->get('/api/{type}/{id}', App\Action\GetAction::class, 'type.get');
$app->put('/api/{type}/{id}', App\Action\PutAction::class, 'type.put');
$app->delete('/api/{type}/{id}', App\Action\DeleteAction::class, 'type.delete');