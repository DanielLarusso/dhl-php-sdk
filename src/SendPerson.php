<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class SendPerson
 */
abstract class SendPerson extends Address
{
    /**
     * Name of the SendPerson (Can be a Company-Name too!)
     *
     * Min-Len: -
     * Max-Len: 50
     *
     * @var string $name - Name
     */
    private $name;

    /**
     * Name of SendPerson (Part 2)
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 50
     *
     * @var string|null $name2 - Name (Part 2)
     */
    private $name2;

    /**
     * Name of SendPerson (Part 3)
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 50
     *
     * @var string|null $name3 - Name (Part 3)
     */
    private $name3;

    /**
     * Phone-Number of the SendPerson
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 20
     *
     * @var string|null $phone - Phone-Number
     */
    private $phone;

    /**
     * E-Mail of the SendPerson
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 70
     *
     * @var string|null $email - E-Mail-Address
     */
    private $email;

    /**
     * Contact Person of the SendPerson (Mostly used in Companies)
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 50
     *
     * @var string|null $contactPerson - Contact Person
     */
    private $contactPerson;

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        parent::__destruct();
        unset(
            $this->name,
            $this->name2,
            $this->name3,
            $this->phone,
            $this->email,
            $this->contactPerson
        );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SendPerson
     */
    public function setName(string $name): SendPerson
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName2(): ?string
    {
        return $this->name2;
    }

    /**
     * @param null|string $name2
     * @return SendPerson
     */
    public function setName2(?string $name2): SendPerson
    {
        $this->name2 = $name2;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName3(): ?string
    {
        return $this->name3;
    }

    /**
     * @param null|string $name3
     * @return SendPerson
     */
    public function setName3(?string $name3): SendPerson
    {
        $this->name3 = $name3;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     * @return SendPerson
     */
    public function setPhone(?string $phone): SendPerson
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return SendPerson
     */
    public function setEmail(?string $email): SendPerson
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getContactPerson(): ?string
    {
        return $this->contactPerson;
    }

    /**
     * @param null|string $contactPerson
     * @return SendPerson
     */
    public function setContactPerson(?string $contactPerson): SendPerson
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }


    /**
     * Returns a Class for the DHL-SendPerson
     *
     * @return \stdClass - DHL-SendPerson-class
     */
    abstract public function getClass_v1();

    /**
     * Returns a Class for the DHL-SendPerson
     *
     * @return \stdClass - DHL-SendPerson-class
     */
    abstract public function getClass_v2();
}
