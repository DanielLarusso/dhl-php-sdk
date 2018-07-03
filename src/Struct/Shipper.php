<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class Shipper
 * @package DanielLarusso\DHL\Struct
 */
class Shipper
{
    /**
     * @var Name
     */
    public $name;

    /**
     * @var Address
     */
    public $address;

    /**
     * @var Communication
     */
    public $communication;
}