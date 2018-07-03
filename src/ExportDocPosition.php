<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class ExportDocPosition
 *
 * Note: If min 1 value is filled out, all other values are required (else none is required)
 */
class ExportDocPosition
{
    /**
     * Description of the unit / position
     *
     * Min-Len: -
     * Max-Len: 256
     *
     * @var string|null $description - Description of the unit / position
     */
    private $description;

    /**
     * Origin Country-ISO-Code
     *
     * Min-Len: 2
     * Max-Len: 2
     *
     * @var string|null $countryCodeOrigin - Origin Country-ISO-Code
     */
    private $countryCodeOrigin;

    /**
     * Customs tariff number of the unit / position
     *
     * Min-Len: -
     * Max-Len: 10
     *
     * @var string|null $customsTariffNumber - Customs tariff number of the unit / position (HS-code)
     */
    private $customsTariffNumber;

    /**
     * Quantity of the unit / position
     *
     * @var int|null $amount - Quantity of the unit / position
     */
    private $amount;

    /**
     * Net weight of the unit / position
     *
     * @var float|null $netWeightInKG - Net weight of the unit / position
     */
    private $netWeightInKG;

    /**
     * Customs value amount of the unit / position
     *
     * @var float|null $customsValue - Customs value amount of the unit / position
     */
    private $customsValue;

    /**
     * ExportDocPosition constructor.
     *
     * @param string $description - Description of the unit / position
     * @param string $countryCodeOrigin - Origin Country-ISO-Code
     * @param string|null $customsTariffNumber - Customs tariff number of the unit / position (HS-code)
     * @param int $amount - Quantity of the unit / position
     * @param float $netWeightInKG - Net weight of the unit / position
     * @param float $customsValue - Customs value amount of the unit / position
     */
    public function __construct(
        string $description,
        string $countryCodeOrigin,
        ?string $customsTariffNumber,
        int $amount,
        float $netWeightInKG,
        float $customsValue
    ) {
        if (!$description || !$countryCodeOrigin || !$amount || !$netWeightInKG || !$customsValue) {
            error_log('PHP-DHL-API: ' . __CLASS__ . '->' . __FUNCTION__ .
                ': All values must be filled out! (Not null, Not false, Not 0, Not "", Not empty) - Ignore this function for this call now');
            return;
        }

        $this->setDescription($description);
        $this->setCountryCodeOrigin($countryCodeOrigin);
        $this->setCustomsTariffNumber($customsTariffNumber);
        $this->setAmount($amount);
        $this->setNetWeightInKG($netWeightInKG);
        $this->setCustomsValue($customsValue);
    }

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        unset(
            $this->description,
            $this->countryCodeOrigin,
            $this->customsTariffNumber,
            $this->amount,
            $this->netWeightInKG,
            $this->customsValue
        );
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return ExportDocPosition
     */
    private function setDescription(?string $description): ExportDocPosition
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCodeOrigin(): ?string
    {
        return $this->countryCodeOrigin;
    }

    /**
     * @param string|null $countryCodeOrigin
     * @return ExportDocPosition
     */
    private function setCountryCodeOrigin(?string $countryCodeOrigin): ExportDocPosition
    {
        $this->countryCodeOrigin = $countryCodeOrigin;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomsTariffNumber(): ?string
    {
        return $this->customsTariffNumber;
    }

    /**
     * @param string|null $customsTariffNumber
     * @return ExportDocPosition
     */
    private function setCustomsTariffNumber(?string $customsTariffNumber): ExportDocPosition
    {
        $this->customsTariffNumber = $customsTariffNumber;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     * @return ExportDocPosition
     */
    private function setAmount(?int $amount): ExportDocPosition
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getNetWeightInKG(): ?float
    {
        return $this->netWeightInKG;
    }

    /**
     * @param float|null $netWeightInKG
     * @return ExportDocPosition
     */
    private function setNetWeightInKG(?float $netWeightInKG): ExportDocPosition
    {
        $this->netWeightInKG = $netWeightInKG;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getCustomsValue(): ?float
    {
        return $this->customsValue;
    }

    /**
     * @param float|null $customsValue
     * @return ExportDocPosition
     */
    private function setCustomsValue(?float $customsValue): ExportDocPosition
    {
        $this->customsValue = $customsValue;

        return $this;
    }

    /**
     * @return \stdClass
     */
    protected function getExportDocPositionClass_v1(): \stdClass
    {
        $class = new \stdClass;

        // todo implement

        return $class;
    }

    /**
     * Returns a Class for ExportDocPosition
     *
     * @return Struct\ExportDocPosition - DHL-ExportDocPosition-Class
     */
    public function getStruct(): Struct\ExportDocPosition
    {
        /** @var Struct\ExportDocPosition $class */
        $exportDocPosition = new Struct\ExportDocPosition;

        $exportDocPosition->description = $this->getDescription();
        $exportDocPosition->countryCodeOrigin = $this->getCountryCodeOrigin();
        $exportDocPosition->customsTariffNumber = $this->getCustomsTariffNumber();
        $exportDocPosition->amount = $this->getAmount();
        $exportDocPosition->netWeightInKG = $this->getNetWeightInKG();
        $exportDocPosition->customsValue = $this->getCustomsValue();

        return $exportDocPosition;
    }
}
