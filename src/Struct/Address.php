<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class Address
 * @package DanielLarusso\DHL\Struct
 */
class Address
{
    /**
     * @var string
     */
    public $name2;

    /**
     * @var string
     */
    public $name3;

    /**
     * @var string
     */
    public $streetName;

    /**
     * @var string
     */
    public $streetNumber;

    /**
     * @var string
     */
    public $addressAddition;

    /**
     * @var string
     */
    public $dispatchingInformation;

    /**
     * @var string
     */
    public $zip;

    /**
     * @var string
     */
    public $city;

    /**
     * @var Origin
     */
    public $Origin;
}