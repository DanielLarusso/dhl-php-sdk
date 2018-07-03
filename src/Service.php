<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class Service
 */
class Service
{
    /**
     * Contains if the Shipment should delivered on a specific Day
     *
     * Note: Optional
     * Available for:
     *  ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
     *  DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
     *
     * @var bool|null $dayOfDeliveryEnabled - Is this enabled | null uses default
     */
    private $dayOfDeliveryEnabled;

    /**
     * Contains the Day, when the Shipment should be delivered
     *
     * Note: Optional|ISO-Date-Format (YYYY-MM-DD)|Required if $dayOfDeliveryEnabled
     * Available for:
     *  DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
     *  DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
     * Min-Len: 10
     * Max-Len: 10
     *
     * @var string|null $dayOfDeliveryDate - Delivery-Date
     */
    private $dayOfDeliveryDate;

    /**
     * Contains if the Shipment should be delivered on a specific Time-Frame
     *
     * Note: Optional
     * Available for:
     *  DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
     *  DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
     *
     * @var bool|null $deliveryTimeframeEnabled - Is this enabled | null uses default
     */
    private $deliveryTimeframeEnabled;

    /**
     * Contains the Time-Frame when the Shipment should be delivered
     *
     * Note: Optional|Required if $deliveryTimeframeEnabled
     * Write the Values like this 10:00 - 12:30 => (Correct Value) 10001230
     * or 9:13 - 10:00 => 09131000
     * or 16:00 - 19:00 => 16001900
     * Available for:
     *  DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
     *  DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
     * Min-Len: 8
     * Max-Len: 8
     *
     * @var string|null $deliveryTimeframe - Time-Frame for delivery
     */
    private $deliveryTimeframe;

    /**
     * Contains if preferred delivery Time is enabled
     *
     * Note: Optional
     * Available for:
     *  DHL_ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE
     *  DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE
     *
     * @var bool|null $preferredTimeEnabled - Is this enabled | null uses default
     */
    private $preferredTimeEnabled;

    /**
     * Contains the preferred delivery Time-Frame
     *
     * Note: Optional|Required if $preferredTimeEnabled
     * Write the Values like this 10:00 - 12:30 => (Correct Value) 10001230
     * or 9:13 - 10:00 => 09131000
     * or 16:00 - 19:00 => 16001900
     * Available for:
     *  DHL_ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE
     *  DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE
     * Min-Len: 8
     * Max-Len: 8
     *
     * @var string|null $preferredTime - Preferred delivery Time-Frame
     */
    private $preferredTime;

    /**
     * Contains if an individual sender requirement is enabled (and required)
     *
     * Note: Optional
     * Available for:
     *  DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
     *  DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
     *
     * @var bool|null $individualSenderRequirementsEnabled - Is this enabled | null uses default
     */
    private $individualSenderRequirementsEnabled;

    /**
     * Contains the Requirement (Free text)
     *
     * Note: Optional|Required if $individualSenderRequirementsEnabled
     * Available for:
     *  DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
     *  DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
     * Min-Len: 1
     * Max-Len: 250
     *
     * @var string|null $individualSenderRequirementsText - Sender Requirement (Free text)
     */
    private $individualSenderRequirementsText;

    /**
     * Contains if Packaging return is enabled
     *
     * Note: Optional
     *
     * @var bool|null $packagingReturn - Is this enabled | null uses default
     */
    private $packagingReturn;

    /**
     * Contains if return immediately if the Shipment failed
     *
     * Note: Optional
     * Available for:
     *  DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE
     *
     * @var bool|null $returnImmediatelyIfShipmentFailed - Is this enabled | null uses default
     */
    private $returnImmediatelyIfShipmentFailed;

    /**
     * Contains if Notice on Non-Deliverable is enabled
     *
     * Note: Optional
     *
     * @var bool|null $noticeNonDeliverability - Is this enabled | null uses default
     */
    private $noticeNonDeliverability;

    /**
     * Contains if Shipment-Handling is enabled
     *
     * Note: Optional
     * Available for:
     *  DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
     *  DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
     *
     * @var bool|null $shipmentHandlingEnabled - Is this enabled | null uses default
     */
    private $shipmentHandlingEnabled;

