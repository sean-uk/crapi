<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 09/05/2017
 * Time: 16:04
 */

namespace App;

use App\Action\DeleteAction;
use App\Action\GetAction;
use App\Action\ListAction;
use App\Action\ListTypesAction;
use App\Action\PutAction;
use App\Action\ActionFactory;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies()
        ];
    }

    public function getDependencies()
    {
        return [
            'factories' => [
                GetAction::class => ActionFactory::class,
                ListAction::class => ActionFactory::class,
                PutAction::class => ActionFactory::class,
                DeleteAction::class => ActionFactory::class,
                ListTypesAction::class => ActionFactory::class,
            ]
        ];
    }
}