<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 10/05/2017
 * Time: 09:41
 */

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Store an item of a given type under a given ID
 *
 * Class PutAction
 * @package App\Action
 */
class PutAction implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $typeName = $request->getAttribute('type');
        $id = $request->getAttribute('id');
        $content = (string) $request->getBody();

        $response = false;
        $json = json_encode($response);
        return new JsonResponse($json);
    }

}