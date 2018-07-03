<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class PackStation
 */
class PackStation extends Receiver
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
     * Contains the Pack-Station-Number
     *
     * Min-Len: 3
     * Max-Len: 3
     *
     * @var string $packStationNumber - Pack-Station-Number
     */
    private $packStationNumber = '';

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        parent::__destruct();
        unset(
            $this->postNumber,
            $this->packStationNumber
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
     * @return PackStation
     */
    public function setPostNumber(string $postNumber): PackStation
    {
        $this->postNumber = $postNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getPackStationNumber(): string
    {
        return $this->packStationNumber;
    }

    /**
     * @param string $packStationNumber
     * @return PackStation
     */
    public function setPackStationNumber(string $packStationNumber): PackStation
    {
        $this->packStationNumber = $packStationNumber;

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

        $class->Packstation = new \stdClass;
        $class->Packstation->postNumber = $this->getPostNumber();
        $class->Packstation->packstationNumber = $this->getPackStationNumber();
        $class->Packstation->zip = $this->getZip();
        $class->Packstation->city = $this->getLocation();

        if ($this->getCountryISOCode() !== null) {
            $class->Packstation->Origin = new \stdClass;

            if ($this->getCountry() !== null)
                $class->Packstation->Origin->country = $this->getCountry();

            $class->Packstation->Origin->countryISOCode = $this->getCountryISOCode();

            if ($this->getState() !== null)
                $class->Packstation->Origin->state = $this->getState();
        }

        return $class;
    }
}
