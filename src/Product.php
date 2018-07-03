<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class Product
 */
class Product
{
    /**
     * Contains the Product-Type
     *
     * @var string $type - Product-Type
     */
    private $type;

    /**
     * Contains the Name of the Product
     *
     * @var string $name - Name of the Product
     */
    private $name = '';

    /**
     * Can this Product Send to Austria
     *
     * @var boolean $austria - Is send to Austria allowed
     */
    private $austria = false;

    /**
     * Contains the Min-Length of this Product
     *
     * @var float $minLength - Min-Length of this Product
     */
    private $minLength = 0.0;

    /**
     * Contains the Max-Length of this Product
     *
     * @var float $maxLength - Max-Length of this Product
     */
    private $maxLength = 0.0;

    /**
     * Contains the Min-Width of this Product
     *
     * @var float $minWidth - Min-Width of this Product
     */
    private $minWidth = 0.0;

    /**
     * Contains the Max-Width of this Product
     *
     * @var float $maxWidth - Max-Width of this Product
     */
    private $maxWidth = 0.0;

    /**
     * Contains the Min-Height of the Product
     *
     * @var float|int $minHeight - Min-Height of the Product
     */
    private $minHeight = 0;

    /**
     * Contains the Max-Height of the Product
     *
     * @var float $maxHeight - Max-Height of the Product
     */
    private $maxHeight = 0.0;

    /**
     * Contains the Max-Weight of this Product
     *
     * @var float $maxWeight - Max-Weight of this Product
     */
    private $maxWeight = 0.0;

    /**
     * Contains all Services for this Product
     *
     * @var array $services - All Services for this Product
     */
    private $services = [];

    /**
     * Product constructor.
     *
     * @param string $type - Product-Type
     */
    public function __construct($type)
    {
        $this->setType($type);
    }

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        unset(
            $this->type,
            $this->name,
            $this->austria,
            $this->minLength,
            $this->maxLength,
            $this->minWidth,
            $this->maxWidth,
            $this->minHeight,
            $this->maxHeight,
            $this->maxWeight,
            $this->services
        );
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Product
     */
    private function setType(string $type): Product
    {
        $this->type = $type;

        return $this;
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
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAustria(): bool
    {
        return $this->austria;
    }

    /**
     * @param bool $austria
     * @return Product
     */
    public function setAustria(bool $austria): Product
    {
        $this->austria = $austria;

        return $this;
    }

    /**
     * @return float
     */
    public function getMinLength(): float
    {
        return $this->minLength;
    }

    /**
     * @param float $minLength
     * @return Product
     */
    public function setMinLength(float $minLength): Product
    {
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * @return float
     */
    public function getMaxLength(): float
    {
        return $this->maxLength;
    }

    /**
     * @param float $maxLength
     * @return Product
     */
    public function setMaxLength(float $maxLength): Product
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * @return float
     */
    public function getMinWidth(): float
    {
        return $this->minWidth;
    }

    /**
     * @param float $minWidth
     * @return Product
     */
    public function setMinWidth(float $minWidth): Product
    {
        $this->minWidth = $minWidth;

        return $this;
    }

    /**
     * @return float
     */
    public function getMaxWidth(): float
    {
        return $this->maxWidth;
    }

    /**
     * @param float $maxWidth
     * @return Product
     */
    public function setMaxWidth(float $maxWidth): Product
    {
        $this->maxWidth = $maxWidth;

        return $this;
    }

    /**
     * @return float
     */
    public function getMinHeight(): float
    {
        return $this->minHeight;
    }

    /**
     * @param float $minHeight
     * @return Product
     */
    public function setMinHeight(float $minHeight): Product
    {
        $this->minHeight = $minHeight;

        return $this;
    }

    /**
     * @return float
     */
    public function getMaxHeight(): float
    {
        return $this->maxHeight;
    }

    /**
     * @param float $maxHeight
     * @return Product
     */
    public function setMaxHeight(float $maxHeight): Product
    {
        $this->maxHeight = $maxHeight;

        return $this;
    }

    /**
     * @return float
     */
    public function getMaxWeight(): float
    {
        return $this->maxWeight;
    }

    /**
     * @param float $maxWeight
     * @return Product
     */
    public function setMaxWeight(float $maxWeight): Product
    {
        $this->maxWeight = $maxWeight;

        return $this;
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @param array $services
     * @return Product
     */
    public function setServices(array $services): Product
    {
        $this->services = $services;

        return $this;
    }

    /**
     * Adds a Service
     *
     * @param string $service - Service to add
     * @return Product
     */
    public function addService(string $service): Product
    {
        $this->services[] = $service;

        return $this;
    }

    /**
     * Checks if this Products has a Service
     *
     * @param string $service - Service to check
     * @return bool - Has this Product this Service
     */
    public function hasService(string $service): bool
    {
        return \in_array($service, $this->services, true);
    }
}