    /**
     * Contains the Shipment-Handling Type
     *
     * Note: Optional|Required if $shipmentHandlingEnabled
     * Available for:
     *  DHL_ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER
     *  DHL_ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
     * Min-Len: 1
     * Max-Len: 1
     *
     * There are the following types are allowed:
     * a: Remove content, return box;
     * b: Remove content, pick up and dispose cardboard packaging;
     * c: Handover parcel/box to customer ¿ no disposal of cardboar.d/box;
     * d: Remove bag from of cooling unit and handover to customer;
     * e: Remove content, apply return label und seal box, return box
     *
     * @var string|null $shipmentHandlingType - Shipment-Handling Type
     */
    private $shipmentHandlingType;

    /**
     * Contains if the Service "Endorsement" is enabled
     *
     * Note: Optional
     *
     * @var bool|null $endorsementEnabled - Is this enabled | null uses default
     */
    private $endorsementEnabled;

    /**
     * Contains the Type for the "Endorsement"-Service
     *
     * Note: Optional|Required if $endorsementEnabled
     *
     * for national:
     *  SOZU (Return immediately),
     *  ZWZU (2nd attempt of Delivery);
     * for International:
     *  IMMEDIATE (Sending back immediately to sender),
     *  AFTER_DEADLINE (Sending back immediately to sender after expiration of time),
     *  ABANDONMENT (Abandonment of parcel at the hands of sender (free of charge))
     *
     * @var string|null $endorsementType - Endorsement-Service Type
     */
    private $endorsementType;

    /**
     * Contains if Age-Check is enabled
     *
     * Note: Optional
     *
     * @var bool|null $visualCheckOfAgeEnabled - Is this enabled | null uses default
     */
    private $visualCheckOfAgeEnabled;

    /**
     * Contains the Age that the Receiver should be at least
     *
     * Note: Optional|Required if $visualCheckOfAgeEnabled
     * Min-Len: 3
     * Max-Len: 3
     *
     * There are the following types are allowed:
     * A16
     * A18
     *
     * @var string|null $visualCheckOfAgeType - Minimum-Age of the Receiver
     */
    private $visualCheckOfAgeType;

    /**
     * Contains if preferred Location is enabled
     *
     * Note: Optional
     *
     * @var bool|null $preferredLocationEnabled - Is this enabled | null uses default
     */
    private $preferredLocationEnabled;

    /**
     * Contains details of the preferred Location (Free text)
     *
     * Note: Optional|Required if $preferredLocationEnabled
     * Min-Len: 1
     * Max-Len: 100
     *
     * @var string|null $preferredLocationDetails - Details of the preferred Location (Free text)
     */
    private $preferredLocationDetails;

    /**
     * Contains if preferred Neighbour is enabled
     *
     * Note: Optional
     *
     * @var bool|null $preferredNeighbourEnabled - Is this enabled | null uses default
     */
    private $preferredNeighbourEnabled;

    /**
     * Contains the details of the preferred Neighbour (Free text)
     *
     * Note: Optional|Required if $preferredNeighbourEnabled
     * Min-Len: 1
     * Max-Len: 100
     *
     * @var string|null $preferredNeighbourText - Details of the preferred Neighbour (Free text)
     */
    private $preferredNeighbourText;

    /**
     * Contains if preferred Day is enabled
     *
     * Note: Optional
     *
     * @var bool|null $preferredDayEnabled - Is this enabled | null uses default
     */
    private $preferredDayEnabled;

    /**
     * Contains the details of the preferred Day (Free text)
     *
     * Note: Optional|Required if $preferredDayEnabled
     * Min-Len: 1
     * Max-Len: 100
     *
     * @var string|null $preferredDayText - Details of the preferred Day (Free text)
     */
    private $preferredDayText;

    /**
     * Contains if GoGreen is enabled
     *
     * Note: Optional|Version 1 ONLY
     *
     * @var bool|null $goGreen - Is this enabled | null uses default
     */
    private $goGreen;

    /**
     * Contains if deliver Perishables
     *
     * Note: Optional
     *
     * @var bool|null $perishables - Is this enabled | null uses default
     */
    private $perishables;

    /**
     * Contains if personal handover is enabled
     *
     * Note: Optional
     *
     * @var bool|null $personalHandover - Is this enabled | null uses default
     */
    private $personalHandover;

