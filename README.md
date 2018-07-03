# DHL PHP SDK

This *unofficial* library is wrapping some functions of the DHL SOAP API in order to easy create/delete shipments and labels.

Please note, that this is a fork of Petschko/DHL-PHP-SDK

## Installation

You can use [Composer](https://getcomposer.org/) to install the package to your project:

```
composer require daniellarusso/dhl-php-sdk
```

The classes are then added to the autoloader automatically.

## Requirements

- You need a DHL developer account and - as long as you want to use the API in production systems - a DHL Intraship Account.
- PHP-SOAP-Client installed + enabled on your Server

## Compatibility

This Project is written for the DHL-SOAP-API **Version 2 or higher**.

It barely supports Version 1, feel free to complete the missing functions for Version 1. They are named usually `{functionname}_v1`. They are also marked with "todo" if they are not implemented

I can't find a Documentation for Version 1 anymore, so its hard to implement them properly...

## Usage

1. You need to include the SDK by requiring the `\DanielLarusso\DHL\BusinessShipment.php`-File, it requires the rest for you.

2. You need to setup your DHL-Credentials:

**TEST**-Credentials:
```php

// You can initial the Credentials-Object with true to pre-set the Test-Account
$credentials = new \DanielLarusso\DHL\Credentials(/* Optional: Test-Modus */ true);

// Now you just need to set your DHL-Developer-Data to it
$credentials
    ->setApiUser('myuser')        // Set the USERNAME (not E-Mail!) of your DHL-Dev-Account
    ->setApiPassword('myPasswd'); // Set the Password of your DHL-Dev-Account
```

**LIVE**-Credentials

```php
// Just create the Credentials-Object
$credentials = new \DanielLarusso\DHL\Credentials();

// Setup these Infos: (ALL Infos are Case-Sensitive!)
$credentials
    ->setUser('Your-DHL-Account')               // DHL-Account (Same as if you Login with then to create Manual-Labels)
    ->setSignature('Your-DHL-Account-Password') // DHL-Account-Password
    ->setEpk('EPK-Account-Number')              // Number of your Account (Provide at least the first 10 digits)
    ->setApiUser('appId')                       // Your Applications-ID (You can find it in your DHL-Dev-Account)
    ->setApiPassword('appToken');               // Your Applications-Token (You can find it also where you found the App-Id) 
```

You've set all of the Required Information so far. Now you can Perform several Actions.

### Create a Shipment

_Please note, that you need the `\DanielLarusso\DHL\Credentials` Object with Valid Login-Information for that._

#### Classes used:

- `\DanielLarusso\DHL\Credentials` **(Req)** - Login Information
- `\DanielLarusso\DHL\ShipmentDetails` **(Req)** - Details of the Shipment
- `\DanielLarusso\DHL\Sender` **(Req)** - Sender Details
	- `\DanielLarusso\DHL\SendPerson` (Parent)
		- `\DanielLarusso\DHL\Address` (Parent)
- `\DanielLarusso\DHL\ReturnReceiver` (Optional) - Return Receiver Details
	- `\DanielLarusso\DHL\SendPerson` (Parent)
		- `\DanielLarusso\DHL\Address` (Parent)
- `\DanielLarusso\DHL\Service` (Optional) - Service Details (Many Configurations for the Shipment)
- `\DanielLarusso\DHL\IdentCheck` (Very Optional) - Ident-Check Details, only needed if turned on in Service
- `\DanielLarusso\DHL\BankData` (Optional) - Bank-Information
- `\DanielLarusso\DHL\BusinessShipment` **(Req)** - Manages all Actions + Information
	- `\DanielLarusso\DHL\Version` (Parent)
- `\DanielLarusso\DHL\Response` **(Req|Auto)** - Response Information
	- `\DanielLarusso\DHL\Version` (Parent)

One of them:
- `\DanielLarusso\DHL\Receiver` **(Req)** - Receiver Details
	- `\DanielLarusso\DHL\SendPerson` (Parent)
		- `\DanielLarusso\DHL\Address` (Parent)
- `\DanielLarusso\DHL\Filial` (Optional) - Receiver-Details (Post-Filial)
	- `\DanielLarusso\DHL\Receiver` **(Req|Parent)** - Receiver Details
		- `\DanielLarusso\DHL\SendPerson` (Parent)
			- `\DanielLarusso\DHL\Address` (Parent)
- `\DanielLarusso\DHL\PackStation` (Optional) - Receiver-Details (Pack-Station)
	- `\DanielLarusso\DHL\Receiver` **(Req|Parent)** - Receiver Details
		- `\DanielLarusso\DHL\SendPerson` (Parent)
			- `\DanielLarusso\DHL\Address` (Parent)

#### How to create

##### \DanielLarusso\DHL\ShipmentDetails Object

You need to setup the Shipment-Details for your Shipment (like Size/Weight etc). You can do that with the `\DanielLarusso\DHL\ShipmentDetails` Object.

```php
// Create the Object with the first 10 Digits of your Account-Number (EPK).
// You can use the \DanielLarusso\DHL\Credentials function "->getEko((int) amount)" to get just the first 10 digits if longer
$shipmentDetails = new \DanielLarusso\DHL\ShipmentDetails((string) $credentials->getEpk(10) . '0101'); // Ensure the 0101 at the end
```

You can setup details for that, if you need. If you don't set them, it use the default values _(This Part is Optional)_

```php
// Setup details

// -- Product
/* Setup the Product-Type that you need. Possible Values are:
* PRODUCT_TYPE_NATIONAL_PACKAGE = 'V01PAK';
* PRODUCT_TYPE_INTERNATIONAL_PACKAGE = 'V53WPAK';
* PRODUCT_TYPE_EUROPA_PACKAGE = 'V54EPAK';
* PRODUCT_TYPE_SAME_DAY_PACKAGE = 'V06PAK';
* PRODUCT_TYPE_SAME_DAY_MESSENGER = 'V06TG';
* PRODUCT_TYPE_WISH_TIME_MESSENGER = 'V06WZ';
* PRODUCT_TYPE_AUSTRIA_PACKAGE = 'V86PARCEL';
* PRODUCT_TYPE_AUSTRIA_INTERNATIONAL_PACKAGE = 'V82PARCEL';
* PRODUCT_TYPE_CONNECT_PACKAGE = 'V87PARCEL';
*/
$shipmentDetails->setProduct((string) \DanielLarusso\DHL\ShipmentDetails::{ProductType}); // Default: PRODUCT_TYPE_NATIONAL_PACKAGE

// Example:
$shipmentDetails->setProduct((string) \DanielLarusso\DHL\ShipmentDetails::PRODUCT_TYPE_INTERNATIONAL_PACKAGE);
// or (the same)
$shipmentDetails->setProduct((string) 'V53WPAK');

// -- Date
// You can set a Shipment-Date you have to provide it in this Format: YYYY-MM-DD
// -> The Date MUST be Today or in the future AND NOT a Sunday
$shipmentDetails->setShipmentDate((string) '2017-01-30'); // Default: Today or 1 day higher if Today is a Sunday
// You can also use a timestamp as value, just set the 2nd param to true (Default is false)
$shipmentDetails->setShipmentDate((int) time(), /* useTimeStamp = false */ true);

// -- Return Account-Number (EPK)
// Provide your Return-Account-Number here. If not needed don't set it!
// Its usually the same Account-Number like your DHL-Account, just set the end to 0701
$shipmentDetails->setReturnAccountNumber((string) $credentials->getEpk(10) . 0701); // Default: null -> Disabled

// -- References
$shipmentDetails->setCustomerReference((string) 'freetext 35 len'); // Default: null -> Disabled
// Only used if return receiver is used (ONLY if you want to print a return label)
$shipmentDetails->setReturnReference((string) 'freetext 35 len'); // Default: null -> Disabled

// Sizes/Weight
$shipmentDetails->setWeight((float) $weightInKG); // Default: 5.0 (KG)
$shipmentDetails->setLength((int) $lengthInCM); // Default: null -> Unset
$shipmentDetails->setWidth((int) $widthInCM); // Default: null -> Unset
$shipmentDetails->setHeight((int) $heightInCM); // Default: null -> Unset

// -- Package-Type (ONLY NEEDED IN VERSION 1)
/* Sets the Type of the Package. Possible Values:
* PALETTE = 'PL';
* PACKAGE = 'PK';
*/
$shipmentDetails->setPackageType((string) \DanielLarusso\DHL\ShipmentDetails::{type}); // Default: PACKAGE
```

##### \DanielLarusso\DHL\Sender, \DanielLarusso\DHL\Receiver + \DanielLarusso\DHL\ReturnReceiver Object(s)

Now you have to create a Sender and a Receiver. They are similar to set, just the XML creation is different so you have to use different Objects for that.

If you want to lookup all values, you can search trough the `\DanielLarusso\DHL\SendPerson` + `\DanielLarusso\DHL\Address` Classes.

Lets start with the Sender, in the most cases you =). Create a `\DanielLarusso\DHL\Sender` Object:

