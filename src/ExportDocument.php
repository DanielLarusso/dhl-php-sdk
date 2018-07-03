<?php declare(strict_types = 1);

namespace DanielLarusso\DHL;

/**
 * Class ExportDocument
 */
class ExportDocument
{
    // Constants for Export-Type
    public const EXPORT_TYPE_OTHER = 'OTHER';
    public const EXPORT_TYPE_PRESENT = 'PRESENT';
    public const EXPORT_TYPE_COMMERCIAL_SAMPLE = 'COMMERCIAL_SAMPLE';
    public const EXPORT_TYPE_DOCUMENT = 'DOCUMENT';
    public const EXPORT_TYPE_RETURN_OF_GOODS = 'RETURN_OF_GOODS';

    // Constants for Terms of Trade
    public const TERMS_OF_TRADE_DDP = 'DDP';
    public const TERMS_OF_TRADE_DXV = 'DXV';
    public const TERMS_OF_TRADE_DDU = 'DDU';
    public const TERMS_OF_TRADE_DDX = 'DDX';

    /**
     * In case invoice has a number, client app can provide it in this field.
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 35
     *
     * @var string|null $invoiceNumber - Invoice-Number or null for none
     */
    private $invoiceNumber;

    /**
     * Export type
     * (depends on chosen product -> only mandatory for international, non EU shipments).
     *
     * Note: Required! (Even if just mandatory for international shipments)
     *
     * Possible values:
     * OTHER
     * PRESENT
     * COMMERCIAL_SAMPLE
     * DOCUMENT
     * RETURN_OF_GOODS
     *
     * @var string $exportType - Export-Type (Can assigned with ExportDocument::EXPORT_TYPE_{TYPE} or as value)
     */
    private $exportType;

    /**
     * Description for Export-Type (especially needed if Export-Type is OTHER)
     *
     * Note: Optional|Required if "EXPORT_TYPE" is OTHER
     * Min-Len: 1
     * Max-Len: 256
     *
     * @var string|null $exportTypeDescription - Export-Description or null for none
     */
    private $exportTypeDescription;

    /**
     * Element provides terms of trades
     *
     * Note: Optional
     * Min-Len: 3
     * Max-Len: 3
     *
     * Possible values:
     * DDP - Delivery Duty Paid
     * DXV - Delivery duty paid (excl. VAT )
     * DDU - DDU - Delivery Duty Paid
     * DDX - Delivery duty paid (excl. Duties, taxes and VAT)
     *
     * @var string|null $termsOfTrade - Terms of trades (Can assigned with ExportDocument::TERMS_OF_TRADE_{TYPE})
     *                                    or null for none
     */
    private $termsOfTrade;

    /**
     * Place of committal
     *
     * Note: Required
     * Min-Len: -
     * Max-Len: 35
     *
     * @var string $placeOfCommittal - Place of committal is a Location
     */
    private $placeOfCommittal;

    /**
     * Additional custom fees to be payed
     *
     * Note: Required
     *
     * @var float $additionalFee - Additional fee
     */
    private $additionalFee;

    /**
     * Permit-Number
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 10
     *
     * // todo/fixme: is this just an int or float?
     * @var string|null $permitNumber - Permit number or null for none
     */
    private $permitNumber;

    /**
     * Attestation number
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 35
     *
     * // todo/fixme: is this just an int or float?
     * @var string|null $attestationNumber - The attestation number or null for none
     */
    private $attestationNumber;

    /**
     * Is with Electronic Export Notification
     *
     * Note: Optional
     *
     * @var bool|null $withElectronicExportNotification - Is with Electronic Export Notification or null for default
     */
    private $withElectronicExportNotification;

