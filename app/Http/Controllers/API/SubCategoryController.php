<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SubCategoryService;
use App\Http\Resources\SubCategoryResource;

class SubCategoryController extends Controller
{
    public SubCategoryService $subCategoryService;

    public function __construct(SubCategoryService $sub_category)
    {
        $this->subCategoryService = $sub_category;
    }


    public function subCategoriesByCategory($category_id)
    {
        try {
            return SubCategoryResource::make(
                $this->subCategoryService->list($category_id)
            );
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