```php
$sender = new \DanielLarusso\DHL\Sender();
```

Setup all **Required** Information

```php
$sender->setName((string) 'Organisation DanielLarusso'); // Can be a Person-Name or Company Name

// You can add the whole address with that setter if you want
$sender->setFullStreet((string) 'Oberer Landweg 12a');

// If you want to set the elements on your own use the setter for them
$sender->setStreetName((string) 'Oberer Landweg');
$sender->setStreetNumber((string) '12a');

$sender->setZip((string) '21035');
$sender->setCity((string) 'Hamburg');
$sender->setCountry((string) 'Germany');
$sender->setCountryISOCode((string) 'DE'); // 2 Chars ONLY
```

You can also add more Information, but they are **Optional**:

```php
// You can specify the delivery location
$sender->setAddressAddition((string) 'Etage 1'); // Default: null -> Disabled
$sender->setDispatchingInfo((string) 'Additional dispatching info'); // Default: null -> Disabled
$sender->setState((string) 'State'); // Default: null -> Disabled

// You can add more Personal-Info
$sender->setName2((string) 'Name Line 2'); // Default: null -> Disabled
$sender->setName3((string) 'Name Line 3'); // Default: null -> Disabled
$sender->setPhone((string) '04073409677'); // Default: null -> Disabled
$sender->setEmail((string) 'peter-91@hotmail.de'); // Default: null -> Disabled

// Mostly used in bigger Companies
$sender->setContactPerson((string) 'Peter Dragicevic'); // Default: null -> Disabled
```