    /**
     * Contains the ExportDocPosition-Class(es)
     *
     * Note: Optional
     *
     * @var ExportDocPosition|array|null $exportDocPosition - ExportDocPosition-Class or an array with ExportDocPosition-Objects or null if not needed
     */
    private $exportDocPosition;

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        unset(
            $this->invoiceNumber,
            $this->exportType,
            $this->exportTypeDescription,
            $this->termsOfTrade,
            $this->placeOfCommittal,
            $this->additionalFee,
            $this->permitNumber,
            $this->attestationNumber,
            $this->withElectronicExportNotification,
            $this->exportDocPosition
        );
    }

    /**
     * @return null|string
     */
    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    /**
     * @param null|string $invoiceNumber
     * @return ExportDocument
     */
    public function setInvoiceNumber(?string $invoiceNumber): ExportDocument
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getExportType(): string
    {
        return $this->exportType;
    }

    /**
     * @param string $exportType
     * @return ExportDocument
     */
    public function setExportType(string $exportType): ExportDocument
    {
        $this->exportType = $exportType;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getExportTypeDescription(): ?string
    {
        return $this->exportTypeDescription;
    }

    /**
     * @param null|string $exportTypeDescription
     * @return ExportDocument
     */
    public function setExportTypeDescription(?string $exportTypeDescription): ExportDocument
    {
        $this->exportTypeDescription = $exportTypeDescription;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTermsOfTrade(): ?string
    {
        return $this->termsOfTrade;
    }

    /**
     * @param null|string $termsOfTrade
     * @return ExportDocument
     */
    public function setTermsOfTrade(?string $termsOfTrade): ExportDocument
    {
        $this->termsOfTrade = $termsOfTrade;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceOfCommittal(): string
    {
        return $this->placeOfCommittal;
    }

    /**
     * @param string $placeOfCommittal
     * @return ExportDocument
     */
    public function setPlaceOfCommittal(string $placeOfCommittal): ExportDocument
    {
        $this->placeOfCommittal = $placeOfCommittal;

        return $this;
    }

    /**
     * @return float
     */
    public function getAdditionalFee(): float
    {
        return $this->additionalFee;
    }

    /**
     * @param float $additionalFee
     * @return ExportDocument
     */
    public function setAdditionalFee(float $additionalFee): ExportDocument
    {
        $this->additionalFee = $additionalFee;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPermitNumber(): ?string
    {
        return $this->permitNumber;
    }

    /**
     * @param null|string $permitNumber
     * @return ExportDocument
     */
    public function setPermitNumber(?string $permitNumber): ExportDocument
    {
        $this->permitNumber = $permitNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAttestationNumber(): ?string
    {
        return $this->attestationNumber;
    }

    /**
     * @param null|string $attestationNumber
     * @return ExportDocument
     */
    public function setAttestationNumber(?string $attestationNumber): ExportDocument
    {
        $this->attestationNumber = $attestationNumber;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getWithElectronicExportNotification(): ?bool
    {
        return $this->withElectronicExportNotification;
    }

    /**
     * @param bool|null $withElectronicExportNotification
     * @return ExportDocument
     */
    public function setWithElectronicExportNotification(?bool $withElectronicExportNotification): ExportDocument
    {
        $this->withElectronicExportNotification = $withElectronicExportNotification;

        return $this;
    }

    /**
     * @return ExportDocPosition|array|null
     */
    public function getExportDocPosition()
    {
        return $this->exportDocPosition;
    }

    /**
     * @param ExportDocPosition|array|null $exportDocPosition
     */
    public function setExportDocPosition($exportDocPosition)
    {
        $this->exportDocPosition = $exportDocPosition;
    }

    /**
     * Adds an ExportDocPosition-Object to the current Object
     *
     * If the ExportDocPosition was null before, then it will add the entry normal (backwards compatibility)
     * If the ExportDocPosition was an array before, it just add it to the array
     * If the ExportDocPosition was just 1 entry before, it will converted to an array with both entries
     *
     * @param ExportDocPosition $exportDocPosition - Object to add
     * @return ExportDocument
     */
    public function addExportDocPosition(ExportDocPosition $exportDocPosition): ExportDocument
    {
        if (null === $this->getExportDocPosition()) {
            $this->setExportDocPosition($exportDocPosition);
        } else if (\is_array($this->getExportDocPosition())) {
            $this->exportDocPosition[] = $exportDocPosition;
        } else {
            // Convert the first existing entry to an array
            $this->setExportDocPosition([$this->getExportDocPosition(), $exportDocPosition]);
        }

        return $this;
    }

    /**
     * @return \stdClass
     */
    public function getExportDocumentClass_v1(): \stdClass
    {
        $class = new \stdClass;

        // todo implement

        return $class;
    }

    /**
     * Returns a Class for Export-Document
     *
     * @return Struct\ExportDocument - DHL-ExportDocument-Class
     * @throws \RuntimeException - Invalid Data-Exception
     */
    public function getStruct(): Struct\ExportDocument
    {
        /** @var Struct\ExportDocument $exportDocument */
        $exportDocument = new Struct\ExportDocument;

        // Standard-Export-Stuff
        if (null !== $this->getInvoiceNumber()) {
            $exportDocument->invoiceNumber = $this->getInvoiceNumber();
        }

        $exportDocument->exportType = $this->getExportType();

        if (null !== $this->getExportTypeDescription()) {
            $exportDocument->exportTypeDescription = $this->getExportTypeDescription();
        } else if ($this->getExportType() === self::EXPORT_TYPE_OTHER) {
            throw new \RuntimeException('ExportTypeDescription must filled out if Export-Type is OTHER! - ' .
                'Export-Class will not generated now');
        }

        if (null !== $this->getTermsOfTrade()) {
            $exportDocument->termsOfTrade = $this->getTermsOfTrade();
        }

        $exportDocument->placeOfCommital = $this->getPlaceOfCommittal();
        $exportDocument->additionalFee = $this->getAdditionalFee();

        if (null !== $this->getPermitNumber()) {
            $exportDocument->permitNumber = $this->getPermitNumber();
        }

        if (null !== $this->getAttestationNumber()) {
            $exportDocument->attestationNumber = $this->getAttestationNumber();
        }

        // Add rest (Elements)
        if (null !== $this->getWithElectronicExportNotification()) {
            $exportDocument->WithElectronicExportNtfctn = new Struct\WitchElectronicExportNtfctn();
            $exportDocument->WithElectronicExportNtfctn->active = (int) $this->getWithElectronicExportNotification();
        }

        // Check if child-class is being used
        if (null !== $this->getExportDocPosition()) {
            $pos = $this->getExportDocPosition();

            /**
             * @var $key
             * @var ExportDocPosition $exportDoc
             */
            foreach ($pos as $key => &$exportDoc) {
                $exportDocument->ExportDocPosition[$key] = $exportDoc->getStruct();
            }
        }

        return $exportDocument;
    }
}
