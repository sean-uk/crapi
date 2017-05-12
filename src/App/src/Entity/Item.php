<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use stdClass;

/**
 * Created by PhpStorm.
 * User: sean.james
 * Date: 12/05/2017
 * Time: 10:04
 *
 * @ORM\Entity
 * @ORM\Table(
 *     name="item",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(name="uq_id_type", columns={"id", "type"})
 *     }
 * )
 */
class Item implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="serial", type="integer")
     * @var int
     */
    private $serial;

    /**
     * This is NOT the database row id. It's an Item id which is only unique to items of the same type.
     *
     * @ORM\Column(name="id", type="string", nullable=false)
     * @var string $id
     */
    private $id;

    /**
     * @ORM\Column(name="value", type="string", nullable=false)
     * @var string $value
     */
    private $value;

    /**
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     * @var string $type
     */
    private $type;

    /**
     * @return int
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * @param int $serial
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    function jsonSerialize()
    {
        $object = new stdClass();
        $object->id = $this->id;
        $object->type = $this->type;
        $object->value = $this->value;

        return $object;
    }
}