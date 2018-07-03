<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class BusinessShipment
 */
class BusinessShipment extends Version
{
    /**
     * DHL Origin WSDL-Lib-URL
     */
    public const DHL_WSDL_LIB_URL = 'https://cig.dhl.de/cig-wsdls/com/dpdhl/wsdl/geschaeftskundenversand-api/';

    /**
     * DHL-Soap-Header URL
     */
    public const DHL_SOAP_HEADER_URI = 'http://dhl.de/webservice/cisbase';

    /**
     * DHL-Sandbox SOAP-URL
     */
    public const DHL_SANDBOX_URL = 'https://cig.dhl.de/services/sandbox/soap';

    /**
     * DHL-Live SOAP-URL
     */
    public const DHL_PRODUCTION_URL = 'https://cig.dhl.de/services/production/soap';

    /**
     * Newest-Version
     */
    public const NEWEST_VERSION = '2.2';

    /**
     * Response-Type URL
     */
    public const RESPONSE_TYPE_URL = 'URL';

    /**
     * Response-Type Base64
     */
    public const RESPONSE_TYPE_B64 = 'B64';

    // System-Fields
    /**
     * Contains the Soap Client
     *
     * @var \SoapClient|null $soapClient - Soap-Client
     */
    private $soapClient;

    /**
     * Contains the error array
     *
     * @var array $errors - Error-Array
     */
    private $errors = [];

    // Setting-Fields
    /**
     * Contains if the Object runs in Sandbox-Mode
     *
     * @var bool $test - Is Sandbox-Mode
     */
    private $test;

    /**
     * Contains if Log is enabled
     *
     * @var bool $log - Is Logging enabled
     */
    private $log = false;

    // Object-Fields
    /**
     * Contains the Credentials Object
     *
     * Notes: Is required every time! Used to login
     *
     * @var Credentials $credentials - Credentials Object
     */
    private $credentials;

    /**
     * Contains the Shipment Details
     *
     * @var ShipmentDetails $shipmentDetails - Shipment Details Object
     */
    private $shipmentDetails;

    /**
     * Contains the Service Object (Many settings for the Shipment)
     *
     * Note: Optional
     *
     * @var Service|null $service - Service Object
     */
    private $service;

    /**
     * Contains the Bank-Object
     *
     * Note: Optional
     *
     * @var BankData|null $bank - Bank-Object
     */
    private $bank;

    /**
     * Contains the Sender-Object
     *
     * @var Sender $sender - Sender Object
     */
    private $sender;

    /**
     * Contains the Receiver-Object
     *
     * @var Receiver $receiver - Receiver Object
     */
    private $receiver;

    /**
     * Contains the Return Receiver Object
     *
     * Note: Optional
     *
     * @var ReturnReceiver|null $returnReceiver - Return Receiver Object
     */
    private $returnReceiver;

    /**
     * Contains the Export-Document-Settings Object
     *
     * Note: Optional
     *
     * @var ExportDocument|null $exportDocument - Export-Document-Settings Object
     */
    private $exportDocument;

    // Fields
    /**
     * Contains the Sequence-Number
     *
     * Min-Len: -
     * Max-Len: 30
     *
     * @var string $sequenceNumber - Sequence-Number
     */
    private $sequenceNumber = '1';

    /**
     * Contains the Receiver-E-Mail (Used for Notification to the Receiver)
     *
     * Note: Optional
     * Min-Len: -
     * Max-Len: 70
     *
     * @var string|null $receiverEmail - Receiver-E-Mail
     */
    private $receiverEmail;

    /**
     * Contains if the label will be only be printable, if the receiver address is valid.
     *
     * Note: Optional
     *
     * @var bool|null $printOnlyIfReceiverIsValid - true will only print if receiver address is valid else false (null uses default)
     */
    private $printOnlyIfReceiverIsValid;

    /**
     * Contains if how the Label-Response-Type will be
     *
     * Note: Optional
     * Values:
     * RESPONSE_TYPE_URL -> Url
     * RESPONSE_TYPE_B64 -> Base64
     *
     * @var string|null $labelResponseType - Label-Response-Type (Can use class constance's)
     */
    private $labelResponseType;

    /**
     * Custom-WSDL-File URL
     *
     * @var null|string $customAPIURL - Custom-API URL to use internal let this value null
     */
    private $customAPIURL;

