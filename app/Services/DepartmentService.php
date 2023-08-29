<?php

namespace App\Services;


use Exception;
use App\Models\Department;
use App\Models\University;

class DepartmentService
{
    public function list($university_id)
    {
        $university = University::findOrFail($university_id);

        return $university->department;
    }
}
