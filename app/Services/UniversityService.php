<?php

namespace App\Services;


use Exception;
use App\Models\University;

class UniversityService
{
    public function list()
    {
        return University::get();
    }
}
