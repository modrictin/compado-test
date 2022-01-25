<?php

namespace App\Services\Apis;

use Illuminate\Support\Facades\Http;

class EbayApi
{

    private $version = '1.0.0';
    private $appId;
    private $baseUrl;

    public function __construct($apiKey,$baseUrl)
    {
        $this->appId = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    public function getDataByKeyword($keyword)
    {
        $url = $this->baseUrl
            .'/services/search/FindingService/v1?'
            . 'OPERATION-NAME=findItemsByKeywords&'
            . 'SERVICE-VERSION=' . $this->version . '&'
            . 'SECURITY-APPNAME=' . $this->appId . '&'
            . 'GLOBAL-ID=EBAY-US&'
            . 'keywords='.urlencode($keyword);

        return Http::get($url);
    }

}
