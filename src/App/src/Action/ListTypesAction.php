<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 12/05/2017
 * Time: 14:05
 */

namespace App\Action;

use App\Action\Action;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swagger as SWG;
use Zend\Diactoros\Response\JsonResponse;
use App\Entity\Item;

class ListTypesAction extends Action implements MiddlewareInterface
{
    /**
     * @SWG\Get(
     *     path="/types",
     *     summary="get a list of types in use",
     *     @SWG\Response(
     *          response="default",
     *          description="An array of types there are Items for",
     *          @SWG\Schema(type="array", @SWG\Items(type="string"))
     *      )
     * )
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return JsonResponse
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $types = $this->getTypes();
        return new JsonResponse($types);
    }

    /**
     * @return array
     */
    protected function getTypes()
    {
        // can't use the repo for this, prepare a custom query.
        $queryBuilder = $this->getEm()->createQueryBuilder();
        $queryBuilder
            ->select('DISTINCT item.type')
            ->from(Item::class, 'item');
        $results = $queryBuilder->getQuery()->execute();

        // compile results into flat array
        $types = [];
        foreach ($results as $result) {
            $types[] = $result['type'];
        }

        return $types;
    }
}