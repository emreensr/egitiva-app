<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function list()
    {
        return Category::with('subCategories')->get();
    }
}
