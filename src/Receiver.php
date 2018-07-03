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
        $receiver->Communication = new Struct\Communication();

        if (null !== $this->getPhone()) {
            $receiver->Communication->phone = $this->getPhone();
        }

        if (null !== $this->getEmail()) {
            $receiver->Communication->email = $this->getEmail();
        }

        if (null !== $this->getContactPerson()) {
            $receiver->Communication->contactPerson = $this->getContactPerson();
        }

        // Address
        $receiver->Address = new Struct\Address();

        if (null !== $this->getName2()) {
            $receiver->Address->name2 = $this->getName2();
        }

        if (null !== $this->getName3()) {
            $receiver->Address->name3 = $this->getName3();
        }

        $receiver->Address->streetName = $this->getStreetName();
        $receiver->Address->streetNumber = $this->getStreetNumber();

        if (null !== $this->getAddressAddition()) {
            $receiver->Address->addressAddition = $this->getAddressAddition();
        }

        if (null !== $this->getDispatchingInfo()) {
            $receiver->Address->dispatchingInformation = $this->getDispatchingInfo();
        }

        $receiver->Address->zip = $this->getZip();
        $receiver->Address->city = $this->getLocation();

        // Origin
        if (null !== $this->getCountryISOCode()) {
            $receiver->Address->Origin = new Struct\Origin();

            if (null !== $this->getCountry()) {
                $receiver->Address->Origin->country = $this->getCountry();
            }

            $receiver->Address->Origin->countryISOCode = $this->getCountryISOCode();

            if (null !== $this->getState()) {
                $receiver->Address->Origin->state = $this->getState();
            }
        }

        return $receiver;
    }
}
