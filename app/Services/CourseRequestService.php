<?php

namespace App\Services;


use App\Models\CourseRequests;
class CourseRequestService
{
    public function list()
    {
        return CourseRequests::with('locations', 'user', 'city', 'district', 'category', 'subCategory', 'level')->get();
    }
}
