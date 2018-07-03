<?php declare(strict_types = 1);

namespace DanielLarusso\DHL;

/**
 * Class ReturnReceiver
 */
class ReturnReceiver extends SendPerson
{
    /**
     * Returns a Class for the DHL-SendPerson
     *
     * @return \stdClass - DHL-SendPerson-class
     */
    public function getClass_v1()
    {
        // TODO: Implement getClass_v1() method.
        return new \stdClass;
    }

    /**
     * Returns a Class for the DHL-SendPerson
     *
     * @return Struct\ReturnReceiver - DHL-SendPerson-class
     */
    public function getStruct(): Struct\ReturnReceiver
    {
        /** @var Struct\ReturnReceiver $returnReceiver */
        $returnReceiver = new Struct\ReturnReceiver;

        // Name
        $returnReceiver->name = new Struct\Name;
        $returnReceiver->name->name1 = $this->getName();

        if (null !== $this->getName2()) {
            $returnReceiver->name->name2 = $this->getName2();
        }

        if (null !== $this->getName3()) {
            $returnReceiver->name->name3 = $this->getName3();
        }

        // Address
        $returnReceiver->address = new Struct\Address();
        $returnReceiver->address->streetName = $this->getStreetName();
        $returnReceiver->address->streetNumber = $this->getStreetNumber();

        if (null !== $this->getAddressAddition()) {
            $returnReceiver->address->addressAddition = $this->getAddressAddition();
        }

        if (null !== $this->getDispatchingInfo()) {
            $returnReceiver->address->dispatchingInformation = $this->getDispatchingInfo();
        }

        $returnReceiver->address->zip = $this->getZip();
        $returnReceiver->address->city = $this->getLocation();

        // Origin
        if (null !== $this->getCountryISOCode()) {
            $returnReceiver->address->origin = new Struct\Origin();

            if (null !== $this->getCountry()) {
                $returnReceiver->address->origin->country = $this->getCountry();
            }

            $returnReceiver->address->origin->countryISOCode = $this->getCountryISOCode();

            if (null !== $this->getState()) {
                $returnReceiver->address->origin->state = $this->getState();
            }
        }

        // Communication
        $returnReceiver->communication = new Struct\Communication();
        if (null !== $this->getPhone()) {
            $returnReceiver->communication->phone = $this->getPhone();
        }
        if (null !== $this->getEmail()) {
            $returnReceiver->communication->email = $this->getEmail();
        }
        if (null !== $this->getContactPerson()) {
            $returnReceiver->communication->contactPerson = $this->getContactPerson();
        }

        return $returnReceiver;
    }
}
