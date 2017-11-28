<?php

/*
 * Turiknox_AddressAutocomplete

 * @category   Turiknox
 * @package    Turiknox_AddressAutocomplete
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/Turiknox/magento-address-autocomplete/blob/master/LICENSE.md
 * @version    1.0.0
 */

class Turiknox_AddressAutocomplete_Block_Js extends Mage_Core_Block_Template
{
    /**
     * Get the Google Places API Key
     * @return mixed
     */
    public function getApiKey()
    {
        return Mage::getStoreConfig('autocomplete/general/key');
    }

    /**
     * Check if the Autocomplete feature has been enabled in admin
     * @return bool
     */
    public function isEnabled()
    {
        return $this->helper('turiknox_addressautocomplete')->isModuleEnabledInAdmin()
            && !empty($this->getApiKey());
    }

    /**
     * Check if autocomplete is enabled for shipping address
     * @return mixed
     */
    public function isShippingAddressEnabled()
    {
        return Mage::getStoreConfigFlag('autocomplete/usage/shipping');
    }


    /**
     * Get billing address autocomplete field
     * @return mixed
     */
    public function getBillingAddressField()
    {
        return Mage::getStoreConfig('autocomplete/usage/billing_field');
    }


    /**
     * @return mixed
     */
    public function getShippingAddressField()
    {
        return Mage::getStoreConfig('autocomplete/usage/shipping_field');
    }

    /**
     * @return mixed
     */
    public function getAutocompletePlaceholderText()
    {
        return Mage::getStoreConfig('autocomplete/usage/placeholder');
    }

    /**
     * @return array
     */
    public function getCountriesAsAdmin2()
    {
        return (array)explode(',', Mage::getStoreConfig('autocomplete/usage/countries_as_admin2'));
    }

    /**
     * @return string
     */
    public function getCountriesAsAdmin2Json()
    {
        return Mage::helper('core')->jsonEncode($this->getCountriesAsAdmin2());
    }

    /**
     * @return string
     */
    public function getAllowedCountriesJson()
    {
        if ( Mage::getStoreConfigFlag('autocomplete/usage/disable_allowed_countries_restriction') ) {
            return '[]';
        }

        $countryList = Mage::getResourceModel('directory/country_collection')
            ->loadByStore();

        $countries = [];
        foreach ($countryList as $country) {
            array_push($countries, $country->getIso2Code());
        }

        return Mage::helper('core')->jsonEncode($countries);
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if ( !$this->isEnabled() ) {
            return '';
        }

        return parent::_toHtml();
    }
}