<?php declare(strict_types = 1);

namespace DanielLarusso\DHL\Struct;

/**
 * Class Ident
 * @package DanielLarusso\DHL\Struct
 */
class Ident
{
    /**
     * @var string
     */
    public $surname;

    /**
     * @var string
     */
    public $givenName;

    /**
     * @var string
     */
    public $dateOfBirth;

    /**
     * @var int
     */
    public $minimumAge;
}