    /**
     * BusinessShipment constructor.
     *
     * @param Credentials $credentials - DHL-Credentials-Object
     * @param bool $testMode - Uses the Sandbox-Modus or Live (True uses test-Modus)
     * @param null|string $version - Version to use or null for the newest
     */
    public function __construct(
        Credentials $credentials,
        bool $testMode = false,
        ?string $version = null
    ) {
        // Set Version
        if ($version === null) {
            $version = self::NEWEST_VERSION;
        }

        parent::__construct($version);

        // Set Test-Modus
        $this->setTest($testMode);

        // Set Credentials
        if ($this->isTest()) {
            $c = new Credentials(true);
            $c->setApiUser($credentials->getApiUser());
            $c->setApiPassword($credentials->getApiPassword());

            $credentials = $c;
        }

        $this->setCredentials($credentials);

        // Set Shipment-Class
        $this->setShipmentDetails(new ShipmentDetails($credentials->getEpk(10) . '0101'));
    }

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        parent::__destruct();
        unset(
            $this->soapClient,
            $this->errors,
            $this->test,
            $this->log,
            $this->credentials,
            $this->shipmentDetails,
            $this->service,
            $this->bank,
            $this->sender,
            $this->receiver,
            $this->returnReceiver,
            $this->exportDocument,
            $this->sequenceNumber,
            $this->receiverEmail,
            $this->printOnlyIfReceiverIsValid,
            $this->labelResponseType,
            $this->customAPIURL
        );
    }

    /**
     * Get the Business-API-URL for this Version
     *
     * @return string - Business-API-URL
     */
    protected function getAPIUrl(): string
    {
        // Use own API-URL if set
        if (null !== $this->getCustomAPIURL()) {
            return $this->getCustomAPIURL();
        }

        return self::DHL_WSDL_LIB_URL . $this->getVersion() . '/geschaeftskundenversand-api-' . $this->getVersion() . '.wsdl';
    }

    /**
     * @return null|\SoapClient
     */
    private function getSoapClient(): ?\SoapClient
    {
        if (!$this->soapClient instanceof \SoapClient) {
            $this->buildSoapClient();
        }

        return $this->soapClient;
    }

    /**
     * Returns the Last XML-Request or null
     *
     * @return null|string - Last XML-Request or null if none
     */
    public function getLastXML(): ?string
    {
        if (!$this->soapClient instanceof \SoapClient) {
            return null;
        }

        return $this->getSoapClient()->__getLastRequest();
    }

    /**
     * @param null|\SoapClient $soapClient
     * @return BusinessShipment
     */
    private function setSoapClient(?\SoapClient $soapClient): BusinessShipment
    {
        $this->soapClient = $soapClient;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return BusinessShipment
     */
    public function setErrors(array $errors): BusinessShipment
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @param string $error
     * @return BusinessShipment
     */
    private function addError(string $error): BusinessShipment
    {
        $this->errors[] = $error;

        return $this;
    }

    /**
     * @return bool
     */
    private function isTest(): bool
    {
        return $this->test;
    }

    /**
     * @param bool $test
     * @return BusinessShipment
     */
    private function setTest(bool $test): BusinessShipment
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLog(): bool
    {
        return $this->log;
    }

    /**
     * @param bool $log
     * @return BusinessShipment
     */
    public function setLog(bool $log): BusinessShipment
    {
        $this->log = $log;

        return $this;
    }

    /**
     * @return Credentials
     */
    private function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    /**
     * @param Credentials $credentials
     * @return BusinessShipment
     */
    public function setCredentials(Credentials $credentials): BusinessShipment
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * @return ShipmentDetails
     */
    public function getShipmentDetails(): ShipmentDetails
    {
        return $this->shipmentDetails;
    }

    /**
     * @param ShipmentDetails $shipmentDetails
     * @return BusinessShipment
     */
    public function setShipmentDetails(ShipmentDetails $shipmentDetails): BusinessShipment
    {
        $this->shipmentDetails = $shipmentDetails;

        return $this;
    }

    /**
     * @return Service|null
     */
    public function getService(): ?Service
    {
        return $this->service;
    }

    /**
     * @param Service|null $service
     * @return BusinessShipment
     */
    public function setService(?Service $service): BusinessShipment
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return BankData|null
     */
    public function getBank(): ?BankData
    {
        return $this->bank;
    }

    /**
     * @param BankData|null $bankData
     * @return BusinessShipment
     */
    public function setBank(?BankData $bankData): BusinessShipment
    {
        $this->bank = $bankData;

        return $this;
    }

    /**
     * @return Sender
     */
    public function getSender(): Sender
    {
        return $this->sender;
    }

    /**
     * @param Sender $sender
     * @return BusinessShipment
     */
    public function setSender(Sender $sender): BusinessShipment
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return Receiver
     */
    public function getReceiver(): Receiver
    {
        return $this->receiver;
    }

    /**
     * @param Receiver $receiver
     * @return BusinessShipment
     */
    public function setReceiver(Receiver $receiver): BusinessShipment
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return ReturnReceiver|null
     */
    public function getReturnReceiver(): ?ReturnReceiver
    {
        return $this->returnReceiver;
    }

    /**
     * @param ReturnReceiver|null $returnReceiver
     * @return BusinessShipment
     */
    public function setReturnReceiver(?ReturnReceiver $returnReceiver): BusinessShipment
    {
        $this->returnReceiver = $returnReceiver;

        return $this;
    }

    /**
     * @return ExportDocument|null
     */
    public function getExportDocument(): ?ExportDocument
    {
        return $this->exportDocument;
    }

    /**
     * @param ExportDocument|null $exportDocument
     * @return BusinessShipment
     */
    public function setExportDocument(?ExportDocument $exportDocument): BusinessShipment
    {
        $this->exportDocument = $exportDocument;

        return $this;
    }

    /**
     * @return string
     */
    public function getSequenceNumber(): string
    {
        return $this->sequenceNumber;
    }

    /**
     * @param string $sequenceNumber
     * @return BusinessShipment
     */
    public function setSequenceNumber(string $sequenceNumber): BusinessShipment
    {
        $this->sequenceNumber = $sequenceNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getReceiverEmail(): ?string
    {
        return $this->receiverEmail;
    }

    /**
     * @param null|string $receiverEmail
     * @return BusinessShipment
     */
    public function setReceiverEmail(?string $receiverEmail): BusinessShipment
    {
        $this->receiverEmail = $receiverEmail;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPrintOnlyIfReceiverIsValid(): ?bool
    {
        return $this->printOnlyIfReceiverIsValid;
    }

    /**
     * @param bool|null $printOnlyIfReceiverIsValid
     * @return BusinessShipment
     */
    public function setPrintOnlyIfReceiverIsValid(?bool $printOnlyIfReceiverIsValid): BusinessShipment
    {
        $this->printOnlyIfReceiverIsValid = $printOnlyIfReceiverIsValid;
    }

    /**
     * @return null|string
     */
    public function getLabelResponseType(): ?string
    {
        return $this->labelResponseType;
    }

    /**
     * @param null|string $labelResponseType
     * @return BusinessShipment
     */
    public function setLabelResponseType(?string $labelResponseType): BusinessShipment
    {
        $this->labelResponseType = $labelResponseType;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCustomAPIURL(): ?string
    {
        return $this->customAPIURL;
    }

    /**
     * @param null|string $customAPIURL
     * @return BusinessShipment
     */
    public function setCustomAPIURL(?string $customAPIURL): BusinessShipment
    {
        $this->customAPIURL = $customAPIURL;

        return $this;
    }

    /**
     * Add the Massage to Log if enabled
     *
     * @param mixed $message - Message to add to Log
     * @return BusinessShipment
     */
    private function log($message): BusinessShipment
    {
        if (!$this->isLog()) {
            return $this;
        }

        if (\is_array($message) || \is_object($message)) {
            \error_log(\print_r($message, true));
            return $this;
        }

        \error_log($message);

        return $this;
    }

    /**
     * Build SOAP-Auth-Header
     *
     * @return \SoapHeader
     */
    private function buildAuthHeader(): \SoapHeader
    {
        /** @var array $params */
        $params = [
            'user' => $this->getCredentials()->getUser(),
            'signature' => $this->getCredentials()->getSignature(),
            'type' => 0
        ];

        return new \SoapHeader(self::DHL_SOAP_HEADER_URI, 'Authentification', $params);
    }

    /**
     * Builds the Soap-Client
     * @return BusinessShipment
     */
    private function buildSoapClient(): BusinessShipment
    {
        /** @var \SoapHeader $header */
        $header = $this->buildAuthHeader();

        /** @var string $location */
        $location = $this->isTest() ? self::DHL_SANDBOX_URL : self::DHL_PRODUCTION_URL;

        /** @var array $params */
        $params = [
            'login' => $this->getCredentials()->getApiUser(),
            'password' => $this->getCredentials()->getApiPassword(),
            'location' => $location,
            'trace' => 1
        ];

        $this->log($params);
        $this->setSoapClient(new \SoapClient($this->getAPIUrl(), $params));
        $this->getSoapClient()->__setSoapHeaders($header);
        $this->log($this->getSoapClient());

        return $this;
    }

    /**
     * Creates the doManifest-Request via SOAP
     *
     * @param Object|array $data - Manifest-Data
     * @return Object - DHL-Response
     */
    private function sendDoManifestRequest($data)
    {
        switch ($this->getMayor()) {
            case 1:
                return $this->getSoapClient()->DoManifestTD($data); // todo verify if correct
            case 2:
            default:
                return $this->getSoapClient()->doManifest($data);
        }
    }

    /**
     * Creates the doManifest-Request
     *
     * @param string $shipmentNumber - Shipment-Number for Manifest
     * @return bool|Response - false on error or DHL-Response Object
     */
    public function doManifest(string $shipmentNumber)
    {
        switch ($this->getMayor()) {
            case 1:
                $data = $this->createDoManifestClass_v1($shipmentNumber);
                break;
            case 2:
            default:
                $data = $this->createDoManifestClass_v2($shipmentNumber);
        }

        try {
            $response = $this->sendDoManifestRequest($data);
        } catch (\Exception $e) {
            $this->addError($e->getMessage());

            return false;
        }

        if (\is_soap_fault($response)) {
            $this->addError($response->faultstring);

            return false;
        }

        return new Response($this->getVersion(), $response);
    }

    /**
     * Creates the Data-Object for Manifest
     *
     * @param string $shipmentNumber - Shipment-Number for the Manifest
     * @return \stdClass - Data-Object
     */
    private function createDoManifestClass_v1(string $shipmentNumber): \stdClass
    {
        $data = new \stdClass;

        //todo

        return $data;
    }

    /**
     * Creates the Data-Object for Manifest
     *
     * @param string $shipmentNumber - Shipment-Number for the Manifest
     * @return \stdClass - Data-Object
     */
    private function createDoManifestClass_v2(string $shipmentNumber): \stdClass
    {
        $data = new \stdClass;

        $data->Version = $this->getVersionClass();
        $data->shipmentNumber = $shipmentNumber;

        return $data;
    }

    /**
     * Creates the Shipment-Order Request via SOAP
     *
     * @param Object|array $data - Shipment-Data
     * @return Object - DHL-Response
     */
    private function sendCreateRequest($data)
    {
        switch ($this->getMayor()) {
            case 1:
                return $this->getSoapClient()->CreateShipmentDD($data);
            case 2:
            default:
                return $this->getSoapClient()->createShipmentOrder($data);
        }
    }

    /**
     * Creates the Shipment-Request
     *
     * @return bool|Response - false on error or DHL-Response Object
     */
    public function createShipment()
    {
        switch ($this->getMayor()) {
            case 1:
                $data = $this->createShipmentClass_v1();
                break;
            case 2:
            default:
                $data = $this->createShipmentClass_v2();
        }

        $response = null;

        // Create Shipment
        try {
            $response = $this->sendCreateRequest($data);
        } catch (\Exception $e) {
            $this->addError($e->getMessage());

            return false;
        }

        if (\is_soap_fault($response)) {
            $this->addError($response->faultstring);

            return false;
        }

        return new Response($this->getVersion(), $response, $this->getLabelResponseType());
    }

    /**
     * Creates the Data-Object for the Request
     *
     * @return \stdClass - Data-Object
     */
    private function createShipmentClass_v1(): \stdClass
    {
        $data = new \stdClass;

        //todo

        return $data;
    }

    /**
     * Creates the Data-Object for the Request
     *
     * @return \stdClass - Data-Object
     */
    private function createShipmentClass_v2(): \stdClass
    {
        /** @var \stdClass $data */
        $data = new \stdClass;
        $data->Version = $this->getVersionClass();
        $data->ShipmentOrder = new \stdClass;
        $data->ShipmentOrder->sequenceNumber = $this->getSequenceNumber();

        // Shipment
        $data->ShipmentOrder->Shipment = new \stdClass;
        $data->ShipmentOrder->Shipment->ShipmentDetails = $this->getShipmentDetails()->getShipmentDetailsClass_v2();

        // Service
        if ($this->getService() !== null) {
            $data->ShipmentOrder->Shipment->ShipmentDetails->Service = $this->getService()->getServiceClass_v2($this->getShipmentDetails()->getProduct());
        }

        // Notification
        if ($this->getReceiverEmail() !== null) {
            $data->ShipmentOrder->Shipment->ShipmentDetails->Notification = new \stdClass;
            $data->ShipmentOrder->Shipment->ShipmentDetails->Notification->recipientEmailAddress = $this->getReceiverEmail();
        }

        // Bank-Data
        if ($this->getBank() !== null) {
            $data->ShipmentOrder->Shipment->ShipmentDetails->BankData = $this->getBank()->getBankClass_v2();
        }

        // Shipper
        $data->ShipmentOrder->Shipment->Shipper = $this->getSender()->getClass_v2();

        // Receiver
        $data->ShipmentOrder->Shipment->Receiver = $this->getReceiver()->getClass_v2();

        // Return-Receiver
        if ($this->getReturnReceiver() !== null) {
            $data->ShipmentOrder->Shipment->ReturnReceiver = $this->getReturnReceiver()->getClass_v2();
        }

        // Export-Document
        if ($this->getExportDocument() !== null) {
            try {
                $data->ShipmentOrder->Shipment->ExportDocument = $this->getExportDocument()->getExportDocumentClass_v2();
            } catch (\Exception $e) {
                $this->addError($e->getMessage());
            }
        }

        // Other Settings
        if ($this->getPrintOnlyIfReceiverIsValid() !== null) {
            $data->ShipmentOrder->PrintOnlyIfCodeable = new \stdClass;
            $data->ShipmentOrder->PrintOnlyIfCodeable->active = (int)$this->getPrintOnlyIfReceiverIsValid();
        }

        if ($this->getLabelResponseType() !== null) {
            $data->ShipmentOrder->labelResponseType = $this->getLabelResponseType();
        }

        return $data;
    }

    /**
     * Creates the Shipment-Order-Delete Request via SOAP
     *
     * @param Object|array $data - Delete-Data
     * @return Object - DHL-Response
     */
    private function sendDeleteRequest($data)
    {
        switch ($this->getMayor()) {
            case 1:
                return $this->getSoapClient()->DeleteShipmentDD($data);
            case 2:
            default:
                return $this->getSoapClient()->deleteShipmentOrder($data);
        }
    }

    /**
     * Deletes a Shipment
     *
     * @param string $shipmentNumber - Shipment-Number of the Shipment to delete
     * @return bool|Response - Response
     */
    public function deleteShipment(string $shipmentNumber)
    {
        switch ($this->getMayor()) {
            case 1:
                $data = $this->createDeleteClass_v1($shipmentNumber);
                break;
            case 2:
            default:
                $data = $this->createDeleteClass_v2($shipmentNumber);
        }

        try {
            $response = $this->sendDeleteRequest($data);
        } catch (\Exception $e) {
            $this->addError($e->getMessage());

            return false;
        }

        if (\is_soap_fault($response)) {
            $this->addError($response->faultstring);

            return false;
        }

        return new Response($this->getVersion(), $response);
    }

    /**
     * Creates Data-Object for Deletion
     *
     * @param string $shipmentNumber - Shipment-Number of the Shipment to delete
     * @return \stdClass - Data-Object
     */
    private function createDeleteClass_v1(string $shipmentNumber): \stdClass
    {
        $data = new \stdClass;

        //todo

        return $data;
    }

    /**
     * Creates Data-Object for Deletion
     *
     * @param string $shipmentNumber - Shipment-Number of the Shipment to delete
     * @return \stdClass - Data-Object
     */
    private function createDeleteClass_v2(string $shipmentNumber): \stdClass
    {
        /** @var \stdClass $data */
        $data = new \stdClass;

        $data->Version = $this->getVersionClass();
        $data->shipmentNumber = $shipmentNumber;

        return $data;
    }

    /**
     * Requests a Label again via SOAP
     *
     * @param Object $data - Label-Data
     * @return Object - DHL-Response
     */
    private function sendGetLabelRequest($data)
    {
        switch ($this->getMayor()) {
            case 1:
                return $this->getSoapClient()->getLabelDD($data);
            case 2:
            default:
                return $this->getSoapClient()->getLabel($data);
        }
    }

    /**
     * Requests a Shipment-Label again
     *
     * @param string $shipmentNumber - Shipment-Number of the Label
     * @return bool|Response - Response or false on error
     */
    public function getShipmentLabel(string $shipmentNumber)
    {
        switch ($this->getMayor()) {
            case 1:
                $data = $this->getLabelClass_v1($shipmentNumber);
                break;
            case 2:
            default:
                $data = $this->getLabelClass_v2($shipmentNumber);
        }

        try {
            $response = $this->sendGetLabelRequest($data);
        } catch (\Exception $e) {
            $this->addError($e->getMessage());

            return false;
        }

        if (\is_soap_fault($response)) {
            $this->addError($response->faultstring);

            return false;
        }

        return new Response($this->getVersion(), $response, $this->getLabelResponseType());
    }

    /**
     * Creates Data-Object for Label-Request
     *
     * @param string $shipmentNumber - Number of the Shipment
     * @return \stdClass - Data-Object
     */
    private function getLabelClass_v1(string $shipmentNumber): \stdClass
    {
        $data = new \stdClass;

        // todo

        return $data;
    }

    /**
     * Creates Data-Object for Label-Request
     *
     * @param string $shipmentNumber - Number of the Shipment
     * @return \stdClass - Data-Object
     */
    private function getLabelClass_v2(string $shipmentNumber): \stdClass
    {
        /** @var \stdClass $data */
        $data = new \stdClass;

        $data->Version = $this->getVersionClass();
        $data->shipmentNumber = $shipmentNumber;
        if ($this->getLabelResponseType() !== null)
            $data->labelResponseType = $this->getLabelResponseType();

        return $data;
    }

    /**
     * Requests the Export-Document again via SOAP
     *
     * @param Object $data - Export-Doc-Data
     * @return Object - DHL-Response
     */
    private function sendGetExportDocRequest($data)
    {
        switch ($this->getMayor()) {
            case 1:
                return $this->getSoapClient()->getExportDocDD($data);
            case 2:
            default:
                return $this->getSoapClient()->getExportDoc($data);
        }
    }

    /**
     * Requests a Export-Document again
     *
     * @param string $shipmentNumber - Shipment-Number of the Export-Document
     * @return bool|Response - Response or false on error
     */
    public function getExportDoc(string $shipmentNumber)
    {
        switch ($this->getMayor()) {
            case 1:
                $data = $this->getExportDocClass_v1($shipmentNumber);
                break;
            case 2:
            default:
                $data = $this->getExportDocClass_v2($shipmentNumber);
        }

        try {
            $response = $this->sendGetExportDocRequest($data);
        } catch (\Exception $e) {
            $this->addError($e->getMessage());

            return false;
        }

        if (\is_soap_fault($response)) {
            $this->addError($response->faultstring);

            return false;
        }

        return new Response($this->getVersion(), $response);
    }

    /**
     * Creates Data-Object for Export-Document-Request
     *
     * @param string $shipmentNumber - Number of the Shipment
     * @return \stdClass - Data-Object
     */
    private function getExportDocClass_v1(string $shipmentNumber): \stdClass
    {
        $data = new \stdClass;

        // todo

        return $data;
    }

    /**
     * Creates Data-Object for Export-Document-Request
     *
     * @param string $shipmentNumber - Number of the Shipment
     * @return \stdClass - Data-Object
     */
    private function getExportDocClass_v2($shipmentNumber)
    {
        $data = new \stdClass;

        $data->Version = $this->getVersionClass();
        $data->shipmentNumber = $shipmentNumber;
        if ($this->getLabelResponseType() !== null)
            $data->exportDocResponseType = $this->getLabelResponseType();

        return $data;
    }

    /**
     * Validates a Shipment
     *
     * @return bool|Response - Response or false on error
     */
    public function validateShipment()
    {
        switch ($this->getMayor()) {
            case 1:
                $data = null;
                break;
            case 2:
            default:
                $data = $this->createShipmentClass_v2();
        }

        try {
            $response = $this->sendValidateShipmentRequest($data);
        } catch (\Exception $e) {
            $this->addError($e->getMessage());

            return false;
        }

        if (\is_soap_fault($response)) {
            $this->addError($response->faultstring);

            return false;
        }

        return new Response($this->getVersion(), $response);
    }

    /**
     * Requests the Validation of a Shipment via SOAP
     *
     * @param Object|array $data - Shipment-Data
     * @return Object - DHL-Response
     * @throws \RuntimeException - Method doesn't exists for Version
     */
    private function sendValidateShipmentRequest($data)
    {
        switch ($this->getMayor()) {
            case 1:
                throw new \RuntimeException(__FUNCTION__ . ': Method doesn\'t exists for Version 1!');
            case 2:
            default:
                return $this->getSoapClient()->validateShipment($data);
        }
    }
}
