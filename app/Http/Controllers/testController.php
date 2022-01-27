<?php

namespace App\Http\Controllers;

use ApiProviderFactory;
use App\Facades\ApiProviderAdapterFactoryFacade;
use App\Services\ApiAdapters\AmazonApiAdapter;
use App\Services\ApiAdapters\IApiAdapter;
use App\Services\Apis\EbayApi;
use App\Services\Factories\ApiProviderAdapterFactory;
use App\Services\Factories\IApiAdapterFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class testController extends Controller
{
    public function index(IApiAdapterFactory $factoryMethod2)
    {
        #Just another method of creating the adapter using the Dependancy Injection
        $shopApiAdapter1 = ApiProviderFactory::make(ApiProviderAdapterFactory::PROVIDER_EBAY);

        #Creating using Facade
        $shopApiAdapter2 = $factoryMethod2->make(ApiProviderAdapterFactory::PROVIDER_EBAY);
        $sorting = IApiAdapter::SORT_DEFAULT;
        if(request('sorting') == 'by_price_asc')
            $sorting = IApiAdapter::SORT_PRICE_ASC;

       $items =  $shopApiAdapter2->getKeywordItems(request('keywords'),request('price_min'),request('price_max'),$sorting);

       dd($items);

    }
}
