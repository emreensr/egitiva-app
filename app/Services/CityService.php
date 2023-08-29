<?php

namespace App\Services;


use App\Models\City;
use Exception;
use Illuminate\Support\Facades\Log;
use Smartisan\Settings\Facades\Settings;

class CityService
{
    public function list()
    {
        return City::get();
    }
}
