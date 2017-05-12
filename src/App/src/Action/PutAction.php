<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 10/05/2017
 * Time: 09:41
 */

namespace App\Action;

use App\Entity\Item;
use Doctrine\ORM\ORMException;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use TheSeer\Tokenizer\Exception;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Swagger as SWG;
use App\Action\Action;

/**
 * Store an item of a given type under a given ID
 *
 * Class PutAction
 * @package App\Action
 */
class PutAction extends Action implements MiddlewareInterface
{
    /**
     * @SWG\Put(
     *      path="/api/{type}/{id}",
     *      summary="Insert / Update an Item of type {type}",
     *      parameters={
     *          @SWG\Parameter(name="type", type="string", required=true, in="path"),
     *          @SWG\Parameter(name="id", type="string", required=true, in="path")
     *      },
     *      @SWG\Response(
     *          response="default",
     *          description="Whether or not the operation succeeded",
     *          @SWG\Schema(type="boolean")
     *      )
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
        $content = (string) $request->getBody();

        // does it exist already? if so, get that.
        $item = $this->getItemRepo()->findOneBy(['id'=>$id, 'type'=>$typeName]);
        if (!$item) {
            // create a new item
            $item = new Item();
            $item->setId($id);
            $item->setType($typeName);
        }

        // update the value
        $item->setValue($content);

        try {
            $this->getEm()->persist($item);
            $this->getEm()->flush();

            $response = true;
        } catch(ORMException $e) {
            $response = false;
        }

        return new JsonResponse($response);
    }
}