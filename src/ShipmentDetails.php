<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class ShipmentDetails
 */
class ShipmentDetails
{
    /**
     * DHL-Package-Type "Palette"
     */
    public const PALETTE = 'PL';

    /**
     * DHL-Package-Type "Package"
     */
    public const PACKAGE = 'PK';

    /**
     * Product-Types
     */
    public const PRODUCT_TYPE_NATIONAL_PACKAGE = 'V01PAK';
    public const PRODUCT_TYPE_NATIONAL_PACKAGE_PRIO = 'V01PRIO';
    public const PRODUCT_TYPE_INTERNATIONAL_PACKAGE = 'V53WPAK';
    public const PRODUCT_TYPE_EUROPA_PACKAGE = 'V54EPAK';
    public const PRODUCT_TYPE_PACKED_CONNECT = 'V55PAK';
    public const PRODUCT_TYPE_SAME_DAY_PACKAGE = 'V06PAK';
    public const PRODUCT_TYPE_SAME_DAY_MESSENGER = 'V06TG';
    public const PRODUCT_TYPE_WISH_TIME_MESSENGER = 'V06WZ';
    public const PRODUCT_TYPE_AUSTRIA_PACKAGE = 'V86PARCEL';
    public const PRODUCT_TYPE_AUSTRIA_INTERNATIONAL_PACKAGE = 'V82PARCEL';
    public const PRODUCT_TYPE_CONNECT_PACKAGE = 'V87PARCEL';

    /**
     * Contains which Product is used
     *
     * @var string $product - Product to use
     */
    private $product = self::PRODUCT_TYPE_NATIONAL_PACKAGE;

    /**
     * Contains the
     * EPK Account Number         (10 Digits) Example 123457890
     * concat Product Type Number (2 Digits)  Example 01 for V01PAK or 53 for V53WPAK or 07 for Retoure Online
     * concat Process Type Number (2 Digits)  Example 01 for default or 02 for block pricing/flat fee
     *                                         = 1234578900101
     * Min-Len: 14
     * Max-Len: 14
     *
     * @var string $accountNumber - Account-Number plus Product Type Number plus Process Type Number
     */
    private $accountNumber;

    /**
     * Contains the Customer-Reference
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 35
     *
     * @var string|null $customerReference - Customer Reference or null for disabling
     */
    private $customerReference;

    /**
     * Contains the Shipment-Date
     *
     * Note: ISO-Date-Format (YYYY-MM-DD)
     * Min-Len: 10
     * Max-Len: 10
     *
     * @var string|null $shipmentDate - Shipment-Data or null (= Today if Sunday then +1 Day)
     */
    private $shipmentDate;

    /**
     * Contains the Return-Account-Number (EPK)
     *
     * Note: Optional
     * Min-Len: 14
     * Max-Len: 14
     *
     * @var string|null $returnAccountNumber - Return-Account-Number or null for disabling
     */
    private $returnAccountNumber;

    /**
     * Contains the Return-Reference
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 35
     *
     * @var string|null $returnReference - Return-Reference or null for disabling
     */
    private $returnReference;

    /**
     * Weight of the Shipment-Object in KG
     *
     * @var float $weight - Weight in KG
     */
    private $weight = 5.0;

    /**
     * Length of the Shipment-Object in CM
     *
     * Note: Optional
     *
     * @var int|null $length - Length in CM
     */
    private $length;

    /**
     * Width of the Shipment-Object in CM
     *
     * Note: Optional
     *
     * @var int|null $width - Width in CM
     */
    private $width;

    /**
     * Height of the Shipment-Object in CM
     *
     * Note: Optional
     *
     * @var int|null $height - Height in CM
     */
    private $height;

    /**
     * Type of the Package
     *
     * Note: Optional
     *
     * @var string $packageType - Package-Type
     */
    private $packageType = self::PACKAGE;

    /**
     * ShipmentDetails constructor.
     *
     * @param string $accountNumber - Account-Number
     */
    public function __construct(string $accountNumber)
    {
        $this->setAccountNumber($accountNumber);
    }

    /**
     * Clears the Memory
     */
    public function __destruct()
    {
        unset(
            $this->product,
            $this->accountNumber,
            $this->customerReference,
            $this->shipmentDate,
            $this->returnAccountNumber,
            $this->returnReference,
            $this->weight,
            $this->length,
            $this->width,
            $this->height,
            $this->packageType
        );
    }

    /**
     * @return string
     */
    public function getProduct(): string
    {
        return $this->product;
    }

    /**
     * @param string $product
     * @return ShipmentDetails
     */
    public function setProduct(string $product): ShipmentDetails
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return string
     */
    private function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    /**
     * @param string $accountNumber
     * @return ShipmentDetails
     */
    private function setAccountNumber(string $accountNumber): ShipmentDetails
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCustomerReference(): ?string
    {
        return $this->customerReference;
    }

    /**
     * @param null|string $customerReference
     * @return ShipmentDetails
     */
    public function setCustomerReference(?string $customerReference): ShipmentDetails
    {
        $this->customerReference = $customerReference;

        return $this;
    }

    /**
     * @return string
     */
    public function getShipmentDate(): string
    {
        if ($this->shipmentDate === null) {
            $this->setShipmentDate($this->createDefaultShipmentDate());
        }

        return $this->shipmentDate;
    }

