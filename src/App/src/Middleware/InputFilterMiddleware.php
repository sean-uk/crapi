<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 12/05/2017
 * Time: 14:52
 */
class InputFilterMiddleware implements MiddlewareInterface
{
    /**
     * Filter input to API actions and either pass on the request or return an error response
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $x = 123;
        return $delegate->process($request);
    }
}