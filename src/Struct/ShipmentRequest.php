<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class ShipmentRequest
 * @package DanielLarusso\DHL\Struct
 */
class ShipmentRequest
{
    /**
     * @var Version
     */
    public $version;

    /**
     * @var ShipmentOrder
     */
    public $shipmentOrder;
}