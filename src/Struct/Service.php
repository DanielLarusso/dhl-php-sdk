<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class Service
 * @package DanielLarusso\DHL\Struct
 */
class Service
{
    /**
     * @var DayOfDelivery
     */
    public $dayOfDelivery;

    /**
     * @var DeliveryTimeframe
     */
    public $deliveryTimeframe;

    /**
     * @var PreferredTime
     */
    public $preferredTime;

    /**
     * @var IndividualSenderRequirement
     */
    public $individualSenderRequirement;

    /**
     * @var PackagingReturn
     */
    public $packagingReturn;

    /**
     * @var ReturnImmediately
     */
    public $returnImmediately;

    /**
     * @var NoticeOfNonDeliverability
     */
    public $noticeOfNonDeliverability;

    /**
     * @var ShipmentHandling
     */
    public $shipmentHandling;

    /**
     * @var Endorsement
     */
    public $endorsement;

    /**
     * @var VisualCheckOfAge
     */
    public $visualCheckOfAge;

    /**
     * @var PreferredLocation
     */
    public $preferredLocation;

    /**
     * @var PreferredNeighbour
     */
    public $preferredNeighbour;

    /**
     * @var PreferredDay
     */
    public $preferredDay;

    /**
     * @var Perishables
     */
    public $perishables;

    /**
     * @var Personally
     */
    public $personally;

    /**
     * @var NoNeighbourDelivery
     */
    public $noNeighbourDelivery;

    /**
     * @var NamedPersonOnly
     */
    public $namedPersonOnly;

    /**
     * @var ReturnReceipt
     */
    public $returnReceipt;

    /**
     * @var Premium
     */
    public $premium;

    /**
     * @var CashOnDelivery
     */
    public $cashOnDelivery;

    /**
     * @var AdditionalInsurance
     */
    public $additionalInsurance;

    /**
     * @var BulkyGoods
     */
    public $bulkyGoods;

    /**
     * @var IdentCheck
     */
    public $identCheck;
}