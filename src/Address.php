<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class Address
 */
abstract class Address
{
    /**
     * Contains the Street Name (without number)
     *
     * Min-Len: -
     * Max-Len: 35
     *
     * @var string $streetName - Street Name (without number)
     */
    private $streetName = '';

    /**
     * Contains the Street Number (may with extra stuff like a/b/c/d etc)
     *
     * Min-Len: -
     * Max-Len: 5
     *
     * @var string $streetNumber - Street Number (may with extra stuff like a/b/c/d etc)
     */
    private $streetNumber = '';

    /**
     * Contains other Info about the Address like if its hard to find or where it is exactly located
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 35
     *
     * @var string $addressAddition - Address-Addition
     */
    private $addressAddition;

    /**
     * Contains Optional Dispatching Info
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 35
     *
     * @var string $dispatchingInfo - Optional Dispatching Info
     */
    private $dispatchingInfo;

    /**
     * Contains the ZIP-Code
     *
     * Min-Len: -
     * Max-Len: 10
     *
     * @var string $zip - ZIP-Code
     */
    private $zip = '';

    /**
     * Contains the City/Location
     *
     * Min-Len: -
     * Max-Len: 35
     *
     * @var string $location - Location
     */
    private $location = '';

    /**
     * Contains the Country
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 30
     *
     * @var string $country - Country
     */
    private $country;

    /**
     * Contains the country ISO-Code
     *
     * Note: Optional
     * Min-Len: 2
     * Max-Len: 2
     *
     * @var string|null $countryISOCode - Country-ISO-Code
     */
    private $countryISOCode;

    /**
     * Contains the Name of the State
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 30
     *
     * @var string|null $state - Name of the State
     */
    private $state;

    /**
     * Clears the Memory
     */
    public function __destruct()
    {
        unset(
            $this->streetName,
            $this->streetNumber,
            $this->addressAddition,
            $this->dispatchingInfo,
            $this->zip,
            $this->location,
            $this->country,
            $this->countryISOCode,
            $this->state
        );
    }

    /**
     * @return string
     */
    public function getStreetName(): string
    {
        return $this->streetName;
    }

    /**
     * @param string $streetName
     * @return Address
     */
    public function setStreetName(string $streetName): Address
    {
        $this->streetName = $streetName;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreetNumber(): string
    {
        return $this->streetNumber;
    }

    /**
     * @param string $streetNumber
     * @return Address
     */
    public function setStreetNumber($streetNumber): Address
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddressAddition(): ?string
    {
        return $this->addressAddition;
    }

    /**
     * @param string $addressAddition
     * @return Address
     */
    public function setAddressAddition(string $addressAddition): Address
    {
        $this->addressAddition = $addressAddition;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDispatchingInfo(): ?string
    {
        return $this->dispatchingInfo;
    }

    /**
     * @param string $dispatchingInfo
     * @return Address
     */
    public function setDispatchingInfo(string $dispatchingInfo): Address
    {
        $this->dispatchingInfo = $dispatchingInfo;

        return $this;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return Address
     */
    public function setZip(string $zip): Address
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return Address
     */
    public function setLocation(string $location): Address
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Alias for getLocation
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->getLocation();
    }

    /**
     * Alias for setLocation
     *
     * @param string $city
     * @return Address
     */
    public function setCity(string $city): Address
    {
        $this->setLocation($city);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Address
     */
    final public function setCountry(string $country): Address
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryISOCode(): ?string
    {
        return $this->countryISOCode;
    }

    /**
     * @param string $countryISOCode
     * @return Address
     */
    public function setCountryISOCode(string $countryISOCode): Address
    {
        $this->countryISOCode = $countryISOCode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return Address
     */
    public function setState(string $state): Address
    {
        $this->state = $state;

        return $this;
    }
}
