<?php

namespace App\ApiResponse\Facades;

use Illuminate\Support\Facades\Facade;

class ApiResponseFacades extends Facade {

    protected static function getFacadeAccessor()
    {
        return "ApiResponseFacades";
    }
}