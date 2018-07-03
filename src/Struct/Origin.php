<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class Origin
 * @package DanielLarusso\DHL\Struct
 */
class Origin
{
    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $countryISOCode;

    /**
     * @var string
     */
    public $state;
}