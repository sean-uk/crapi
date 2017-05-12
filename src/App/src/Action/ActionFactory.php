<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 12/05/2017
 * Time: 10:56
 */

namespace App\Action;

use Interop\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;

class ActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $className = func_get_arg(1);
        $em = $container->get('doctrine.entity_manager.orm_default');
        return new $className($em);
    }
}