<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;
use App\Models\District;
use Illuminate\Http\Request;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class DistrictController extends Controller
{
    public function __invoke(Request $request)
    {
       $District = District::where('city_id',$request->input('city'))->get();
       if (count($District) > 0){
return ApiResponse::sendResponse(200,"District Retrieved Successfully",DistrictResource::collection($District));
       }
        return ApiResponse::sendResponse(200,"District For This City Is Empty",[]);
    }
}
