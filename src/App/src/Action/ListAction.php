<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 09/05/2017
 * Time: 15:54
 */

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class ListAction implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $thingyName = $request->getAttribute('thingy');

        $response = [];
        $json = json_encode($response);
        return new JsonResponse($json);
    }
}