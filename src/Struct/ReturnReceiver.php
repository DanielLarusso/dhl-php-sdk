<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class ReturnReceiver
 * @package DanielLarusso\DHL\Struct
 */
class ReturnReceiver
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