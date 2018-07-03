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
    public $shipmentDetails;

    /**
     * @var Shipper
     */
    public $shipper;

    /**
     * @var Receiver
     */
    public $receiver;

    /**
     * @var ReturnReceiver
     */
    public $returnReceiver;

    /**
     * @var ExportDocument
     */
    public $exportDocument;
}