<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DomainResource;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $Domains = Domain::all();
        if (count($Domains) > 0){
            return ApiResponse::sendResponse(200,"Domains Retrieved Successfully",DomainResource::collection($Domains));
        }
            return ApiResponse::sendResponse(200,"Domains are empty",[]);
    }
}
