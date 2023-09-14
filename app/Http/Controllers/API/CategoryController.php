<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public CategoryService $categoryService;

    public function __construct(CategoryService $category)
    {
        $this->categoryService = $category;
    }

    public function index()
    {
        try {
            return CategoryResource::collection(
                $this->categoryService->list()
            );
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