This was the sender Object, you can set all the same Information with the `\DanielLarusso\DHL\Receiver` + `\DanielLarusso\DHL\ReturnReceiver` Class.

**Note**: You can also use `\DanielLarusso\DHL\PackStation` or `\DanielLarusso\DHL\Filial` instead of `\DanielLarusso\DHL\Receiver`.
Please note, that they need some extra information.

You don't need to create the `\DanielLarusso\DHL\ReturnReceiver` Object if you don't want a return Label.

##### \DanielLarusso\DHL\Service Object

You can also setup more details for your Shipment by using the `\DanielLarusso\DHL\Service` Object. It's an optional Object but may you should look, what you can set to this Object.

I'll not explain the Service-Object because there are too many settings. Please look into the Service-PHP-File by yourself. The fields are well documented.

##### \DanielLarusso\DHL\BankData Object

You can also use the `\DanielLarusso\DHL\BankData` Object. Bank data can be provided for different purposes. E.g. if COD is booked as service, bank data must be provided by DHL customer (mandatory server logic). The collected money will be transferred to specified bank account.

You can look to the PHP-File of the `\DanielLarusso\DHL\BankData`-Object, and checkout what you can set there. I will not explain it here.

##### \DanielLarusso\DHL\BusinessShipment Object

Finally you can add all together. You have to create the `\DanielLarusso\DHL\BusinessShipment` Object

```php
/* Creates the Object:
* - 1st param is the \DanielLarusso\DHL\Credentials Object
* - 2nd param (Optional - Default: false) is a bool value if the testmodus is used. (true uses testmodus, false live)
* - 3rd param (Optional - Default: null -> newest) is a float value, that assigns the Version to use
*/
$dhl = new \DanielLarusso\DHL\BusinessShipment($credentials);
```

