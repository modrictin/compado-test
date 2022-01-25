<?php

namespace App\Services\Factories;

use App\Services\ApiAdapters\AmazonApiAdapter;
use App\Services\ApiAdapters\EbayApiAdapter;
use App\Services\ApiAdapters\IApiAdapter;
use Illuminate\Support\Arr;

class ApiProviderAdapterFactory implements IApiAdapterFactory
{
    const PROVIDER_EBAY = 'Ebay';
    const PROVIDER_AMAZON = 'Amazon';

    private $existing =  [];

    private $enabled = [self::PROVIDER_AMAZON,self::PROVIDER_EBAY];

    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }


    public  function make($name):IApiAdapter
    {
        if(!in_array($name,$this->enabled)){
            throw new \Exception("That Adapter Type is Not Enabled");
        }

        $existing = Arr::get($this->existing, $name);

        if ($existing) {
            return $existing;
        }


        $methodName = 'create' . ucfirst($name) . 'ApiAdapter';
        if (!method_exists($this, $methodName)) {
            throw new \Exception("Api Adapter Type Not Supported");
        }

        $adapter = $this->{$methodName}();
        $this->existing[$name] = $adapter;
        return $adapter;
    }

    private function createEbayApiAdapter(): EbayApiAdapter
    {

        $service = new EbayApiAdapter($this->app['config']);
        // Do the necessary configuration to use the Ebay service
        return $service;
    }
    private function createAmazonApiAdapter(): AmazonApiAdapter
    {
       return new AmazonApiAdapter();
    }


}
