<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class CashOnDelivery
 * @package DanielLarusso\DHL\Struct
 */
class CashOnDelivery extends ActiveAbstract
{
    /**
     * @var bool
     */
    public $addFee;

    /**
     * @var float
     */
    public $codAmount;
}