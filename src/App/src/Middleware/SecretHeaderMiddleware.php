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
class SecretHeaderMiddleware implements MiddlewareInterface
{
    /**
     * Filter input to API actions and either pass on the request or return an error response
     *
     * @todo the api path rule shouldn't be hard coded like this! make it a config param.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $authed = true;
        $authLines = $request->getHeader('Auth');
        if (!empty($authLines) && $authLines[0]==='false') {
            $authed = false;
        }

        if (!$authed) {
            $response = ['error'=>'Not Authed! Bye!!'];
            return new JsonResponse($response, 401);
        }

        return $delegate->process($request);
    }
}