# Iranian Information Validation Class

Extension for the Laravel validation class

## Installation

You can install this package quick and easy with Composer.

Require the package via Composer:

    $ composer require smart-twists/iranian-information-validator

The Validation class is built to work with the Laravel Framework. The integration is done in seconds.

Open your Laravel config file `config/app.php` and add service provider in the `$providers` array:
    
    'providers' => array(

        ...

        SmartTwists\IranianInformationValidation\ValidationServiceProvider::class,

    ),
  

## Usage with Laravel

The installed package provides the following additional `validation rules` including their error messages.

### iban

Checks for a valid International Bank Account Number (IBAN).

### creditcard

The given field must be a valid creditcard number.

### isbn

The field under validation must be a valid International Standard Book Number (ISBN).

### isodate

The field under validation must be a valid date in ISO 8601 format.

### nationalcode

The field under validation must be a valid national code.

### zipcode

The field under validation must be a valid zip code.

## Changing the error messages:

Add the corresponding key to `/resources/lang/<language>/validation.php` like this:

```
// example
'iban' => 'Please enter IBAN number!',
```

Or add your custom messages directly to the validator like [described in the docs](http://laravel.com/docs/5.1/validation#custom-error-messages).

## Usage outside of Laravel

* Validator::isIban - Checks if given value is valid International Bank Account Number (IBAN).
* Validator::isCreditcard - Checks if value is valid creditcard number.
* Validator::isIsbn - Checks if given value is valid International Standard Book Number (ISBN).
* Validator::isIsodate - Checks if given value is date in ISO 8601 format.
* Validator::isNationalcode - checks if given value is valid national code.
* Validator::isZipcode - checks if given value is valid zip cide.
## License

Intervention Validation Class is licensed under the [MIT License](http://opensource.org/licenses/MIT).