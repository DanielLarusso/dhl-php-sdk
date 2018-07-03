<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;


/**
 * Class ShipmentOrder
 * @package DanielLarusso\DHL\Struct
 */
class ShipmentOrder
{
    /**
     * @var string
     */
    public $sequenceNumber;

    /**
     * @var Shipment
     */
    public $shipment;

    /**
     * @var PrintOnlyIfCodeable
     */
    public $printOnlyIfCodeable;

    /**
     * @var string
     */
    public $labelResponseType;
}