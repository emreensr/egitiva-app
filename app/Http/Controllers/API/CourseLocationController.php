<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Services\CourseLocationService;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseLocationResource;

class CourseLocationController extends Controller
{
    public CourseLocationService $locationService;

    public function __construct(CourseLocationService $location)
    {
        $this->locationService = $location;
    }

    public function index()
    {
        try {
            return CourseLocationResource::collection(
                $this->locationService->list()
            );
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