    /**
     * Contains if Neighbour delivery is disabled
     *
     * Note: Optional
     *
     * @var bool|null $disableNeighbourDelivery - Is this enabled | null uses default
     */
    private $disableNeighbourDelivery;

    /**
     * Contains if named Person can only accept delivery
     *
     * Note: Optional
     *
     * @var bool|null $namedPersonOnly - Is this enabled | null uses default
     */
    private $namedPersonOnly;

    /**
     * Contains if return receipt is enabled
     *
     * Note: Optional
     *
     * @var bool|null $returnReceipt - Is this enabled | null uses default
     */
    private $returnReceipt;

    /**
     * Contains if Premium is enabled (for fast and safe delivery of international shipments)
     *
     * Note: Optional
     *
     * @var bool|null $premium - Is this enabled | null uses default
     */
    private $premium;

    /**
     * Contains if cash on delivery is enabled
     *
     * Note: Optional
     *
     * @var bool|null $cashOnDeliveryEnabled - Is this enabled | null uses default
     */
    private $cashOnDeliveryEnabled;

    /**
     * Contains if the "AddFee" is enabled
     * Explanation from DHL: (COD = CashOnDelivery)
     * Configuration whether the transmission fee to be added to the COD amount or not by DHL.
     * Select the option then the new COD amount will automatically printed on the shipping label and will transferred
     * to the end of the day to DHL. Do not select the option and the specified COD amount remains unchanged.
     *
     * Note: Optional
     *
     * @var bool|null $cashOnDeliveryAddFee - Is this enabled | null uses default
     */
    private $cashOnDeliveryAddFee;

    /**
     * Contains the Amount how much the receiver must pay
     * Explanation from DHL: (COD = CashOnDelivery)
     * Money amount to be collected. Mandatory if COD is chosen.
     * Attention: Please add the additional 2 EURO transmittal fee when entering the COD Amount
     *
     * Note: Optional|Required if $cashOnDeliveryEnabled
     *
     * @var float|null $cashOnDeliveryAmount - CashOnDelivery Amount
     */
    private $cashOnDeliveryAmount;

    /**
     * Contains if the Shipment is insured with a higher standard
     *
     * Note: Optional
     *
     * @var bool|null $additionalInsuranceEnabled - Is this enabled | null uses default
     */
    private $additionalInsuranceEnabled;

    /**
     * Contains the Amount with that the Shipment is insured
     *
     * Note: Optional|Required if $additionalInsuranceEnabled
     *
     * @var float|null $additionalInsuranceAmount - Insure-Amount
     */
    private $additionalInsuranceAmount;

    /**
     * Contains if you deliver Bulky-Goods
     *
     * Note: Optional
     *
     * @var bool|null $bulkyGoods - Is this enabled | null uses default
     */
    private $bulkyGoods;

    /**
     * Contains if the Ident-Check is enabled
     *
     * Note: Optional
     *
     * @var bool|null $identCheckEnabled - Is this enabled | null uses default
     */
    private $identCheckEnabled;

