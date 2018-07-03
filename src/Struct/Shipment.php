<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class Shipment
 * @package DanielLarusso\DHL\Struct
 */
class Shipment
{
    /**
     * @var ShipmentDetails
     */
    public $ShipmentDetails;

    /**
     * @var Shipper
     */
    public $Shipper;

    /**
     * @var Receiver
     */
    public $Receiver;

    /**
     * @var ReturnReceiver
     */
    public $ReturnReceiver;

    /**
     * @var ExportDocument
     */
    public $ExportDocument;
}