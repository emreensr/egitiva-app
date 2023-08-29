<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'city_id',
        'district_id',
        'birth_date',
        'university_id',
        'department_id',
        'education_status',
        'experience_year',
        'about',
        'experience'
    ];
}
