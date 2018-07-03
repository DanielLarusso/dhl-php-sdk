<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class BankData
 * @package DanielLarusso\DHL\Struct
 */
class BankData
{
    /**
     * @var string
     */
    public $accountOwner;

    /**
     * @var string
     */
    public $bankName;

    /**
     * @var string
     */
    public $iban;

    /**
     * @var string
     */
    public $note1;

    /**
     * @var string
     */
    public $note2;

    /**
     * @var string
     */
    public $bic;

    /**
     * @var string
     */
    public $accountreference;
}