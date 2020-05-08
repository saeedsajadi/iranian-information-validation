<?php

namespace SmartTwists\IranianInformationValidation;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // load translation files
        $this->loadTranslationsFrom(
            __DIR__ . '/../lang',
            'validation'
        );

        // registering intervention validator extension
        $this->app['validator']->resolver(function($translator, $data, $rules, $messages, $customAttributes) {

            // set the validation error messages
            foreach (get_class_methods('SmartTwists\IranianInformationValidation\Validator') as $method) {
                $key = $this->getTranslationKeyFromMethodName($method);
                $messages[$key] = $this->getErrorMessage($translator, $messages, $key);
            }

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

    /**
     * Return the matching error message for the key
     *
     * @param  string $key
     * @return string
     */
    private function getErrorMessage($translator, $messages, $key)
    {
        // return error messages passed directly to the validator
        if (isset($messages[$key])) {
            return $messages[$key];
        }

        // return error message from validation translation file
        if ($translator->has("validation.{$key}")) {
            return $translator->get("validation.{$key}");
        }

        // return packages default message
        return $translator->get("validation::validation.{$key}");
    }

    /**
     * Return translation key for correspondent method name
     *
     * @param  string $name
     * @return string
     */
    private function getTranslationKeyFromMethodName($name)
    {
        return Str::snake(substr($name, 2));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('validator');
    }
}
