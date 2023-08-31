<?php

namespace App\Services;

use App\Models\Category;

class CourseLevelService
{
    public function list($category_id)
    {
        $category = Category::findOrFail($category_id);

        return $category->levels;
    }
}
