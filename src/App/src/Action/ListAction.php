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
use Swagger as SWG;

/**
 * List all the items of a given type
 *
 * Class ListAction
 * @package App\Action
 *
 * @SWG\Swagger(
 *      @SWG\Info(title="crAPI List Action", version="0.1")
 * )
 */
class ListAction implements MiddlewareInterface
{
    /**
     * @SWG\Get(
     *     path="/{type}",
     *     summary="list items of {type}",
     *     parameters={
     *          @SWG\Parameter(name="type", type="string", required=true, in="path")
     *     },
     *     @SWG\Response(
     *          response=200,
     *          description="A list of strings",
     *          @SWG\Schema(type="array", example="['HELLO WORLD!']")
     *      )
     * )
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $typeName = $request->getAttribute('type');

        $response = [];
        $json = json_encode($response);
        return new JsonResponse($json);
    }
}