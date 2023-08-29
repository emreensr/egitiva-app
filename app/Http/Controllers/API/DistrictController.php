<?php

namespace App\Http\Controllers\API;

use Exception;
use Illuminate\Http\Request;
use App\Services\DistrictService;
use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;

class DistrictController extends Controller
{
    public DistrictService $districtService;

    public function __construct(DistrictService $district)
    {
        $this->districtService = $district;
    }

    public function districtsByCity($city_id)
    {
        try {
            return DistrictResource::collection(
                $this->districtService->list($city_id)
            );
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
