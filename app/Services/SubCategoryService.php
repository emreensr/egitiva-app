<?php

namespace App\Services;

use App\Models\Category;

class SubCategoryService
{
    public function list($category_id)
    {
        $category = Category::with('subCategories')->findOrFail($category_id);

        return $category->subCategories;
    }
}
