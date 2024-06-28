<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $cities = City::all();
        if (count($cities) > 0) {
return ApiResponse::sendResponse(200,'Cities Retried SuccessFully',CityResource::collection($cities));
        }
return ApiResponse::sendResponse(200,'Cities is Empty',[]);
    }
}
