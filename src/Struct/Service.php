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
    public $DayOfDelivery;

    /**
     * @var DeliveryTimeframe
     */
    public $DeliveryTimeframe;

    /**
     * @var PreferredTime
     */
    public $PreferredTime;

    /**
     * @var IndividualSenderRequirement
     */
    public $IndividualSenderRequirement;

    /**
     * @var PackagingReturn
     */
    public $PackagingReturn;

    /**
     * @var ReturnImmediately
     */
    public $ReturnImmediately;

    /**
     * @var NoticeOfNonDeliverability
     */
    public $NoticeOfNonDeliverability;

    /**
     * @var ShipmentHandling
     */
    public $ShipmentHandling;

    /**
     * @var Endorsement
     */
    public $Endorsement;

    /**
     * @var VisualCheckOfAge
     */
    public $VisualCheckOfAge;

    /**
     * @var PreferredLocation
     */
    public $PreferredLocation;

    /**
     * @var PreferredNeighbour
     */
    public $PreferredNeighbour;

    /**
     * @var PreferredDay
     */
    public $PreferredDay;

    /**
     * @var Perishables
     */
    public $Perishables;

    /**
     * @var Personally
     */
    public $Personally;

    /**
     * @var NoNeighbourDelivery
     */
    public $NoNeighbourDelivery;

    /**
     * @var NamedPersonOnly
     */
    public $NamedPersonOnly;

    /**
     * @var ReturnReceipt
     */
    public $ReturnReceipt;

    /**
     * @var Premium
     */
    public $Premium;

    /**
     * @var CashOnDelivery
     */
    public $CashOnDelivery;

    /**
     * @var AdditionalInsurance
     */
    public $AdditionalInsurance;

    /**
     * @var BulkyGoods
     */
    public $BulkyGoods;

    /**
     * @var IdentCheck
     */
    public $IdentCheck;
}