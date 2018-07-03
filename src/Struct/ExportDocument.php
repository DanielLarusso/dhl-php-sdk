<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class ExportDocument
 * @package DanielLarusso\DHL\Struct
 */
class ExportDocument
{
    /**
     * @var string
     */
    public $invoiceNumber;

    /**
     * @var string
     */
    public $exportType;

    /**
     * @var string
     */
    public $exportTypeDescription;

    /**
     * @var string
     */
    public $termsOfTrade;

    /**
     * @var string
     */
    public $placeOfCommital; // todo: check if this is the correct wording

    /**
     * @var float
     */
    public $additionalFee;

    /**
     * @var string
     */
    public $permitNumber;

    /**
     * @var string
     */
    public $attestationNumber;

    /**
     * @var WitchElectronicExportNtfctn
     */
    public $WithElectronicExportNtfctn;

    /**
     * @var ExportDocPosition[]
     */
    public $ExportDocPosition;
}