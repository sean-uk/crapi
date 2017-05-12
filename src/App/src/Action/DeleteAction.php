<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 12/05/2017
 * Time: 13:17
 */

namespace App\Action;

use App\Action\Action;
use Doctrine\ORM\ORMException;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swagger as SWG;
use Zend\Diactoros\Response\JsonResponse;

class DeleteAction extends Action implements MiddlewareInterface
{
    /**
     * @SWG\Delete(
     *      path="/api/{type}/{id}",
     *      parameters={
     *          @SWG\Parameter(name="type", type="string", required=true, in="path"),
     *          @SWG\Parameter(name="id", type="string", required=true, in="path"),
     *      },
     *     @SWG\Response(
     *          response="default",
     *          description="true if the item was deleted or didn't exist to begin with.",
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

        // does it actally exist? if not, return a false status
        // (@todo surely there's a way to do this without fetching the whole thing?)
        $existing = $this->getItemRepo()->findOneBy(['type'=>$typeName, 'id'=>$id]);
        $response = true;
        if ($existing) {
            try {
                $this->getEm()->remove($existing);
                $this->getEm()->flush($existing);
                $response = true;
            } catch(ORMException $e) {
                $response = false;
            }
        }

        return new JsonResponse($response);
    }
}