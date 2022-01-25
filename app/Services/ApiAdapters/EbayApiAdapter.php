<?php

namespace App\Services\ApiAdapters;

use App\Services\Apis\EbayApi;
use Illuminate\Support\Facades\Http;

class EbayApiAdapter implements IApiAdapter
{
    private $ebayApi;

    public function __construct($appConfig)
    {
        $this->ebayApi = new EbayApi($appConfig['api_sources.ebay.APPKEY'],$appConfig['api_sources.ebay.endpoint']);
    }

    public function getKeywordItems($keyword): array
    {
        $keyword='harry';
        dd(simplexml_load_string($this->ebayApi->getDataByKeyword($keyword)->body()));

        return [];
    }
}
