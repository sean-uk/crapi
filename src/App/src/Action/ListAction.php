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
use App\Action\Action;

/**
 * List all the items of a given type
 *
 * Class ListAction
 * @package App\Action
 */
class ListAction extends Action implements MiddlewareInterface
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
        $typeName = urldecode($request->getAttribute('type'));

        $items = $this->getItemRepo()->findBy(['type'=>$typeName]);
        return new JsonResponse($items);
    }
}