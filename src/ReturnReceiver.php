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
        $returnReceiver->Name = new Struct\Name;
        $returnReceiver->Name->name1 = $this->getName();

        if (null !== $this->getName2()) {
            $returnReceiver->Name->name2 = $this->getName2();
        }

        if (null !== $this->getName3()) {
            $returnReceiver->Name->name3 = $this->getName3();
        }

        // Address
        $returnReceiver->Address = new Struct\Address();
        $returnReceiver->Address->streetName = $this->getStreetName();
        $returnReceiver->Address->streetNumber = $this->getStreetNumber();

        if (null !== $this->getAddressAddition()) {
            $returnReceiver->Address->addressAddition = $this->getAddressAddition();
        }

        if (null !== $this->getDispatchingInfo()) {
            $returnReceiver->Address->dispatchingInformation = $this->getDispatchingInfo();
        }

        $returnReceiver->Address->zip = $this->getZip();
        $returnReceiver->Address->city = $this->getLocation();

        // Origin
        if (null !== $this->getCountryISOCode()) {
            $returnReceiver->Address->Origin = new Struct\Origin();

            if (null !== $this->getCountry()) {
                $returnReceiver->Address->Origin->country = $this->getCountry();
            }

            $returnReceiver->Address->Origin->countryISOCode = $this->getCountryISOCode();

            if (null !== $this->getState()) {
                $returnReceiver->Address->Origin->state = $this->getState();
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
