<?php

namespace App\Services;


use Exception;
use App\Models\City;
use App\Models\District;
use Illuminate\Support\Facades\Log;
use Smartisan\Settings\Facades\Settings;

class DistrictService
{
    public function list($city_id)
    {
        $city = City::findOrFail($city_id);

        return $city->districts;
    }
}
