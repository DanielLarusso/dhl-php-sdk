<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class Receiver
 */
class Receiver extends SendPerson
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
     * @return Struct\Receiver - DHL-SendPerson-class
     */
    public function getStruct(): Struct\Receiver
    {
        /** @var Struct\Receiver $receiver */
        $receiver = new Struct\Receiver;

        $receiver->name1 = $this->getName();

        // Communication
        $receiver->communication = new Struct\Communication();

        if (null !== $this->getPhone()) {
            $receiver->communication->phone = $this->getPhone();
        }

        if (null !== $this->getEmail()) {
            $receiver->communication->email = $this->getEmail();
        }

        if (null !== $this->getContactPerson()) {
            $receiver->communication->contactPerson = $this->getContactPerson();
        }

        // Address
        $receiver->address = new Struct\Address();

        if (null !== $this->getName2()) {
            $receiver->address->name2 = $this->getName2();
        }

        if (null !== $this->getName3()) {
            $receiver->address->name3 = $this->getName3();
        }

        $receiver->address->streetName = $this->getStreetName();
        $receiver->address->streetNumber = $this->getStreetNumber();

        if (null !== $this->getAddressAddition()) {
            $receiver->address->addressAddition = $this->getAddressAddition();
        }

        if (null !== $this->getDispatchingInfo()) {
            $receiver->address->dispatchingInformation = $this->getDispatchingInfo();
        }

        $receiver->address->zip = $this->getZip();
        $receiver->address->city = $this->getLocation();

        // Origin
        if (null !== $this->getCountryISOCode()) {
            $receiver->address->origin = new Struct\Origin();

            if (null !== $this->getCountry()) {
                $receiver->address->origin->country = $this->getCountry();
            }

            $receiver->address->origin->countryISOCode = $this->getCountryISOCode();

            if (null !== $this->getState()) {
                $receiver->address->origin->state = $this->getState();
            }
        }

        return $receiver;
    }
}
