<?php declare(strict_types=1);

namespace DanielLarusso\DHL;

/**
 * Class Response
 */
class Response extends Version
{
    /**
     * Contains Status-Code-Values
     */
    public const DHL_ERROR_NOT_SET = -1;
    public const DHL_ERROR_NO_ERROR = 0;
    public const DHL_ERROR_WEAK_WARNING = 1;
    public const DHL_ERROR_SERVICE_TMP_NOT_AVAILABLE = 500;
    public const DHL_ERROR_GENERAL = 1000;
    public const DHL_ERROR_AUTH_FAILED = 1001;
    public const DHL_ERROR_HARD_VAL_ERROR = 1101;
    public const DHL_ERROR_UNKNOWN_SHIPMENT_NUMBER = 2000;

    /**
     * Shipment-Number
     *
     * @var null|string $shipmentNumber - Shipment-Number
     */
    private $shipmentNumber;

    /**
     * TODO DOCUMENT ME
     *
     * Note: Just used in v1
     *
     * @var null|string $pieceNumber
     */
    private $pieceNumber;

    /**
     * Label URL/Base64-Data - Can also have the return label in one
     *
     * @var null|string $label - Label URL or Base64-Data
     */
    private $label;

    /**
     * Return Label URL/Base64-Data
     *
     * @var null|string $returnLabel - Return Label URL/Base64-Data or null if not requested
     */
    private $returnLabel;

    /**
     * Export-Document-Label-URL/Base64-Data
     *
     * @var null|string $exportDoc - Export-Document Label URL/Base64-Data or null if not requested
     */
    private $exportDoc;

    /**
     * Label-Response-Type (Base64 or URL)
     *
     * @var null|string $labelType - Label-Response-Type
     */
    private $labelType;

    /**
     * Sequence-Number
     *
     * @var string|null $sequenceNumber - Sequence-Number of the Request (Useful for AJAX-Requests)
     */
    private $sequenceNumber;

    /**
     * Contains the Status-Code
     *
     * @var int $statusCode - Status-Code see DHL_ERROR_* Constance's
     */
    private $statusCode = self::DHL_ERROR_NOT_SET;

    /**
     * Contains the Status-Text
     *
     * @var string|null $statusText - Status-Text
     */
    private $statusText;

    /**
     * Contains the Status-Message (Mostly more detailed, but longer) - Array if multiple Messages
     *
     * @var string|array|null $statusMessage - Status-Message
     */
    private $statusMessage;

    /**
     * Response constructor.
     *
     * @param string $version - Current DHL-Version
     * @param null|Object $response - DHL-Response
     * @param null|string $labelType - Label-Response-Type
     */
    public function __construct(
        string $version,
        $response = null,
        ?string $labelType = null
    )
    {
        parent::__construct($version);

        $this->setLabelType($labelType);

        if ($response !== null) {
            switch ($this->getMayor()) {
                case 1:
                    $this->loadResponse_v1($response);
                    break;
                case 2:
                default:
                    $this->loadResponse_v2($response);
            }
        }
    }

    /**
     * Clears Memory
     */
    public function __destruct()
    {
        parent::__destruct();
        unset(
            $this->shipmentNumber,
            $this->pieceNumber,
            $this->label,
            $this->returnLabel,
            $this->exportDoc,
            $this->labelType,
            $this->sequenceNumber,
            $this->statusCode,
            $this->statusText,
            $this->statusMessage
        );
    }

    /**
     * @return null|string
     */
    public function getShipmentNumber(): ?string
    {
        return $this->shipmentNumber;
    }

