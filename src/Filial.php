<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class Filial
 */
class Filial extends Receiver
{
    /**
     * Contains the Post-Number
     *
     * Min-Len: 1
     * Max-Len: 10
     *
     * @var string $postNumber - Post-Number
     */
    private $postNumber = '';

    /**
     * Contains the Post-Filial-Number
     *
     * Min-Len: 3
     * Max-Len: 3
     *
     * @var string $filialNumber - Post-Filial-Number
     */
    private $filialNumber = '';

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        parent::__destruct();
        unset(
            $this->postNumber,
            $this->filialNumber
        );
    }

    /**
     * @return string
     */
    public function getPostNumber(): string
    {
        return $this->postNumber;
    }

    /**
     * @param string $postNumber
     * @return Filial
     */
    public function setPostNumber(string $postNumber): Filial
    {
        $this->postNumber = $postNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilialNumber(): string
    {
        return $this->filialNumber;
    }

    /**
     * @param string $filialNumber
     * @return Filial
     */
    public function setFilialNumber(string $filialNumber): Filial
    {
        $this->filialNumber = $filialNumber;

        return $this;
    }

    /**
     * Alias for getFilialNumber
     *
     * @return string $filialNumber
     */
    public function getPostFilialNumber(): string
    {
        return $this->filialNumber;
    }

    /**
     * Alias for setFilialNumber
     *
     * @param string $filialNumber
     * @return Filial
     */
    public function setPostFilialNumber(string $filialNumber): Filial
    {
        $this->filialNumber = $filialNumber;

        return $this;
    }

    /**
     * Returns a Class for the DHL-SendPerson
     *
     * @return \stdClass - DHL-SendPerson-class
     */
    public function getClass_v1(): \stdClass
    {
        // TODO: Implement getClass_v1() method.

        return new \stdClass;
    }

    /**
     * Returns a Class for the DHL-SendPerson
     *
     * @return \stdClass - DHL-SendPerson-class
     */
    public function getClass_v2(): \stdClass
    {
        /** @var \stdClass $class */
        $class = new \stdClass;
        $class->name1 = $this->getName();

        $class->Communication = new \stdClass;
        if ($this->getPhone() !== null)
            $class->Communication->phone = $this->getPhone();
        if ($this->getEmail() !== null)
            $class->Communication->email = $this->getEmail();
        if ($this->getContactPerson() !== null)
            $class->Communication->contactPerson = $this->getContactPerson();

        $class->Postfiliale = new \stdClass;
        $class->Postfiliale->postfilialNumber = $this->getFilialNumber();
        $class->Postfiliale->postNumber = $this->getPostNumber();
        $class->Postfiliale->zip = $this->getZip();
        $class->Postfiliale->city = $this->getLocation();

        if ($this->getCountryISOCode() !== null) {
            $class->Postfiliale->Origin = new \stdClass;

            if ($this->getCountry() !== null)
                $class->Postfiliale->Origin->country = $this->getCountry();

            $class->Postfiliale->Origin->countryISOCode = $this->getCountryISOCode();

            if ($this->getState() !== null)
                $class->Postfiliale->Origin->state = $this->getState();
        }

        return $class;
    }
}
