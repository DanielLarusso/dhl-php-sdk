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
     * @return Struct\Shipper - DHL-SendPerson-class
     */
    public function getStruct(): Struct\Shipper
    {
        /** @var Struct\Shipper $shipper */
        $shipper = new Struct\Shipper;

        // Set Name
        $shipper->Name = new Struct\Name;
        $shipper->Name->name1 = $this->getName();

        if (null !== $this->getName2()) {
            $shipper->Name->name2 = $this->getName2();
        }

        if (null !== $this->getName3()) {
            $shipper->Name->name3 = $this->getName3();
        }

        // Address
        $shipper->Address = new Struct\Address();
        $shipper->Address->streetName = $this->getStreetName();
        $shipper->Address->streetNumber = $this->getStreetNumber();

        if (null !== $this->getAddressAddition()) {
            $shipper->Address->addressAddition = $this->getAddressAddition();
        }

        if (null !== $this->getDispatchingInfo()) {
            $shipper->Address->dispatchingInformation = $this->getDispatchingInfo();
        }

        $shipper->Address->zip = $this->getZip();
        $shipper->Address->city = $this->getLocation();

        // Origin
        if (null !== $this->getCountryISOCode()) {
            $shipper->Address->Origin = new Struct\Origin();

            if (null !== $this->getCountry()) {
                $shipper->Address->Origin->country = $this->getCountry();
            }

            $shipper->Address->Origin->countryISOCode = $this->getCountryISOCode();

            if (null !== $this->getState()) {
                $shipper->Address->Origin->state = $this->getState();
            }
        }

        // Communication
        $shipper->Communication = new Struct\Communication();

        if (null !== $this->getPhone()) {
            $shipper->Communication->phone = $this->getPhone();
        }

        if (null !== $this->getEmail()) {
            $shipper->Communication->email = $this->getEmail();
        }

        if (null !== $this->getContactPerson()) {
            $shipper->Communication->contactPerson = $this->getContactPerson();
        }

        return $shipper;
    }
}
