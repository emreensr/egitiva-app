<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'slug',
        'status'
    ];
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function levels() : HasMany
    {
        return $this->hasMany(CourseLevel::class);
    }
}
