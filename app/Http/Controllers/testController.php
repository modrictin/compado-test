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

        //$apiAdapter = ApiProviderFactory::make(ApiProviderAdapterFactory::PROVIDER_EBAY);
        $apiAdapter = $factoryMethod2->make(ApiProviderAdapterFactory::PROVIDER_EBAY);

        $apiAdapter->getKeywordItems('harry');

        return view('welcome');
    }
}
