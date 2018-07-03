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
    public $Shipment;

    /**
     * @var PrintOnlyIfCodeable
     */
    public $PrintOnlyIfCodeable;

    /**
     * @var string
     */
    public $labelResponseType;
}