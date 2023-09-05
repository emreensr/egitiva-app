<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CourseRequestService;
use App\Http\Resources\CourseRequestResource;

class CourseRequestController extends Controller
{
    public CourseRequestService $courseRequestService;

    public function __construct(CourseRequestService $courseRequest)
    {
        $this->courseRequestService = $courseRequest;
    }

    public function index()
    {
        try {
            return CourseRequestResource::collection(
                $this->courseRequestService->list()
            );
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
