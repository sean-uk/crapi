<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 15/05/2017
 * Time: 16:56
 */

namespace App\Middleware;

use Interop\Container\ContainerInterface;

class ForbiddenWordsFilterFactory
{
    /**
     * @param ContainerInterface $container
     * @return ForbiddenWordsFilterMiddleware
     */
    public function __invoke(ContainerInterface $container)
    {
        $forbiddenWords = [];
        $config = $container->get('config');
        if (isset($config['forbidden_words'])) {
            $forbiddenWords = $config['forbidden_words'];
        }
        $filter = new ForbiddenWordsFilterMiddleware($forbiddenWords);
        return $filter;
    }
}