    /**
     * Contains the Ident-Check Object
     *
     * Note: Optional|Required if $indentCheckEnabled
     *
     * @var IdentCheck|null $identCheckObj - Ident-Check Object
     */
    private $identCheckObj;

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        unset(
            $this->dayOfDeliveryEnabled,
            $this->dayOfDeliveryDate,
            $this->deliveryTimeframeEnabled,
            $this->deliveryTimeframe,
            $this->preferredTimeEnabled,
            $this->preferredTime,
            $this->individualSenderRequirementsEnabled,
            $this->individualSenderRequirementsText,
            $this->packagingReturn,
            $this->returnImmediatelyIfShipmentFailed,
            $this->noticeNonDeliverability,
            $this->shipmentHandlingEnabled,
            $this->shipmentHandlingType,
            $this->endorsementEnabled,
            $this->endorsementType,
            $this->visualCheckOfAgeEnabled,
            $this->visualCheckOfAgeType,
            $this->preferredLocationEnabled,
            $this->preferredLocationDetails,
            $this->preferredNeighbourEnabled,
            $this->preferredNeighbourText,
            $this->preferredDayEnabled,
            $this->preferredDayText,
            $this->goGreen,
            $this->perishables,
            $this->personalHandover,
            $this->disableNeighbourDelivery,
            $this->namedPersonOnly,
            $this->returnReceipt,
            $this->premium,
            $this->cashOnDeliveryEnabled,
            $this->cashOnDeliveryAddFee,
            $this->cashOnDeliveryAmount,
            $this->additionalInsuranceEnabled,
            $this->additionalInsuranceAmount,
            $this->bulkyGoods,
            $this->identCheckEnabled,
            $this->identCheckObj
        );
    }

    /**
     * @return bool|null
     */
    public function getDayOfDeliveryEnabled(): ?bool
    {
        return $this->dayOfDeliveryEnabled;
    }

    /**
     * @param bool|null $dayOfDeliveryEnabled
     * @return Service
     */
    public function setDayOfDeliveryEnabled(?bool $dayOfDeliveryEnabled): Service
    {
        $this->dayOfDeliveryEnabled = $dayOfDeliveryEnabled;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDayOfDeliveryDate(): ?string
    {
        return $this->dayOfDeliveryDate;
    }

    /**
     * @param null|string $dayOfDeliveryDate
     * @return Service
     */
    public function setDayOfDeliveryDate(?string $dayOfDeliveryDate)
    {
        $this->dayOfDeliveryDate = $dayOfDeliveryDate;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDeliveryTimeframeEnabled()
    {
        return $this->deliveryTimeframeEnabled;
    }

    /**
     * @param bool|null $deliveryTimeframeEnabled
     * @return Service
     */
    public function setDeliveryTimeframeEnabled(?bool $deliveryTimeframeEnabled): Service
    {
        $this->deliveryTimeframeEnabled = $deliveryTimeframeEnabled;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDeliveryTimeframe(): ?string
    {
        return $this->deliveryTimeframe;
    }

    /**
     * @param null|string $deliveryTimeframe
     * @return Service
     */
    public function setDeliveryTimeframe(?string $deliveryTimeframe): Service
    {
        $this->deliveryTimeframe = $deliveryTimeframe;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPreferredTimeEnabled(): ?bool
    {
        return $this->preferredTimeEnabled;
    }

    /**
     * @param bool|null $preferredTimeEnabled
     * @return Service
     */
    public function setPreferredTimeEnabled(?bool $preferredTimeEnabled): Service
    {
        $this->preferredTimeEnabled = $preferredTimeEnabled;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPreferredTime(): ?string
    {
        return $this->preferredTime;
    }

    /**
     * @param null|string $preferredTime
     * @return Service
     */
    public function setPreferredTime(?string $preferredTime): Service
    {
        $this->preferredTime = $preferredTime;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIndividualSenderRequirementsEnabled(): ?bool
    {
        return $this->individualSenderRequirementsEnabled;
    }

    /**
     * @param bool|null $individualSenderRequirementsEnabled
     * @return Service
     */
    public function setIndividualSenderRequirementsEnabled(?bool $individualSenderRequirementsEnabled): Service
    {
        $this->individualSenderRequirementsEnabled = $individualSenderRequirementsEnabled;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getIndividualSenderRequirementsText(): ?string
    {
        return $this->individualSenderRequirementsText;
    }

    /**
     * @param null|string $individualSenderRequirementsText
     * @return Service
     */
    public function setIndividualSenderRequirementsText(?string $individualSenderRequirementsText): Service
    {
        $this->individualSenderRequirementsText = $individualSenderRequirementsText;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPackagingReturn(): ?bool
    {
        return $this->packagingReturn;
    }

    /**
     * @param bool|null $packagingReturn
     * @return Service
     */
    public function setPackagingReturn(?bool $packagingReturn): Service
    {
        $this->packagingReturn = $packagingReturn;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getReturnImmediatelyIfShipmentFailed(): ?bool
    {
        return $this->returnImmediatelyIfShipmentFailed;
    }

    /**
     * @param bool|null $returnImmediatelyIfShipmentFailed
     * @return Service
     */
    public function setReturnImmediatelyIfShipmentFailed(?bool $returnImmediatelyIfShipmentFailed): Service
    {
        $this->returnImmediatelyIfShipmentFailed = $returnImmediatelyIfShipmentFailed;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getNoticeNonDeliverability(): ?bool
    {
        return $this->noticeNonDeliverability;
    }

    /**
     * @param bool|null $noticeNonDeliverability
     * @return Service
     */
    public function setNoticeNonDeliverability(?bool $noticeNonDeliverability): Service
    {
        $this->noticeNonDeliverability = $noticeNonDeliverability;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getShipmentHandlingEnabled(): ?bool
    {
        return $this->shipmentHandlingEnabled;
    }

    /**
     * @param bool|null $shipmentHandlingEnabled
     * @return Service
     */
    public function setShipmentHandlingEnabled(?bool $shipmentHandlingEnabled): Service
    {
        $this->shipmentHandlingEnabled = $shipmentHandlingEnabled;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShipmentHandlingType(): ?string
    {
        return $this->shipmentHandlingType;
    }

    /**
     * @param null|string $shipmentHandlingType
     * @return Service
     */
    public function setShipmentHandlingType(?string $shipmentHandlingType): Service
    {
        $this->shipmentHandlingType = $shipmentHandlingType;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getEndorsementEnabled(): ?bool
    {
        return $this->endorsementEnabled;
    }

    /**
     * @param bool|null $endorsementEnabled
     * @return Service
     */
    public function setEndorsementEnabled(?bool $endorsementEnabled): Service
    {
        $this->endorsementEnabled = $endorsementEnabled;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEndorsementType(): ?string
    {
        return $this->endorsementType;
    }

    /**
     * @param null|string $endorsementType
     * @return Service
     */
    public function setEndorsementType(?string $endorsementType): Service
    {
        $this->endorsementType = $endorsementType;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getVisualCheckOfAgeEnabled(): ?bool
    {
        return $this->visualCheckOfAgeEnabled;
    }

    /**
     * @param bool|null $visualCheckOfAgeEnabled
     * @return Service
     */
    public function setVisualCheckOfAgeEnabled(?bool $visualCheckOfAgeEnabled): Service
    {
        $this->visualCheckOfAgeEnabled = $visualCheckOfAgeEnabled;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getVisualCheckOfAgeType(): ?string
    {
        return $this->visualCheckOfAgeType;
    }

    /**
     * @param null|string $visualCheckOfAgeType
     * @return Service
     */
    public function setVisualCheckOfAgeType(?string $visualCheckOfAgeType): Service
    {
        $this->visualCheckOfAgeType = $visualCheckOfAgeType;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPreferredLocationEnabled(): ?bool
    {
        return $this->preferredLocationEnabled;
    }

    /**
     * @param bool|null $preferredLocationEnabled
     * @return Service
     */
    public function setPreferredLocationEnabled(?bool $preferredLocationEnabled): Service
    {
        $this->preferredLocationEnabled = $preferredLocationEnabled;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPreferredLocationDetails(): ?string
    {
        return $this->preferredLocationDetails;
    }

    /**
     * @param null|string $preferredLocationDetails
     * @return Service
     */
    public function setPreferredLocationDetails(?string $preferredLocationDetails): Service
    {
        $this->preferredLocationDetails = $preferredLocationDetails;
    }

    /**
     * @return bool|null
     */
    public function getPreferredNeighbourEnabled(): ?bool
    {
        return $this->preferredNeighbourEnabled;
    }

    /**
     * @param bool|null $preferredNeighbourEnabled
     * @return Service
     */
    public function setPreferredNeighbourEnabled(?bool $preferredNeighbourEnabled): Service
    {
        $this->preferredNeighbourEnabled = $preferredNeighbourEnabled;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPreferredNeighbourText(): ?string
    {
        return $this->preferredNeighbourText;
    }

    /**
     * @param null|string $preferredNeighbourText
     * @return Service
     */
    public function setPreferredNeighbourText(?string $preferredNeighbourText): Service
    {
        $this->preferredNeighbourText = $preferredNeighbourText;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPreferredDayEnabled(): ?bool
    {
        return $this->preferredDayEnabled;
    }

    /**
     * @param bool|null $preferredDayEnabled
     * @return Service
     */
    public function setPreferredDayEnabled(?bool $preferredDayEnabled): Service
    {
        $this->preferredDayEnabled = $preferredDayEnabled;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPreferredDayText(): ?string
    {
        return $this->preferredDayText;
    }

    /**
     * @param null|string $preferredDayText
     * @return Service
     */
    public function setPreferredDayText(?string $preferredDayText): Service
    {
        $this->preferredDayText = $preferredDayText;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getGoGreen(): ?bool
    {
        return $this->goGreen;
    }

    /**
     * @param bool|null $goGreen
     * @return Service
     */
    public function setGoGreen(?bool $goGreen): Service
    {
        $this->goGreen = $goGreen;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPerishables(): ?bool
    {
        return $this->perishables;
    }

    /**
     * @param bool|null $perishables
     * @return Service
     */
    public function setPerishables(?bool $perishables): Service
    {
        $this->perishables = $perishables;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPersonalHandover(): ?bool
    {
        return $this->personalHandover;
    }

    /**
     * @param bool|null $personalHandover
     * @return Service
     */
    public function setPersonalHandover(?bool $personalHandover): Service
    {
        $this->personalHandover = $personalHandover;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getDisableNeighbourDelivery(): ?bool
    {
        return $this->disableNeighbourDelivery;
    }

    /**
     * @param bool|null $disableNeighbourDelivery
     * @return Service
     */
    public function setDisableNeighbourDelivery(?bool $disableNeighbourDelivery): Service
    {
        $this->disableNeighbourDelivery = $disableNeighbourDelivery;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getNamedPersonOnly(): ?bool
    {
        return $this->namedPersonOnly;
    }

    /**
     * @param bool|null $namedPersonOnly
     * @return Service
     */
    public function setNamedPersonOnly(?bool $namedPersonOnly): Service
    {
        $this->namedPersonOnly = $namedPersonOnly;
    }

    /**
     * @return bool|null
     */
    public function getReturnReceipt(): ?bool
    {
        return $this->returnReceipt;
    }

    /**
     * @param bool|null $returnReceipt
     * @return Service
     */
    public function setReturnReceipt(?bool $returnReceipt): Service
    {
        $this->returnReceipt = $returnReceipt;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPremium(): ?bool
    {
        return $this->premium;
    }

    /**
     * @param bool|null $premium
     * @return Service
     */
    public function setPremium(?bool $premium): Service
    {
        $this->premium = $premium;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getCashOnDeliveryEnabled(): ?bool
    {
        return $this->cashOnDeliveryEnabled;
    }

    /**
     * @param bool|null $cashOnDeliveryEnabled
     * @return Service
     */
    public function setCashOnDeliveryEnabled(?bool $cashOnDeliveryEnabled): Service
    {
        $this->cashOnDeliveryEnabled = $cashOnDeliveryEnabled;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getCashOnDeliveryAddFee(): ?bool
    {
        return $this->cashOnDeliveryAddFee;
    }

    /**
     * @param bool|null $cashOnDeliveryAddFee
     * @return Service
     */
    public function setCashOnDeliveryAddFee(?bool $cashOnDeliveryAddFee): Service
    {
        $this->cashOnDeliveryAddFee = $cashOnDeliveryAddFee;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getCashOnDeliveryAmount(): ?float
    {
        return $this->cashOnDeliveryAmount;
    }

    /**
     * @param float|null $cashOnDeliveryAmount
     * @return Service
     */
    public function setCashOnDeliveryAmount(?float $cashOnDeliveryAmount): Service
    {
        $this->cashOnDeliveryAmount = $cashOnDeliveryAmount;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAdditionalInsuranceEnabled(): ?bool
    {
        return $this->additionalInsuranceEnabled;
    }

    /**
     * @param bool|null $additionalInsuranceEnabled
     * @return Service
     */
    public function setAdditionalInsuranceEnabled(?bool $additionalInsuranceEnabled): Service
    {
        $this->additionalInsuranceEnabled = $additionalInsuranceEnabled;
    }

    /**
     * @return float|null
     */
    public function getAdditionalInsuranceAmount(): ?float
    {
        return $this->additionalInsuranceAmount;
    }

    /**
     * @param float|null $additionalInsuranceAmount
     * @return Service
     */
    public function setAdditionalInsuranceAmount(?float $additionalInsuranceAmount): Service
    {
        $this->additionalInsuranceAmount = $additionalInsuranceAmount;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getBulkyGoods(): ?bool
    {
        return $this->bulkyGoods;
    }

    /**
     * @param bool|null $bulkyGoods
     * @return Service
     */
    public function setBulkyGoods(?bool $bulkyGoods): Service
    {
        $this->bulkyGoods = $bulkyGoods;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIdentCheckEnabled(): ?bool
    {
        return $this->identCheckEnabled;
    }

    /**
     * @param bool|null $identCheckEnabled
     * @return Service
     */
    public function setIdentCheckEnabled(?bool $identCheckEnabled): Service
    {
        $this->identCheckEnabled = $identCheckEnabled;
    }

    /**
     * @return IdentCheck|null
     */
    public function getIdentCheckObj(): ?IdentCheck
    {
        return $this->identCheckObj;
    }

    /**
     * @param IdentCheck|null $identCheckObj
     * @return Service
     */
    public function setIdentCheckObj(?IdentCheck $identCheckObj): Service
    {
        $this->identCheckObj = $identCheckObj;

        return $this;
    }

    /**
     * Get the Class of this Service-Object
     *
     * @param string $productType - Type of the Product
     * @return \stdClass - Service-DHL-Class
     */
    public function getServiceClass_v1(string $productType): \stdClass
    {
        //todo implement getClass_v1()
        return new \stdClass;
    }

    /**
     * Get the Class of this Service-Object
     *
     * @param string $productType - Type of the Product
     * @return \stdClass - Service-DHL-Class
     */
    public function getServiceClass_v2(string $productType): \stdClass
    {
        /** @var \stdClass $class */
        $class = new \stdClass;

        if (null !== $this->getDayOfDeliveryEnabled() && \in_array($productType, [
                ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
                ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
            ], true)) {
            $class->DayOfDelivery = new \stdClass;
            $class->DayOfDelivery->active = (int)$this->getDayOfDeliveryEnabled();
            $class->DayOfDelivery->details = $this->getDayOfDeliveryDate();
        }

        if (null !== $this->getDeliveryTimeframeEnabled() && \in_array($productType, [
                ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
                ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
            ], true)) {
            $class->DeliveryTimeframe = new \stdClass;
            $class->DeliveryTimeframe->active = (int)$this->getDeliveryTimeframeEnabled();
            $class->DeliveryTimeframe->type = $this->getDeliveryTimeframe();
        }

        if (null !== $this->getPreferredTimeEnabled() && \in_array($productType, [
                ShipmentDetails::PRODUCT_TYPE_NATIONAL_PACKAGE,
                ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE
            ], true)) {
            $class->PreferredTime = new \stdClass;
            $class->PreferredTime->active = (int)$this->getPreferredTimeEnabled();
            $class->PreferredTime->type = $this->getPreferredTime();
        }

        if (null !== $this->getIndividualSenderRequirementsEnabled() && \in_array($productType, [
                ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
                ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
            ], true)) {
            $class->IndividualSenderRequirement = new \stdClass;
            $class->IndividualSenderRequirement->active = (int)$this->getIndividualSenderRequirementsEnabled();
            $class->IndividualSenderRequirement->details = $this->getIndividualSenderRequirementsText();
        }

        if (null !== $this->getPackagingReturn()) {
            $class->PackagingReturn = new \stdClass;
            $class->PackagingReturn->active = (int)$this->getPackagingReturn();
        }

        if (null !== $this->getReturnImmediatelyIfShipmentFailed() && ShipmentDetails::PRODUCT_TYPE_SAME_DAY_PACKAGE === $productType) {
            $class->ReturnImmediately = new \stdClass;
            $class->ReturnImmediately->active = (int)$this->getReturnImmediatelyIfShipmentFailed();
        }

        if (null !== $this->getNoticeNonDeliverability()) {
            $class->NoticeOfNonDeliverability = new \stdClass;
            $class->NoticeOfNonDeliverability->active = (int)$this->getNoticeNonDeliverability();
        }

        if (null !== $this->getShipmentHandlingEnabled() && \in_array($productType, [
                ShipmentDetails::PRODUCT_TYPE_SAME_DAY_MESSENGER,
                ShipmentDetails::PRODUCT_TYPE_WISH_TIME_MESSENGER
            ], true)) {
            $class->ShipmentHandling = new \stdClass;
            $class->ShipmentHandling->active = (int)$this->getShipmentHandlingEnabled();
            $class->ShipmentHandling->type = $this->getShipmentHandlingType();
        }

        if (null !== $this->getEndorsementEnabled()) {
            $class->Endorsement = new \stdClass;
            $class->Endorsement->active = (int)$this->getEndorsementEnabled();
            $class->Endorsement->type = $this->getEndorsementType();
        }

        if (null !== $this->getVisualCheckOfAgeEnabled()) {
            $class->VisualCheckOfAge = new \stdClass;
            $class->VisualCheckOfAge->active = (int)$this->getVisualCheckOfAgeEnabled();
            $class->VisualCheckOfAge->type = $this->getVisualCheckOfAgeType();
        }

        if (null !== $this->getPreferredLocationEnabled()) {
            $class->PreferredLocation = new \stdClass;
            $class->PreferredLocation->active = (int)$this->getPreferredLocationEnabled();
            $class->PreferredLocation->details = $this->getPreferredLocationDetails();
        }

        if (null !== $this->getPreferredNeighbourEnabled()) {
            $class->PreferredNeighbour = new \stdClass;
            $class->PreferredNeighbour->active = (int)$this->getPreferredNeighbourEnabled();
            $class->PreferredNeighbour->details = $this->getPreferredNeighbourText();
        }

        if (null !== $this->getPreferredDayEnabled()) {
            $class->PreferredDay = new \stdClass;
            $class->PreferredDay->active = (int)$this->getPreferredDayEnabled();
            $class->PreferredDay->details = $this->getPreferredDayText();
        }

        if (null !== $this->getPerishables()) {
            $class->Perishables = new \stdClass;
            $class->Perishables->active = (int)$this->getPerishables();
        }

        if (null !== $this->getPersonalHandover()) {
            $class->Personally = new \stdClass;
            $class->Personally->active = (int)$this->getPersonalHandover();
        }

        if (null !== $this->getDisableNeighbourDelivery()) {
            $class->NoNeighbourDelivery = new \stdClass;
            $class->NoNeighbourDelivery->active = (int)$this->getDisableNeighbourDelivery();
        }

        if (null !== $this->getNamedPersonOnly()) {
            $class->NamedPersonOnly = new \stdClass;
            $class->NamedPersonOnly->active = (int)$this->getNamedPersonOnly();
        }

        if (null !== $this->getReturnReceipt()) {
            $class->ReturnReceipt = new \stdClass;
            $class->ReturnReceipt->active = (int)$this->getReturnReceipt();
        }

        if (null !== $this->getPremium()) {
            $class->Premium = new \stdClass;
            $class->Premium->active = (int)$this->getPremium();
        }

        if (null !== $this->getCashOnDeliveryEnabled()) {
            $class->CashOnDelivery = new \stdClass;
            $class->CashOnDelivery->active = (int)$this->getCashOnDeliveryEnabled();
            if (null !== $this->getCashOnDeliveryAddFee()) {
                $class->CashOnDelivery->addFee = $this->getCashOnDeliveryAddFee();
            }
            $class->CashOnDelivery->codAmount = $this->getCashOnDeliveryAmount();
        }

        if (null !== $this->getAdditionalInsuranceEnabled()) {
            $class->AdditionalInsurance = new \stdClass;
            $class->AdditionalInsurance->active = (int)$this->getAdditionalInsuranceEnabled();
            $class->AdditionalInsurance->insuranceAmount = $this->getAdditionalInsuranceAmount();
        }

        if (null !== $this->getBulkyGoods()) {
            $class->BulkyGoods = new \stdClass;
            $class->BulkyGoods->active = (int)$this->getBulkyGoods();
        }

        if (null !== $this->getIdentCheckEnabled()) {
            $class->IdentCheck = new \stdClass;
            $class->IdentCheck->active = (int)$this->getIdentCheckEnabled();
            $class->IdentCheck->Ident = $this->getIdentCheckObj()->getIdentClass_v2();
        }

        return $class;
    }
}
