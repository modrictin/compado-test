<?php

namespace App\Services\Apis;

use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class EbayApi
{

    private $version = '1.0.0';
    private $appId;
    private $baseUrl;

    const ACK_SUCCESS = 'Success';
    const ACK_FAILURE = 'Failure';
    const ACK_PARTIAL_FAILURE = 'PartialFailure';
    const ACK_WARNING = 'Warning';


    public function __construct($apiKey, $baseUrl)
    {
        $this->appId = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    public function getDataByKeyword($keyword, $priceMin, $priceMax, $sorting): string
    {


        #Construct the URL and Encode the keywords
        $url = $this->baseUrl
            . '/services/search/FindingService/v1?'
            . 'OPERATION-NAME=findItemsByKeywords&'
            . 'SERVICE-VERSION=' . $this->version . '&'
            . 'RESPONSE-DATA-FORMAT=XML&'
            . 'REST-PAYLOAD&'
            . 'SECURITY-APPNAME=' . $this->appId . '&'
            . 'outputSelector(0)=PictureURLSuperSize&'
            . 'outputSelector(1)=GalleryInfo&'
            . 'keywords=' . rawurlencode($keyword);
        //sort by price
        if(!empty($sorting))
            $url .= '&sortOrder=' . $sorting;

        if(!empty($priceMax))
            $priceMax = number_format((float)$priceMax,2,'.');
        if(!empty($priceMin))
            $priceMin = number_format((float)$priceMin,2,'.');

        $itemFilterIndex = 0;
        if (!empty($priceMin)) {
            $url .= "&itemFilter($itemFilterIndex).name=MinPrice&itemFilter($itemFilterIndex).value=$priceMin" ;
            $itemFilterIndex++;
        }

        if(!empty($priceMax) ){
            $url .= "&itemFilter($itemFilterIndex).name=MaxPrice&itemFilter($itemFilterIndex).value=$priceMax" ;
        }
        #Use the Facade for getting the data
        return Http::get($url)->body();
    }

}
