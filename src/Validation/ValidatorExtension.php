<?php

namespace SmartTwists\IranianInformationValidation;

class ValidatorExtension extends \Illuminate\Validation\Validator
{
    /**
     * Creates new instance of ValidatorExtension
     *
     */
    public function __construct($translator, $data, $rules, $messages, $customAttributes)
    {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
    }

    /**
     * Provides 'iban' validation rule for Laravel
     *
     * @return bool
     */
    public function validateIban($attribute, $value, $parameters)
    {
        return Validator::isIban($value);
    }

    /**
     * Provides 'creditcard' validation rule for Laravel
     *
     * @return bool
     */
    public function validateCreditcard($attribute, $value, $parameters)
    {
        return Validator::isCreditcard($value);
    }

    /**
     * Provides 'isbn' validation rule for Laravel
     *
     * @return bool
     */
    public function validateIsbn($attribute, $value, $parameters)
    {
        return Validator::isIsbn($value);
    }

    /**
     * Provides 'isoddate' validation rule for Laravel
     *
     * @return bool
     */
    public function validateIsodate($attribute, $value, $parameters)
    {
        return Validator::isIsodate($value);
    }

    /**
     * Provides 'zipcode' validation rule for Laravel
     *
     * @return bool
     */
    public function validateZipcode($attribute, $value, $parameters)
    {
        return Validator::isZipcode($value);
    }

    /**
     * Provides 'nationalcode' validation rule for Laravel
     *
     * @return bool
     */
    public function validateNationalCode($attribute, $value, $parameters)
    {
        return Validator::isNationalcode($value);
    }

    /**
     * Provides 'ir_mobile' validation rule for Laravel
     *
     * @return bool
     */
    public function validateIRMobile($attribute, $value, $parameters)
    {
        return Validator::isIrMobile($value);
    }

    /**
     * Provides 'ir_phone' validation rule for Laravel
     *
     * @return bool
     */
    public function validateIRPhone($attribute, $value, $parameters)
    {
        return Validator::isIrPhone($value);
    }
}
