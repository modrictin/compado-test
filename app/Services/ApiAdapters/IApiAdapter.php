<?php

namespace App\Services\ApiAdapters;

interface IApiAdapter
{
    const SORT_PRICE_ASC = 1;
    const SORT_DEFAULT = 2;

    public function __construct($config);

    public function getKeywordItems($keyword,$priceMin,$priceMax,$sorting):array;
}
