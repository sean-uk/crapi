<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 10/05/2017
 * Time: 10:26
 */

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Swagger;

/**
 * Get an API doc response for a given route
 *
 * Class ApiDocAction
 * @package App\Action
 *
 * @see http://zircote.com/swagger-php/
 * @see https://github.com/zircote/swagger-php
 * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#operationObject
 */
class ApiDocAction implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $swagger = Swagger\scan('/var/www/localhost/crAPI/src/App/src/Action/ListAction.php');
        return new JsonResponse($swagger);
    }
}