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
 * @SWG\Swagger(
 *      @SWG\Info(title="crAPI - A RESTful(ish) api for CRUD'ing stuff of different 'types'", version="0.1"),
 *      definitions={
 *          @SWG\Definition(
 *              definition="item",
 *              properties={
 *                  @SWG\Property(property="id", type="string", description="An ID string unique to things of this type"),
 *                  @SWG\Property(property="type", type="string", description="The type of the item"),
 *                  @SWG\Property(property="value", type="string", description="The value of this thing")
 *              }
 *          )
 *     }
 * )
 *
 * @see http://zircote.com/swagger-php/
 * @see https://github.com/zircote/swagger-php/blob/master/docs/Getting-started.md
 * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md#operationObject
 */
class ApiDocAction implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $swagger = Swagger\scan(__DIR__);
        return new JsonResponse($swagger);
    }
}