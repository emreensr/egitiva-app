<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Services\DepartmentService;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;

class DepartmentController extends Controller
{
    public DepartmentService $departmentService;

    public function __construct(DepartmentService $department)
    {
        $this->departmentService = $department;
    }

    public function departmentsByUniversity($university_id)
    {
        try {
            return DepartmentResource::collection(
                $this->departmentService->list($university_id)
            );
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
