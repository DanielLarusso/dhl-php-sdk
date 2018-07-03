<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class IdentCheck
 */
class IdentCheck
{
    /**
     * Contains the Last-Name of the Person
     *
     * @var string $lastName - Last-Name
     */
    private $lastName;

    /**
     * Contains the First-Name of the Person
     *
     * @var string $firstName - First-Name
     */
    private $firstName;

    /**
     * Contains the Birthday of the Person
     *
     * Note: ISO-Date-Format (YYYY-MM-DD)
     *
     * @var string $birthday - Birthday
     */
    private $birthday;

    /**
     * Contains the "minimum age of the person for ident check"
     *
     * @var int $minimumAge - "minimum age of the person for ident check"
     */
    private $minimumAge;

    /**
     * IdentCheck constructor.
     *
     * @param string $lastName - Last-Name
     * @param string $firstName - First-Name
     * @param string $birthday - Birthday (Format: YYYY-MM-DD) todo: replace with \DateTime
     * @param int $minimumAge - Minimum-Age
     */
    public function __construct(string $lastName, string $firstName, string $birthday, int $minimumAge)
    {
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->birthday = $birthday;
        $this->minimumAge = $minimumAge;
    }

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        unset(
            $this->lastName,
            $this->firstName,
            $this->birthday,
            $this->minimumAge
        );
    }

    /**
     * Get the Ident-DHL-Class
     *
     * @return \stdClass - Ident-DHL-Class
     *
     * @deprecated
     */
    public function getIdentClass_v2(): \stdClass
    {
        /** @var \stdClass $class */
        $class = new \stdClass;
        $class->surname = $this->lastName;
        $class->givenName = $this->firstName;
        $class->dateOfBirth = $this->birthday;
        $class->minimumAge = $this->minimumAge;

        return $class;
    }

    /**
     * Get the Ident-DHL-Class
     *
     * @return Struct\Ident - Ident-DHL-Class
     */
    public function getIdentStruct(): Struct\Ident
    {
        /** @var Struct\Ident $class */
        $ident = new Struct\Ident();
        $ident->surname = $this->lastName;
        $ident->givenName = $this->firstName;
        $ident->dateOfBirth = $this->birthday;
        $ident->minimumAge = $this->minimumAge;

        return $class;
    }
}
