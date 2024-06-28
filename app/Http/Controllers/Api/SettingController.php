<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function __invoke(Request $request)
    {
        // يرجع صف واحد فقط
        $setting = Setting::find(1);
        if ($setting){
            return ApiResponse::sendResponse(200,'Settings Retrieved Successfully',new SettingResource($setting));
        }else{
            return ApiResponse::sendResponse(200,'Settings Not Found',[]);
//            return ApiResponse::sendResponse(204,'Settings Not Found',[]);
        }
//        return new SettingResource($setting);
        // يرجع عدد لا محدود من الصفوف
        //$setting = Setting::all();
        //return  SettingResource::collection($setting);
    }
}
