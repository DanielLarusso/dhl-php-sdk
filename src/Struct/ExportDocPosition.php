<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class ExportDocPosition
 * @package DanielLarusso\DHL\Struct
 */
class ExportDocPosition
{
    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $countryCodeOrigin;

    /**
     * @var string
     */
    public $customsTariffNumber;

    /**
     * @var int
     */
    public $amount;

    /**
     * @var float
     */
    public $netWeightInKG;

    /**
     * @var float
     */
    public $customsValue;
}