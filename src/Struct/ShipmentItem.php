<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class ShipmentItem
 * @package DanielLarusso\DHL\Struct
 */
class ShipmentItem
{
    /**
     * @var float
     */
    public $weightInKG;

    /**
     * @var float
     */
    public $lengthInCM;

    /**
     * @var float
     */
    public $widthInCM;

    /**
     * @var float
     */
    public $heightInCM;
}