    /**
     * @param null|string $shipmentNumber
     * @return Response
     */
    private function setShipmentNumber(?string $shipmentNumber): Response
    {
        $this->shipmentNumber = $shipmentNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPieceNumber(): ?string
    {
        return $this->pieceNumber;
    }

    /**
     * @param null|string $pieceNumber
     * @return Response
     */
    private function setPieceNumber(?string $pieceNumber): Response
    {
        $this->pieceNumber = $pieceNumber;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param null|string $label
     * @return Response
     */
    private function setLabel(?string $label): Response
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getReturnLabel(): ?string
    {
        return $this->returnLabel;
    }

    /**
     * @param null|string $returnLabel
     * @return Response
     */
    private function setReturnLabel(?string $returnLabel)
    {
        $this->returnLabel = $returnLabel;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getExportDoc(): ?string
    {
        return $this->exportDoc;
    }

    /**
     * @param null|string $exportDoc
     * @return Response
     */
    private function setExportDoc(?string $exportDoc): Response
    {
        $this->exportDoc = $exportDoc;

        return $this;
    }

    /**
     * @return null|string
     */
    private function getLabelType(): ?string
    {
        return $this->labelType;
    }

    /**
     * @param null|string $labelType
     * @return Response
     */
    private function setLabelType(?string $labelType): Response
    {
        $this->labelType = $labelType;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSequenceNumber(): ?string
    {
        return $this->sequenceNumber;
    }

    /**
     * @param string|null $sequenceNumber
     * @return Response
     */
    private function setSequenceNumber(?string $sequenceNumber): Response
    {
        $this->sequenceNumber = $sequenceNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return Response
     */
    private function setStatusCode(int $statusCode): Response
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatusText(): ?string
    {
        return $this->statusText;
    }

    /**
     * @param string|null $statusText
     * @return Response
     */
    private function setStatusText(?string $statusText): Response
    {
        $this->statusText = $statusText;

        return $this;
    }

    /**
     * @return string|array|null
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * @param string|array|null $statusMessage
     */
    private function setStatusMessage($statusMessage)
    {
        $this->statusMessage = $statusMessage;
    }

    /**
     * Loads a DHL-Response into this Object
     *
     * @param Object $response - DHL-Response
     */
    private function loadResponse_v1($response)
    {
        // Set Shipment-Number if exists
        if (isset($response->CreationState->ShipmentNumber->shipmentNumber)) {
            $this->setShipmentNumber((string)$response->CreationState->ShipmentNumber->shipmentNumber);
        }

        if (isset($response->CreationState->PieceInformation->PieceNumber->licensePlate)) {
            $this->setPieceNumber((string)$response->CreationState->PieceInformation->PieceNumber->licensePlate);
        }

        // Set Label if exists
        if ($this->getLabelType() === BusinessShipment::RESPONSE_TYPE_B64) {
            if (isset($response->CreationState->Labeldata)) // todo: is valid???
            {
                $this->setLabel($response->CreationState->Labeldata);
            }
        } else if (isset($response->CreationState->Labelurl)) {
            $this->setLabel($response->CreationState->Labelurl);
        }

        $this->setStatusCode((int)$response->status->StatusCode);
        $this->setStatusMessage($response->status->StatusMessage);
        //todo add more from v1
    }

    /**
     * Loads a DHL-Response into this Object
     *
     * @param Object $response - DHL-Response
     */
    private function loadResponse_v2($response)
    {
        // Set Status-Values first
        if (
            !isset($response->CreationState->LabelData->Status->statusCode)
            && !isset($response->LabelData->Status->statusCode)
            && !isset($response->ExportDocData->Status->statusCode)
            && !isset($response->ValidationState->Status->statusCode)
        ) {
            // Set fault Status-Code
            $this->setStatusCode((int)$response->Status->statusCode);
            $this->setStatusText($response->Status->statusText);
            $this->setStatusMessage($response->Status->statusMessage);

            return;
        }

        if (isset($response->CreationState->LabelData->Status->statusCode)) {
            $this->setStatusCode((int)$response->CreationState->LabelData->Status->statusCode);
            $this->setStatusText($response->CreationState->LabelData->Status->statusText);
            $this->setStatusMessage($response->CreationState->LabelData->Status->statusMessage);
        } else if (isset($response->LabelData->Status->statusCode)) {
            $this->setStatusCode((int)$response->LabelData->Status->statusCode);
            $this->setStatusText($response->LabelData->Status->statusText);
            $this->setStatusMessage($response->LabelData->Status->statusMessage);
        } else if (isset($response->ExportDocData->Status->statusCode)) {
            // Export-Doc
            $this->setStatusCode((int)$response->ExportDocData->Status->statusCode);
            $this->setStatusText($response->ExportDocData->Status->statusText);
            $this->setStatusMessage($response->ExportDocData->Status->statusMessage);
        } else {
            // Validate Shipment
            $this->setStatusCode((int)$response->ValidationState->Status->statusCode);
            $this->setStatusText($response->Status->statusText);
            if (\is_array($response->Status->statusMessage)) {
                $this->setStatusMessage(implode(';', $response->Status->statusMessage));
            } else {
                $this->setStatusMessage($response->Status->statusMessage);
            }
        }

        // Change Status-Code if a weak-validation error occurs
        if ($this->getStatusCode() === 0 && $this->getStatusText() !== 'ok') {
            $this->setStatusCode(self::DHL_ERROR_WEAK_WARNING);
        }

        // Set Shipment-Number if exists
        if (isset($response->CreationState->LabelData->shipmentNumber)) {
            $this->setShipmentNumber((string)$response->CreationState->LabelData->shipmentNumber);
        } else if (isset($response->LabelData->shipmentNumber)) {
            $this->setShipmentNumber($response->LabelData->shipmentNumber);
        } else if (isset($response->ExportDocData->shipmentNumber)) {
            $this->setShipmentNumber($response->ExportDocData->shipmentNumber);
        }

        // Set Label if exists
        if ($this->getLabelType() === BusinessShipment::RESPONSE_TYPE_B64) {
            if (isset($response->CreationState->LabelData->labelData)) {
                $this->setLabel($response->CreationState->LabelData->labelData);
            } else if (isset($response->LabelData->labelData)) {
                $this->setLabel($response->LabelData->labelData);
            }
        } else {
            if (isset($response->CreationState->LabelData->labelUrl)) {
                $this->setLabel($response->CreationState->LabelData->labelUrl);
            } else if (isset($response->LabelData->labelUrl)) {
                $this->setLabel($response->LabelData->labelUrl);
            }
        }

        // Set Return Label if exists
        if ($this->getLabelType() === BusinessShipment::RESPONSE_TYPE_B64) {
            if (isset($response->CreationState->LabelData->returnLabelData)) {
                $this->setReturnLabel($response->CreationState->LabelData->returnLabelData);
            } else if (isset($response->LabelData->returnLabelData)) {
                $this->setReturnLabel($response->LabelData->returnLabelData);
            }
        } else {
            if (isset($response->CreationState->LabelData->returnLabelUrl)) {
                $this->setReturnLabel($response->CreationState->LabelData->returnLabelUrl);
            } else if (isset($response->LabelData->returnLabelUrl)) {
                $this->setReturnLabel($response->LabelData->returnLabelUrl);
            }
        }

        // Set Export Label if exists
        if ($this->getLabelType() === BusinessShipment::RESPONSE_TYPE_B64) {
            if (isset($response->CreationState->LabelData->exportLabelData)) {
                $this->setExportDoc($response->CreationState->LabelData->exportLabelData);
            } else if (isset($response->ExportDocData->exportDocData)) {
                $this->setExportDoc($response->ExportDocData->exportDocData);
            }
        } else {
            if (isset($response->CreationState->LabelData->exportLabelUrl)) {
                $this->setExportDoc($response->CreationState->LabelData->exportLabelUrl);
            } else if (isset($response->ExportDocData->exportDocURL)) {
                $this->setExportDoc($response->ExportDocData->exportDocURL);
            }
        }

        // Set all other System values
        if (isset($response->CreationState->sequenceNumber)) {
            $this->setSequenceNumber((string)$response->CreationState->sequenceNumber);
        } else if (isset($response->ValidationState->sequenceNumber)) {
            $this->setSequenceNumber((string)$response->ValidationState->sequenceNumber);
        }
    }

    /**
     * Returns null
     *
     * This function is not used here!
     *
     */
    final protected function getAPIUrl(): string
    {
        // unused here
        return '';
    }
}
