<?php
/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 12/05/2017
 * Time: 11:04
 */

namespace App\Action;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class Action
{
    /** @var EntityRepository */
    private $item_repo;

    /** @var EntityManagerInterface $em */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->item_repo = $em->getRepository(Item::class);
        $this->em = $em;
    }

    /**
     * @return EntityRepository
     */
    public function getItemRepo()
    {
        return $this->item_repo;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEm()
    {
        return $this->em;
    }
}