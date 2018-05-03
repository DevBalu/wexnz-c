# Wex.nz REST API PHP Client


[Wex.nz](https://wex.nz) provides REST APIs that you can use
 to interact with platform programmatically. Including also creating and redeeming coupons.

This API client will help you interact with Wex.nz by REST API. 
 

## License

MIT License

## Btc-e REST API Reference

Public API - https://wex.nz/api/3/docs

Trade API - https://wex.nz/tapi/docs

Push API - https://wex.nz/pushAPI/docs


## Install
    
    composer require azkdev/wexnz-c


## Usage

Basic usage:
```
<?php

require __DIR__ . '/../vendor/autoload.php';

use azkdev\WexnzApi\WexnzApi;

$api = new WexnzApi(
	'https://wex.nz/tapi', // maybe other wex.
	'*******************', // public key.
	'*******************'  // secret key.
);


print_r($api->trade()->userInfo()); // prints all user wallet info.
```

For using createCoupon or redeemCoupon methods, you need 'trade' privilege for your api key.
[More info about 'trade' privilege you can find here.](https://wex.nz/tapi/docs)
```
$api->trade()->createCoupon('USD', 200, 'userName'); // Creating coupon with 'currency', 'amount' and 'user name'. User name can be empty string ''.

$api->trade()->createCoupon('**********'); // Redeem coupon. Argument is coupon code. Returns full info about transaction.
```

### Mapping


### Error handling


## Running the tests
To run the tests, you'll need to install [phpunit](https://phpunit.de/). 
Easiest way to do this is through composer.

    composer install

Tests required running php built in server on 8000 port.

    php -S localhost:8000

### Running Unit tests

    php vendor/bin/phpunit -c phpunit.xml.dist
