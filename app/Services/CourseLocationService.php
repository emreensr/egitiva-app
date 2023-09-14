<?php

namespace App\Services;


use App\Models\Location;
use Exception;
use Illuminate\Support\Facades\Log;
use Smartisan\Settings\Facades\Settings;

class CourseLocationService
{
    public function list()
    {
        return Location::get();
    }
}
