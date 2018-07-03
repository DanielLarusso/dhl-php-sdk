<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class ShipmentDetails
 * @package DanielLarusso\DHL\Struct
 */
class ShipmentDetails
{
    /**
     * @var string
     */
    public $product;

    /**
     * @var string
     */
    public $accountNumber;

    /**
     * @var string|null
     */
    public $customerReference;

    /**
     * @var string
     */
    public $shipmentDate;

    /**
     * @var string|null
     */
    public $returnShipmentAccountNumber;

    /**
     * @var string|null
     */
    public $returnShipmentReference;

    /**
     * @var ShipmentItem
     */
    public $shipmentItem;

    /**
     * @var Service
     */
    public $service;

    /**
     * @var Notification
     */
    public $notification;

    /**
     * @var BankData
     */
    public $bankData;
}