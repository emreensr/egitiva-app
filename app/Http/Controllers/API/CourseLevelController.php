<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CourseLevelService;
use App\Http\Resources\CourseLevelResource;

class CourseLevelController extends Controller
{
    public CourseLevelService $levelService;

    public function __construct(CourseLevelService $level)
    {
        $this->levelService = $level;
    }


    public function levelsByCategory($category_id)
    {
        try {
            return CourseLevelResource::make(
                $this->levelService->list($category_id)
            );
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
