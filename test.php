<?php

require_once __DIR__ . '/vendor/autoload.php';

// Require the Main-Class (other classes will included by this file)
use DanielLarusso\DHL;

/** @var bool $testMode */
$testMode = true;

/** @var string $version */
$version = '2.2';

/** @var string $reference */
$reference = '1'; // You can use anything here (max 35 chars)

/**
 * Set this to true then you can skip set the "User", "Signature" and "EPK" (Just for test-Modus) else false or empty
 *
 * @var DHL\Credentials $credentials
 */
$credentials = new DHL\Credentials($testMode);

if (! $testMode) {
    $credentials
        ->setUser('Your-DHL-Account')               // Don't needed if initialed with true - Test-Mode
        ->setSignature('Your-DHL-Account-Password') // Don't needed if initialed with true - Test-Mode
        ->setEpk('EPK-Account-Number');             // Don't needed if initialed with true - Test-Mode
}

/** Set your API-Login */
$credentials
    ->setApiUser('')      // Test-Mode: Your DHL-Dev-Account (Developer-ID NOT E-Mail!!) | Production: Your Applications-ID
    ->setApiPassword(''); // Test-Mode: Your DHL-Dev-Account Password | Production: Your Applications-Token

/** Set Shipment Details */
$shipmentDetails = new DHL\ShipmentDetails($credentials->getEpk(10) . '0101'); // Create a Shipment-Details with the first 10 digits of your EPK-Number and 0101 (?)
$shipmentDetails->setShipmentDate('2017-01-30');                               // Optional: Need to be in the future and NOT on a sunday | null or drop it, to use today
//$shipmentDetails->setReturnAccountNumber($credentials->getEpk(10) . '0701'); // Needed if you want to print a return label
//$shipmentDetails->setReturnReference($reference);                            // Only needed if you want to print a return label

/**
 * Set Sender
 *
 * @var DHL\Sender $sender
 */
$sender = new DHL\Sender();
$sender
    ->setName('Peter Muster')
    ->setStreetName('Test Sgtraße')
    ->setStreetNumber('12a')
    ->setZip('21037')
    ->setCity('Hamburg')
    ->setCountry('Germany')
    ->setCountryISOCode('DE');

/**
 * Set Receiver
 *
 * @var DHL\Receiver $receiver
 */
$receiver = new DHL\Receiver();
$receiver
    ->setName('Test Empfänger')
    ->setStreetName('Test Straße')
    ->setStreetNumber('23b')
    ->setZip('21037')
    ->setCity('Hamburg')
    ->setCountry('Germany')
    ->setCountryISOCode('DE');

/**
 * Needed if you want to print an return label.
 * If want to use it, please set Address etc. of the return receiver, too!
 *
 * @var DHL\ReturnReceiver $returnReceiver
 */
$returnReceiver = new DHL\ReturnReceiver();

/**
 * Set Service stuff (look at the class member - many settings here - just set them to your needs)
 * Set stuff you want in that class - This is very optional
 *
 * @var DHL\Service $service
 */
$service = new DHL\Service();

/**
 * Required just Credentials also accept Test-Mode and Version
 *
 * @var DHL\BusinessShipment $dhl
 */
$dhl = new DHL\BusinessShipment(
    $credentials,
    $testMode, // Optional
    $version   // Optional
);
// You can add your own API-File (if you want to use a remote one or your own) - else you don't need this
//$dhl->setCustomAPIURL('http://myserver.com/myAPIFile.wsdl');

// Don't forget to assign the created objects to the DHL_BusinessShipment!
$dhl
    ->setSequenceNumber($reference) // Just needed for ajax or such stuff can dynamic an other value
    ->setSender($sender)
    ->setReceiver($receiver) // You can set these Object-Types here: DHL_Filial, DHL_Receiver & DHL_PackStation
    //->setReturnReceiver($returnReceiver); // Needed if you want print a return label
    ->setService($service)
    ->setShipmentDetails($shipmentDetails)
    //->setReceiverEmail('receiver@mail.com'); // Needed if you want inform the receiver via mail
    ->setLabelResponseType(DHL\BusinessShipment::RESPONSE_TYPE_URL);

/** @var DHL\Response|bool $response */
$response = $dhl->createShipment(); // Creates the request

// For deletion you just need the shipment number and credentials
// $dhlDel = new BusinessShipment($credentials, $testModus, $version);
// $response_del = $dhlDel->deleteShipment('shipment_number'); // Deletes a Shipment

// To re-get the Label you can use the getShipmentLabel method - the shipment must be created with createShipment before
//$dhlReGetLabel = new BusinessShipment($credentials, $testModus, $version);
//$dhlReGetLabel->setLabelResponseType(DHL_BusinessShipment::RESPONSE_TYPE_B64); // Optional: Set the Label-Response-Type
//$reGetLabelResponse = $dhlReGetLabel->getShipmentLabel('shipmentNumber'); // ReGet Label

// To do a Manifest-Request you can use the doManifest method - you have to provide a Shipment-Number
//$manifestDHL = new BusinessShipment($credentials, $testModus, $version);
//$manifestResponse = $manifestDHL->doManifest('shipmentNumber');

// Get the result (just use var_dump to show all results)
if ($response !== false) {
    var_dump($response);
} else {
    var_dump($dhl->getErrors());
}

// You can show yourself also the XML-Request as string
var_dump($dhl->getLastXML());
