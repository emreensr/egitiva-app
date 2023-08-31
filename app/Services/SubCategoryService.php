<?php

namespace App\Services;

use App\Models\Category;

class SubCategoryService
{
    public function list($category_id)
    {
        $category = Category::findOrFail($category_id);

        return $category->subCategories;
    }
}
