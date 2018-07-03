<?php declare(strict_types = 1);

namespace DanielLarusso\DHL;

/**
 * Class Sender
 */
class Sender extends SendPerson
{
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

        // Set Name
        $class->Name = new \stdClass;
        $class->Name->name1 = $this->getName();

        if (null !== $this->getName2()) {
            $class->Name->name2 = $this->getName2();
        }

        if (null !== $this->getName3()) {
            $class->Name->name3 = $this->getName3();
        }

        // Address
        $class->Address = new \stdClass;
        $class->Address->streetName = $this->getStreetName();
        $class->Address->streetNumber = $this->getStreetNumber();

        if (null !== $this->getAddressAddition()) {
            $class->Address->addressAddition = $this->getAddressAddition();
        }

        if (null !== $this->getDispatchingInfo()) {
            $class->Address->dispatchingInformation = $this->getDispatchingInfo();
        }

        $class->Address->zip = $this->getZip();
        $class->Address->city = $this->getLocation();

        // Origin
        if (null !== $this->getCountryISOCode()) {
            $class->Address->Origin = new \stdClass;

            if (null !== $this->getCountry()) {
                $class->Address->Origin->country = $this->getCountry();
            }

            $class->Address->Origin->countryISOCode = $this->getCountryISOCode();

            if (null !== $this->getState()) {
                $class->Address->Origin->state = $this->getState();
            }
        }

        // Communication
        $class->Communication = new \stdClass;

        if (null !== $this->getPhone()) {
            $class->Communication->phone = $this->getPhone();
        }

        if (null !== $this->getEmail()) {
            $class->Communication->email = $this->getEmail();
        }

        if (null !== $this->getContactPerson()) {
            $class->Communication->contactPerson = $this->getContactPerson();
        }

        return $class;
    }
}
