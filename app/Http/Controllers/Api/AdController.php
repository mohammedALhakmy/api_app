<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdRequest;
use App\Http\Requests\UpdateAdRequest;
use App\Http\Resources\AdResource;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Ad::latest()->get();
        if (count($ads) > 0){
//            return ApiResponse::sendResponse(200,"Ads Retrieved Successfully",AdResource::collection($ads));
            return ApiResponse::sendResponse(200,"Ads Retrieved Successfully",$ads);
        }
        return  ApiResponse::sendResponse(200,"No Ads available",[]);
    }

    public function create()
    {
        $ads = Ad::latest()->paginate(1);
        if (count($ads) > 0){
            if ($ads->total() > $ads->perPage()) {
                $data = [
                    'records' => AdResource::collection($ads),
                    'pagination_links' => [
                        'current_page' => $ads->currentPage(),
                        'per_page' => $ads->perPage(),
                        'total' => $ads->total(),
                        'links' => [
                            'first' => $ads->url(1),
                            'last' => $ads->url($ads->lastPage()),
                        ]
                    ]
                ];
            }
            else{
                $data = AdResource::collection($ads);
            }
            return ApiResponse::sendResponse(200,"Ads Retrieved Successfully",$data);
        }
        return  ApiResponse::sendResponse(200,"No Ads available",[]);
    }

    public function latest()
    {
        $ads = Ad::latest()->take(2)->get();
        if (count($ads) > 0){
            return  ApiResponse::sendResponse(200,"Ads Retrieved Successfully",AdResource::collection($ads));
        }
        return  ApiResponse::sendResponse(200,"There Are no Latest ads",[]);
    }

    public function domain($domain_id)
    {
        $ads = Ad::where('domain_id',$domain_id)->latest()->get();
        if (count($ads) > 0){
            return  ApiResponse::sendResponse(200,"Ads in the domain Retrieved Successfully",AdResource::collection($ads));
        }
        return  ApiResponse::sendResponse(200,"empty",[]);
    }

    public function search(Request $request)
    {
$word = $request->input('search') ?? null;
$ads = Ad::when($word != null,function ($q) use($word){
   $q->where('title',"like","%".$word."%");
})->latest()->get();
if (count($ads) > 0){
    return  ApiResponse::sendResponse(200,"Search completed",AdResource::collection($ads));
}
    return  ApiResponse::sendResponse(200,"No matching data",[]);
    }

    public function creates(AdRequest $request)
    {
            $data = $request->validated();
            $data['user_id'] = $request->user()->id;
            $record = Ad::create($data);
if ($record)
    {
        return ApiResponse::sendResponse(201,'Your Ad created successfully',new AdResource($data));
    }
        return ApiResponse::sendResponse(500, 'Failed to create Ad', []);
    }

    public function update(UpdateAdRequest $request,$adId)
    {
        $ad = Ad::find($adId);
        if (!$ad) {
            return ApiResponse::sendResponse(404, "Ad not found", []);
        }
        if ($ad->user_id != $request->user()->id) {
            return ApiResponse::sendResponse(403, "You aren't allowed to take this action", []);
        }
        $data = $request->validated();
        $record = $ad->update($data);
        if ($record) {
            return ApiResponse::sendResponse(200, 'Your Ad updated successfully', new AdResource($ad));
        }
        return ApiResponse::sendResponse(500, 'Failed to update Ad', []);
    }

    public function delete(Request $request,$adId){
        $ad = Ad::find($adId);
        if (!$ad) {
            return ApiResponse::sendResponse(404, "Ad not found", []);
        }
        if ($ad->user_id != $request->user()->id) {
            return ApiResponse::sendResponse(403, "You aren't allowed to take this action", []);
        }
        $record = $ad->delete();
        if ($record) {
            return ApiResponse::sendResponse(200, 'Your Ad deleted successfully', new AdResource($ad));
        }
        return ApiResponse::sendResponse(500, 'Failed to update Ad', []);
    }

    public function myads(Request $request){
$ads = Ad::where('user_id',$request->user()->id)->latest()->get();
if (count($ads) > 0){
    return ApiResponse::sendResponse(200,"My Ads retrieved successfully",AdResource::collection($ads));
}
        return ApiResponse::sendResponse(200,"Empty not have Data",[]);
    }

}
