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
        $shipper->name = new Struct\Name;
        $shipper->name->name1 = $this->getName();

        if (null !== $this->getName2()) {
            $shipper->name->name2 = $this->getName2();
        }

        if (null !== $this->getName3()) {
            $shipper->name->name3 = $this->getName3();
        }

        // Address
        $shipper->address = new Struct\Address();
        $shipper->address->streetName = $this->getStreetName();
        $shipper->address->streetNumber = $this->getStreetNumber();

        if (null !== $this->getAddressAddition()) {
            $shipper->address->addressAddition = $this->getAddressAddition();
        }

        if (null !== $this->getDispatchingInfo()) {
            $shipper->address->dispatchingInformation = $this->getDispatchingInfo();
        }

        $shipper->address->zip = $this->getZip();
        $shipper->address->city = $this->getLocation();

        // Origin
        if (null !== $this->getCountryISOCode()) {
            $shipper->address->origin = new Struct\Origin();

            if (null !== $this->getCountry()) {
                $shipper->address->origin->country = $this->getCountry();
            }

            $shipper->address->origin->countryISOCode = $this->getCountryISOCode();

            if (null !== $this->getState()) {
                $shipper->address->origin->state = $this->getState();
            }
        }

        // Communication
        $shipper->communication = new Struct\Communication();

        if (null !== $this->getPhone()) {
            $shipper->communication->phone = $this->getPhone();
        }

        if (null !== $this->getEmail()) {
            $shipper->communication->email = $this->getEmail();
        }

        if (null !== $this->getContactPerson()) {
            $shipper->communication->contactPerson = $this->getContactPerson();
        }

        return $shipper;
    }
}
