<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Services\UniversityService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UniversityResource;

class UniversityController extends Controller
{
    public UniversityService $universityService;

    public function __construct(UniversityService $university)
    {
        $this->universityService = $university;
    }
    public function index()
    {
        try {
            return UniversityResource::collection(
                $this->universityService->list()
            );
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
