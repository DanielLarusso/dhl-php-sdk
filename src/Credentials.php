<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class Credentials
 */
class Credentials
{
    /**
     * DHL Business-API Test-User
     */
    public const DHL_BUSINESS_TEST_USER = '2222222222_01';

    /**
     * DHL Business-API Test-User-Password
     */
    public const DHL_BUSINESS_TEST_USER_PASSWORD = 'pass';

    /**
     * DHL Business-API Test-EPK
     */
    public const DHL_BUSINESS_TEST_EPK = '2222222222';

    /**
     * Contains the DHL-Intraship Username
     *
     * TEST: Use the Test-User for Business-Shipment - Use in constructor true as 1st param
     * LIVE: Your DHL-Account same when you Login to the DHL-Business-Customer-Portal
     * (Same as on this Page: https://www.dhl-geschaeftskundenportal.de/ )
     *
     * @var string $user - DHL-Intraship Username
     */
    private $user = '';

    /**
     * Contains the DHL-Intraship Password
     *
     * TEST: Use the Test-Password for Business-Shipment - Use in constructor true as 1st param
     * LIVE: Your DHL-Account-Password same when you Login to the DHL-Business-Customer-Portal
     * (Same as on this Page: https://www.dhl-geschaeftskundenportal.de/ )
     *
     * @var string $signature - DHL-Intraship Password
     */
    private $signature = '';

    /**
     * Contains the DHL-Customer ID
     *
     * TEST: Use the Test-EPK for Business-Shipment - Use in constructor true as 1st param
     * LIVE: Your DHL-Customer-Number (At least the first 10 Numbers - Can be more)
     *
     * @var string $epk - DHL-Customer ID
     */
    private $epk = '';

    /**
     * Contains the App ID from the developer Account
     *
     * TEST: Your-DHL-Developer-Account-Name (Not E-Mail!)
     * (You can create yourself an Account for free here: https://entwickler.dhl.de/group/ep )
     *
     * LIVE: Your Applications-ID
     * (You can get this here: https://entwickler.dhl.de/group/ep/home?myaction=viewFreigabe )
     *
     * @var string $apiUser - App ID from the developer Account
     */
    private $apiUser = '';

    /**
     * Contains the App token from the developer Account
     *
     * TEST: Your-DHL-Developer-Accounts-Password
     * (You can create yourself an Account for free here: https://entwickler.dhl.de/group/ep )
     *
     * LIVE: Your Applications-Token
     * (You can get this here: https://entwickler.dhl.de/group/ep/home?myaction=viewFreigabe )
     *
     * @var string $apiPassword - Contains the App token from the developer Account
     */
    private $apiPassword = '';

    /**
     * Credentials constructor.
     *
     * If Test-Modus is true it will set Test-User, Test-Signature, Test-EPK for you!
     *
     * @param bool $testMode
     */
    public function __construct(bool $testMode = false)
    {
        if ($testMode) {
            $this->setUser(self::DHL_BUSINESS_TEST_USER);
            $this->setSignature(self::DHL_BUSINESS_TEST_USER_PASSWORD);
            $this->setEpk(self::DHL_BUSINESS_TEST_EPK);
        }
    }

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        unset(
            $this->user,
            $this->signature,
            $this->epk,
            $this->apiUser,
            $this->apiPassword
        );
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Sets the User in lower case
     *
     * @param string $user - Username
     * @return Credentials
     */
    public function setUser(string $user): Credentials
    {
        $this->user = \mb_strtolower($user);

        return $this;
    }

    /**
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * @param string $signature
     * @return Credentials
     */
    public function setSignature(string $signature): Credentials
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get the first 10 Digits of the EPK
     *
     * @param null|int $len - Max-Chars to get from this String or null for all
     * @return string - EPK-Number with x Chars
     */
    public function getEpk(?int $len = null): string
    {
        return \mb_substr($this->epk, 0, $len);
    }

    /**
     * @param string $epk
     * @return Credentials
     */
    public function setEpk(string $epk): Credentials
    {
        $this->epk = $epk;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiUser(): string
    {
        return $this->apiUser;
    }

    /**
     * @param string $apiUser
     * @return Credentials
     */
    public function setApiUser(string $apiUser): Credentials
    {
        $this->apiUser = $apiUser;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiPassword(): string
    {
        return $this->apiPassword;
    }

    /**
     * @param string $apiPassword
     * @return Credentials
     */
    public function setApiPassword(string $apiPassword): Credentials
    {
        $this->apiPassword = $apiPassword;

        return $this;
    }
}
