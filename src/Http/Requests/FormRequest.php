<?php

namespace Elnooronline\LaravelConcerns\Http\Requests;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Elnooronline\LaravelLocales\Facades\Locales;
use Illuminate\Foundation\Http\FormRequest as BaseRequest;

class FormRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get a proper rules based on the request type.
     *
     * @return array
     */
    public function getAproperRules()
    {
        if ($this->isUpdateRequest()) {
            return $this->updateRules();
        } elseif ($this->isCreateRequest()) {
            return $this->createRules();
        }

        return [];
    }

    /**
     * Parse localized/multilingual rules.
     *
     * @return array
     */
    public function rules()
    {
        if (method_exists($this, 'localedRules')) {
            return $this->parseLocaled($this->localedRules());
        }

        return [];
    }

    /**
     * Return the rules of update request.
     *
     * @return array
     */
    public function updateRules()
    {
        return [];
    }

    /**
     * Return the rules of create request.
     *
     * @return array
     */
    public function createRules()
    {
        return [];
    }

    /**
     * Determine if the current request is put or patch.
     *
     * @return bool
     */
    public function isUpdateRequest()
    {
        return $this->isMethod('put') || $this->isMethod('patch');
    }

    /**
     * Determine if the current request is post.
     *
     * @return bool
     */
    public function isCreateRequest()
    {
        return $this->isMethod('post');
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        if (is_array($attributes = trans($this->getResourceName().'.attributes'))) {
            return Arr::dot($attributes + $this->localedAttributes($this->getLocaledAttributeFromRules()));
        }

        return [];
    }

    /**
     * Get the model resource name by route.
     *
     * @return string|null
     */
    public function getResourceName()
    {
        if (property_exists($this, 'resourceName')) {
            return $this->resourceName;
        }

        return Str::plural(
            Str::snake(
                Str::replaceLast(
                    'Request', '', class_basename($this)
                )
            )
        );
    }

    /**
     * Parse localed rules.
     *
     * @param  array  $localedRules
     * @return array
     */
    public function parseLocaled($localedRules)
    {
        $supportedLanguages = Locales::get();
        $newRules = [];
        $defaultNotation = ':{default}';
        $langNotation = ':{lang}';

        foreach ($localedRules as $key => $rules) {

            // Detect the key:{default} format.
            // Represent the validation for the default language.
            if (Str::endsWith($key, $defaultNotation)) {
                $newRules[Str::replaceLast($defaultNotation, '', $key).':'.Locales::getCode()] = $rules;
            }

            // Detect the key:{lang} format.
            // Represent the validation for supported language format.
            elseif (Str::endsWith($key, $langNotation)) {
                // Loop over the supported languages.
                foreach ($supportedLanguages as $language) {
                    // Replace the lang in :{lang} with the supported language code..
                    $localedKey = Str::replaceLast($langNotation, ':'.$language->code, $key);
                    // If there is :{default} notation defined avoid overriding it.
                    if (!isset($newRules[$localedKey])) {
                        $newRules[$localedKey] = $rules;
                    }
                }
            } // If there is no notations return the key and the rules as it.
            else {
                $newRules[$key] = $rules;
            }
        }

        return $newRules;
    }

    /**
     * Translate localed attributes.
     *
     * @param  array  $attributes
     * @return array
     */
    public function localedAttributes($attributes = [])
    {
        $resource = $this->getResourceName();
        $supportedLanguages = Locales::get();
        $translatedAttributes = trans($resource.'.attributes');
        foreach ($attributes as $attribute) {
            foreach ($supportedLanguages as $language) {
                $translatedAttributes[$attribute.':'.$language->code] =
                    trans($resource.'.attributes.'.$attribute).' ( '.$language->name.' )';
            }
        }

        return $translatedAttributes;
    }

    /**
     * Get the localed attribute names by the rules.
     *
     * @return array
     */
    public function getLocaledAttributeFromRules()
    {
        $localedAttributes = [];
        foreach ($this->rules() as $attribute => $rule) {
            if (Str::contains($attribute, ':')) {
                $localedAttributes[] = explode(':', $attribute)[0];
            }
        }

        return array_unique($localedAttributes);
    }
}