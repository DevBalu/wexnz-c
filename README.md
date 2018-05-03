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