    /**
     * todo: refactor with \DateTime
     *
     * Set the Shipment-Date
     *
     * @param string|int|null $shipmentDate - Shipment-Date
     * @param bool $useTimeStamp - Use a Time-Stamp
     */
    public function setShipmentDate($shipmentDate, bool $useTimeStamp = false)
    {
        if ($useTimeStamp) {
            // Convert Time-Stamp to Date
            $this->shipmentDate = \date('Y-m-d', $shipmentDate);

            if ($this->shipmentDate === false)
                $this->setShipmentDate($shipmentDate);
        } else
            $this->shipmentDate = $shipmentDate;
    }

    /**
     * @return null|string
     */
    public function getReturnAccountNumber(): ?string
    {
        return $this->returnAccountNumber;
    }

    /**
     * @param null|string $returnAccountNumber
     * @return ShipmentDetails
     */
    public function setReturnAccountNumber(?string $returnAccountNumber): ShipmentDetails
    {
        $this->returnAccountNumber = $returnAccountNumber;
    }

    /**
     * @return null|string
     */
    public function getReturnReference(): ?string
    {
        return $this->returnReference;
    }

    /**
     * @param null|string $returnReference
     * @return ShipmentDetails
     */
    public function setReturnReference(?string $returnReference): ShipmentDetails
    {
        $this->returnReference = $returnReference;

        return $this;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return ShipmentDetails
     */
    public function setWeight(float $weight): ShipmentDetails
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getLength(): ?int
    {
        return $this->length;
    }

    /**
     * @param int|null $length
     * @return ShipmentDetails
     */
    public function setLength(?int $length): ShipmentDetails
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @param int|null $width
     * @return ShipmentDetails
     */
    public function setWidth(?int $width): ShipmentDetails
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     * @return ShipmentDetails
     */
    public function setHeight(?int $height): ShipmentDetails
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return string
     */
    public function getPackageType(): string
    {
        return $this->packageType;
    }

    /**
     * @param string $packageType
     * @return ShipmentDetails
     */
    public function setPackageType(string $packageType): ShipmentDetails
    {
        $this->packageType = $packageType;

        return $this;
    }

    /**
     * todo: refactor with \DateTime
     *
     * Creates a Default Shipment-Date (Today or if Sunday the next Day)
     *
     * @return string - Default-Date
     */
    private function createDefaultShipmentDate()
    {
        $now = \time();
        $weekDay = \date('w', $now);

        if ($weekDay === 0)
            $now += 86400; // Increase Day by 1 if Sunday

        return \date('Y-m-d', $now);
    }

    /**
     * Returns an DHL-Class of this Object for DHL-Shipment Details
     *
     * @return \stdClass - ShipmentDetailsClass
     */
    public function getShipmentDetailsClass_v1(): \stdClass
    {
        // todo implement getClass_v1()
        return new \stdClass;
    }

    /**
     * Returns an DHL-Class of this Object for DHL-Shipment Details
     *
     * @return \stdClass - ShipmentDetailsClass
     *
     * @deprecated
     */
    public function getShipmentDetailsClass_v2(): \stdClass
    {
        /** @var \stdClass $class */
        $class = new \stdClass;

        $class->product = $this->getProduct();
        $class->accountNumber = $this->getAccountNumber();
        if ($this->getCustomerReference() !== null) {
            $class->customerReference = $this->getCustomerReference();
        }
        $class->shipmentDate = $this->getShipmentDate();
        if ($this->getReturnAccountNumber() !== null) {
            $class->returnShipmentAccountNumber = $this->getReturnAccountNumber();
        }
        if ($this->getReturnReference() !== null) {
            $class->returnShipmentReference = $this->getReturnReference();
        }
        $class->ShipmentItem = new \stdClass;
        $class->ShipmentItem->weightInKG = $this->getWeight();
        if ($this->getLength() !== null) {
            $class->ShipmentItem->lengthInCM = $this->getLength();
        }
        if ($this->getWidth() !== null) {
            $class->ShipmentItem->widthInCM = $this->getWidth();
        }
        if ($this->getHeight() !== null) {
            $class->ShipmentItem->heightInCM = $this->getHeight();
        }

        return $class;
    }

    /**
     * Returns an DHL-Class of this Object for DHL-Shipment Details
     *
     * @return Struct\ShipmentDetails - ShipmentDetailsClass
     */
    public function getStruct(): Struct\ShipmentDetails
    {
        /** @var Struct\ShipmentDetails $shipmentDetails */
        $shipmentDetails = new Struct\ShipmentDetails();

        $shipmentDetails->product = $this->getProduct();
        $shipmentDetails->accountNumber = $this->getAccountNumber();

        if (null !== $this->getCustomerReference()) {
            $shipmentDetails->customerReference = $this->getCustomerReference();
        }

        $shipmentDetails->shipmentDate = $this->getShipmentDate();

        if (null !== $this->getReturnAccountNumber()) {
            $shipmentDetails->returnShipmentAccountNumber = $this->getReturnAccountNumber();
        }

        if (null !== $this->getReturnReference()) {
            $shipmentDetails->returnShipmentReference = $this->getReturnReference();
        }

        $shipmentDetails->ShipmentItem = new Struct\ShipmentItem();
        $shipmentDetails->ShipmentItem->weightInKG = $this->getWeight();

        if (null !== $this->getLength()) {
            $shipmentDetails->ShipmentItem->lengthInCM = $this->getLength();
        }

        if (null !== $this->getWidth()) {
            $shipmentDetails->ShipmentItem->widthInCM = $this->getWidth();
        }

        if (null !== $this->getHeight()) {
            $shipmentDetails->ShipmentItem->heightInCM = $this->getHeight();
        }

        return $shipmentDetails;
    }
}
