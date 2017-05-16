<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 12/05/2017
 * Time: 10:56
 */

namespace App\Action;

use App\Middleware\ForbiddenWordsFilterMiddleware;
use App\Middleware\SecretHeaderMiddleware;
use Interop\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Stratigility\MiddlewarePipe;

/**
 * This is implementing a route specific middleware pipeline as per {@see https://docs.zendframework.com/zend-expressive/cookbook/route-specific-pipeline/}
 *
 * Class ActionFactory
 * @package App\Action
 */
class ActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $className = func_get_arg(1);
        $em = $container->get('doctrine.entity_manager.orm_default');

        // get the actual middleware this route uses.
        $action = new $className($em);

        // now construct a pipeline which does some standard stuff then the action middleware
        $pipeline = new MiddlewarePipe();
        $pipeline->pipe($container->get(SecretHeaderMiddleware::class));
        $pipeline->pipe($container->get(ForbiddenWordsFilterMiddleware::class));
        $pipeline->pipe($action);

        return $pipeline;
    }
}