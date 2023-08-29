<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\CityService;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;

class CityController extends Controller
{
    public CityService $cityService;

    public function __construct(CityService $city)
    {
        $this->cityService = $city;
    }

    public function index()
    {
        try {
            return CityResource::collection(
                $this->cityService->list()
            );
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
