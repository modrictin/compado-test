<?php

namespace App\Facades;

use App\Services\Factories\IApiAdapterFactory;

class ApiProviderAdapterFactoryFacade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return IApiAdapterFactory::class ;
    }
}
