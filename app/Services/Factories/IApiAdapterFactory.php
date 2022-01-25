<?php

namespace App\Services\Factories;

use App\Services\ApiAdapters\IApiAdapter;

interface IApiAdapterFactory
{
    public  function make($name): IApiAdapter;
}
