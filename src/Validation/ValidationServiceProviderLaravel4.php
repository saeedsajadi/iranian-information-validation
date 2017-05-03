<?php

namespace SmartTwists\IranianInformationValidation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;

class ValidationServiceProviderLaravel4 extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('smart-twists/iranian-information-validator');

        // registering intervention validator extension
        $this->app['validator']->resolver(function($translator, $data, $rules, $messages, $customAttributes) {

            // set the package validation error messages
            $messages['iban'] = $translator->get('validation::validation.iban');
            $messages['creditcard'] = $translator->get('validation::validation.hexcolor');
            $messages['isbn'] = $translator->get('validation::validation.isbn');
            $messages['isodate'] = $translator->get('validation::validation.isodate');
            $messages['zipcode'] = $translator->get('validation::validation.zipcode');
            $messages['nationalcode'] = $translator->get('validation::validation.bic');

            return new ValidatorExtension($translator, $data, $rules, $messages, $customAttributes);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        # code...
    }
}
