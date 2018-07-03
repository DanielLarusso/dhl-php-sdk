<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class BankData
 */
class BankData
{
    /**
     * Name of the Account-Owner
     *
     * Min-Len: -
     * Max-Len: 80
     *
     * @var string $accountOwnerName - Account-Owner Name
     */
    private $accountOwnerName = '';

    /**
     * Name of the Bank
     *
     * Min-Len: -
     * Max-Len: 80
     *
     * @var string $bankName - Name of the Bank
     */
    private $bankName = '';

    /**
     * IBAN of the Account
     *
     * Min-Len: -
     * Max-Len: 34
     *
     * @var string $iban - IBAN of the Account
     */
    private $iban = '';

    /**
     * Purpose of bank information
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 35
     *
     * @var string|null $note1 - Purpose of bank information or null for none
     */
    private $note1;

    /**
     * Purpose of more bank information
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 35
     *
     * @var string|null $note2 - Purpose of more bank information or null for none
     */
    private $note2;

    /**
     * Bank-Information-Code (BankCCL) of bank account.
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 11
     *
     * @var string|null $bic - Bank-Information-Code (BankCCL) of bank account or null for none
     */
    private $bic;

    /**
     * Account reference to customer profile
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 35
     *
     * @var string|null $accountReference - Account reference to customer profile
     */
    private $accountReference;

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        unset(
            $this->accountOwnerName,
            $this->bankName,
            $this->iban,
            $this->note1,
            $this->note2,
            $this->bic,
            $this->accountReference
        );
    }

    /**
     * @return string
     */
    public function getAccountOwnerName(): string
    {
        return $this->accountOwnerName;
    }

    /**
     * @param string $accountOwnerName
     * @return BankData
     */
    public function setAccountOwnerName(string $accountOwnerName): BankData
    {
        $this->accountOwnerName = $accountOwnerName;

        return $this;
    }

    /**
     * @return string
     */
    public function getBankName(): string
    {
        return $this->bankName;
    }

    /**
     * @param string $bankName
     * @return BankData
     */
    public function setBankName(string $bankName): BankData
    {
        $this->bankName = $bankName;

        return $this;
    }

    /**
     * @return string
     */
    public function getIban(): string
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     * @return BankData
     */
    public function setIban(string $iban): BankData
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getNote1(): ?string
    {
        return $this->note1;
    }

    /**
     * @param string $note1
     * @return BankData
     */
    public function setNote1(string $note1): BankData
    {
        $this->note1 = $note1;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getNote2(): ?string
    {
        return $this->note2;
    }

    /**
     * @param string $note2
     * @return BankData
     */
    public function setNote2(string $note2): BankData
    {
        $this->note2 = $note2;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBic(): ?string
    {
        return $this->bic;
    }

    /**
     * @param string $bic
     * @return BankData
     */
    public function setBic(string $bic): BankData
    {
        $this->bic = $bic;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAccountReference(): ?string
    {
        return $this->accountReference;
    }

    /**
     * @param string $accountReference
     * @return BankData
     */
    public function setAccountReference(string $accountReference): BankData
    {
        $this->accountReference = $accountReference;

        return $this;
    }

    /**
     * Returns a DHL-Bank-Class
     *
     * @return Struct\BankData - DHL-Bank-Class
     */
    public function getStruct(): Struct\BankData
    {
        /** @var Struct\BankData $bankData */
        $bankData = new Struct\BankData();

        $bankData->accountOwner = $this->getAccountOwnerName();
        $bankData->bankName = $this->getBankName();
        $bankData->iban = $this->getIban();

        if ($this->getNote1() !== null) {
            $bankData->note1 = $this->getNote1();
        }

        if ($this->getNote2() !== null) {
            $bankData->note2 = $this->getNote2();
        }

        if ($this->getBic() !== null) {
            $bankData->bic = $this->getBic();
        }

        if ($this->getAccountReference() !== null) {
            $bankData->accountreference = $this->getAccountReference();
        }

        return $bankData;
    }
}
