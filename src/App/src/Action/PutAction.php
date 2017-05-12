<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 10/05/2017
 * Time: 09:41
 */

namespace App\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
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
     *      path="type/{type}/put/{id}",
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
        $typeName = $request->getAttribute('type');
        $id = $request->getAttribute('id');
        $content = (string) $request->getBody();

        $response = false;
        $json = json_encode($response);
        return new JsonResponse($json);
    }

}