If you want to use a specific WSDL-File (or remote), you can set it: _(Else you don't need this part)_

```php
$dhl->setCustomAPIURL('http://myserver.com/myAPIFile.wsdl');
```

Here you can add the previous created classes:

````php
// Add all Required (For a CREATE-Shipment-Request) Classes
$dhl->setShipmentDetails($shipmentDetails); // \DanielLarusso\DHL\ShipmentDetails Object
$dhl->setSender($sender); // \DanielLarusso\DHL\Sender Object
$dhl->setReceiver($receiver); // \DanielLarusso\DHL\Receiver Object

// Add Optional-Classes (Drop the line if you don't need/set it)
$dhl->setReturnReceiver($returnReceiver); // \DanielLarusso\DHL\ReturnReceiver Object - Default: null - Disabled
$dhl->setService($service); // \DanielLarusso\DHL\Service Object - Default: null -> All is default
$dhl->setBank($bankObj); // \DanielLarusso\DHL\BankData Object - Default: null -> Disabled
````

Now you can set how the Label should get returned and some other stuff:

```php
// You can enable Logging if you want
$dhl->setLog((bool) true);

// Set a Sequence-Number if you need a referrence when you get the response
$dhl->setSequenceNumber((string) '1'); // Default: '1'

// You can let DHL send a Mail to the Receiver, if you want that set the Mail
$dhl->setReceiverEmail((string) 'receiver@mail.com'); // Default: null -> Disabled

/* You can get the Label as URL or as Base64-Data-String - set it how you want to have it
* Possible Values:
* RESPONSE_TYPE_URL = 'URL';
* RESPONSE_TYPE_B64 = 'B64';
*/
$dhl->setLabelResponseType((string) \DanielLarusso\DHL\BusinessShipment::RESPONSE_TYPE_URL); // Default: null -> Uses DHL-Default
```

#### Create the Request

All set? Fine, now you can finally made the Create-Shipment-Order-Request. Save the Response to a var
````php
// Returns false if the Request failed or \DanielLarusso\DHL\Response on success
$response = $dhl->createShipment();
````

#### Handling the response
First you have to check if the Value is not false
```php
if($response === false) {
    // Do your Error-Handling here
    
    // Just to show all Errors
    var_dump($dhl->getErrors()); // Get the Error-Array
} else {
    // Handle the Response here
    
    // Just to show the whole Response-Object
    var_dump($response);
}
```

You can get several Information from the `\DanielLarusso\DHL\Response` Object. Please have a look down where I describe the `\DanielLarusso\DHL\Response` Class.


### Delete a Shipment

_Please note, that you need the `\DanielLarusso\DHL\Credentials` Object with Valid Login-Information for that._

You also need the Shipment-Number, from the Shipment, that you want to cancel/delete.

#### Classes used

- `\DanielLarusso\DHL\Credentials` **(Req)** - Login Information
- `\DanielLarusso\DHL\BusinessShipment` **(Req)** - Manages all Actions + Information
	- `\DanielLarusso\DHL\Version` (Parent)
- `\DanielLarusso\DHL\Response` **(Req|Auto)** - Response Information
	- `\DanielLarusso\DHL\Version` (Parent)

#### How to create

Deleting a Shipment is not very hard it just work like this:
```php
// Create a \DanielLarusso\DHL\BusinessShipment Object with your credentials
$dhl = new \DanielLarusso\DHL\BusinessShipment($credentials);

// Send a deletetion Request
$response = $dhl->deleteShipment((string) 'shipment_number');
```

Same like when creating a Shipment-Order, the Response is `false` if the Request failed.
For more Information about the Response, look down where I describe the `\DanielLarusso\DHL\Response` Class.

### Re-Get a Label

_Please note, that you need the `\DanielLarusso\DHL\Credentials` Object with Valid Login-Information for that._

You also need the Shipment-Number, from the Shipment, where you want to Re-Get a Label.

#### Classes used

- `\DanielLarusso\DHL\Credentials` **(Req)** - Login Information
- `\DanielLarusso\DHL\BusinessShipment` **(Req)** - Manages all Actions + Information
	- `\DanielLarusso\DHL\Version` (Parent)
- `\DanielLarusso\DHL\Response` **(Req|Auto)** - Response Information
	- `\DanielLarusso\DHL\Version` (Parent)

#### How to create

Same like deleting, re-get a Label is not this hard. You can simply re-get a label:

```php
// As usual create a \DanielLarusso\DHL\BusinessShipment Object with your Credentials
$dhl = new \DanielLarusso\DHL\BusinessShipment($credentials);

// This is the only setting you can do here: (Change Label-Response Type) - Optional
$dhl->setLabelResponseType((string) \DanielLarusso\DHL\BusinessShipment::RESPONSE_TYPE_B64); // Default: null -> DHL-Default

// And here comes the Request
$response = $dhl->getShipmentLabel((string) 'shipmentNumber');
```

If the request failed, you get `false` as usual else a `\DanielLarusso\DHL\Response` Object.

### DoManifest

_Please note, that you need the `\DanielLarusso\DHL\Credentials` Object with Valid Login-Information for that._

You also need the Shipment-Number for the Manifest _(If you need it, you will know how to use this)_.

I personally don't know for what is this for, but it works!

#### Classes used

- `\DanielLarusso\DHL\Credentials` **(Req)** - Login Information
- `\DanielLarusso\DHL\BusinessShipment` **(Req)** - Manages all Actions + Information
	- `\DanielLarusso\DHL\Version` (Parent)
- `\DanielLarusso\DHL\Response` **(Req|Auto)** - Response Information
	- `\DanielLarusso\DHL\Version` (Parent)

#### How to create

It works like deleting a Shipment:
```php
// Create a \DanielLarusso\DHL\BusinessShipment Object with your credentials
$dhl = new \DanielLarusso\DHL\BusinessShipment($credentials);

// Do the Manifest-Request
$dhl->doManifest((string) 'shipment_number');
```

If the request failed, you get `false` else a `\DanielLarusso\DHL\Response` Object.

### \DanielLarusso\DHL\Response Object

If you get a Response that is not `false`, you have to mess with the `\DanielLarusso\DHL\Response` Object.

This Object helps you, to get easier to your Goal. You can easily get the Values you need by using the getters. _(IDEs will detect them automatic)_

I will explain which values you can get from the Response-Object

```php
(string) $response->getShipmentNumber(); // Returns the Shipment-Number of the Request or null
(string) $response->getLabel(); // Returns the Label URL or Base64-Label-String or null
(string) $response->getReturnLabel(); // Returns the ReturnLabel (URL/B64) or null
(string) $response->getSequenceNumber(); // Returns your provided sequence number or null
(int) $response->getStatusCode(); // Returns the Status-Code (Difference to DHL - Weak-Validation is 1 not 0)
(string) $response->getStatusText(); // Returns the Status-Text or null
(string) $response->getStatusMessage(); // Returns the Status-Message (More details) or null
```

If a value is not set you get usually `null` as result. Not every Action fills out all of these values!

You can also take a look at the Class Constance's, they are helping you to identify the Status-Codes:

```php
const \DanielLarusso\DHL\ERROR_NOT_SET = -1;
const \DanielLarusso\DHL\ERROR_NO_ERROR = 0;
const \DanielLarusso\DHL\ERROR_WEAK_WARNING = 1;
const \DanielLarusso\DHL\ERROR_SERVICE_TMP_NOT_AVAILABLE = 500;
const \DanielLarusso\DHL\ERROR_GENERAL = 1000;
const \DanielLarusso\DHL\ERROR_AUTH_FAILED = 1001;
const \DanielLarusso\DHL\ERROR_HARD_VAL_ERROR = 1101;
const \DanielLarusso\DHL\ERROR_UNKNOWN_SHIPMENT_NUMBER = 2000;
```

That's all so far

# Contact

- You can E-Mail me if you have Questions or whatever (No Bug-Reporting please!): daniel.pogodda@googlemail.com
- You can Report Bugs here in the "[Issue](https://github.com/DanielLarusso/dhl-php-sdk/issues)"-Section of the Project.
	- Of course you can also ask any stuff there, feel free for that!
	- If you want to use German, you can do it. Please keep in mind that not everybody can speak German, so it's better to use english =)