<?php

namespace App\Services\ApiAdapters;

interface IApiAdapter
{
    public function __construct($config);

    public function getKeywordItems($keyword):array;
}
