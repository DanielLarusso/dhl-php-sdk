<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class Version
 */
abstract class Version
{
    /**
     * Current-Version
     *
     * @var string $version - Current-Version
     */
    private $version;

    /**
     * Mayor-Version-Number
     *
     * @var int $mayor - Mayor-Version-Number
     */
    private $mayor;

    /**
     * Minor-Version-Number
     *
     * @var int $minor - Minor-Version-Number
     */
    private $minor;

    /**
     * Version constructor.
     *
     * @param string $version
     */
    protected function __construct(string $version)
    {
        $this->setVersion($version);
    }

    /**
     * Clears Memory
     */
    protected function __destruct()
    {
        unset($this->version, $this->mayor, $this->minor);
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Set/Change the Version and also Update Mayor and Minor-Fields
     *
     * @param string $version - Version
     * @return Version
     */
    protected function setVersion(string $version): Version
    {
        $this->version = $version;

        $numbers = \explode('.', $version);

        // Update Mayor and Minor-Version-Numbers
        $this->setMayor((int)$numbers[0]);
        $this->setMinor((int)$numbers[1]);

        return $this;
    }

    /**
     * @return int
     */
    public function getMayor(): int
    {
        return $this->mayor;
    }

    /**
     * @param int $mayor
     * @return Version
     */
    private function setMayor(int $mayor): Version
    {
        $this->mayor = $mayor;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinor(): int
    {
        return $this->minor;
    }

    /**
     * @param int $minor
     * @return Version
     */
    private function setMinor(int $minor): Version
    {
        $this->minor = $minor;

        return $this;
    }

    /**
     * Returns the Version DHL-Class
     *
     * @return \stdClass - Version DHL-Class
     */
    protected function getVersionClass(): \stdClass
    {
        /** @var \stdClass $class */
        $class = new \stdClass;

        $class->majorRelease = $this->getMayor();
        $class->minorRelease = $this->getMinor();

        return $class;
    }

    /**
     * Gets the API-URL by Version
     *
     * @return string - API-Url
     */
    abstract protected function getAPIUrl(): string;
}
