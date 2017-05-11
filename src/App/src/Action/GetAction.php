<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 10/05/2017
 * Time: 09:34
 */

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Swagger as SWG;

/**
 * Get an item of a particular type by it's ID
 *
 * Class GetAction
 * @package App\Action
 */
class GetAction implements MiddlewareInterface
{
    /**
     * @SWG\Get(
     *     path="/type/{type}/get/{id}",
     *     summary="Get Item {id} of the type {type}, if it exists.",
     *     parameters={
     *          @SWG\Parameter(name="type", type="string", required=true, in="path"),
     *          @SWG\Parameter(name="id", type="string", required=true, in="path")
     *     },
     *     @SWG\Response(
     *          response=200,
     *          description="An Item",
     *          @SWG\Schema(ref="#/definitions/item")
     *     ),
     *     @SWG\Response(
     *          response=404,
     *          description="Item not found."
     *     )
     * )
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return JsonResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $typeName = $request->getAttribute('type');
        $id = $request->getAttribute('id');

        $response = false;
        $json = json_encode($response);
        return new JsonResponse($json);
    }
}