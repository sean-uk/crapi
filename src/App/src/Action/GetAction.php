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
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Item;
use App\Action\Action;

/**
 * Get an item of a particular type by it's ID
 *
 * Class GetAction
 * @package App\Action
 */
class GetAction extends Action implements MiddlewareInterface
{
    /**
     * @SWG\Get(
     *     path="/{type}/{id}",
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
        $typeName = urldecode($request->getAttribute('type'));
        $id = urldecode($request->getAttribute('id'));

        $item = $this->getItemRepo()->findOneBy(['id'=>$id, 'type'=>$typeName]);

        $reponseStatus = $item? 200 : 404;
        return new JsonResponse($item, $reponseStatus);
    }
}