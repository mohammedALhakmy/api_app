<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewMessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class MessageController extends Controller
{

    public function __invoke(NewMessageRequest $request)
    {
        $data = $request->validated();
        $record = Message::create($data);
        if ($request){
return ApiResponse::sendResponse(201,"Sent SuccessFully",[]);
        }
    }
}
