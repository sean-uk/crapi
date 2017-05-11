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
 */
class ListAction implements MiddlewareInterface
{
    /**
     * @SWG\Get(
     *     path="/type/{type}/list",
     *     summary="list items of {type}",
     *     parameters={
     *          @SWG\Parameter(name="type", type="string", required=true, in="path")
     *     },
     *     @SWG\Response(
     *          response=200,
     *          description="A list of Items",
     *          @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/item"))
     *      ),
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