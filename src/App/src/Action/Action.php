<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 12/05/2017
 * Time: 11:04
 */

namespace App\Action;

use Doctrine\ORM\EntityManagerInterface;

class Action
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}