<?php

namespace App\Services\ApiAdapters;

class AmazonApiAdapter implements IApiAdapter
{
    public function __construct($config)
    {
    }
    public function getKeywordItems($keyword,$priceMin=false,$priceMax=false,$sorting=IApiAdapter::SORT_DEFAULT): array
    {

    }
}
