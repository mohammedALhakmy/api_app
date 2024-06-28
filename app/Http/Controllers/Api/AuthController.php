<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use function Webmozart\Assert\Tests\StaticAnalysis\null;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
           'name' => ['required','string','max:255'],
           'email' => ['required','email','max:255','unique:users'],
            'password' => ['required', 'confirmed',Password::defaults()],
        ], [],[
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Register Validation Errors', $validator->messages()->all());
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $data['token'] = $user->createToken('APICourse')->plainTextToken;
        $data['name']  = $user->name;
        $data['email'] = $user->email;
        return  ApiResponse::sendResponse(201,"User Account Created Successfully",$data);
    }

    public function create()
    {
        //
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => ['required','email'],
            'password' => ['required']
        ], [],[
            'email' => 'Email',
            'password' => 'Password',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, 'Login Validation Errors', $validator->errors());
        }
if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
    $currentUser = Auth::user();
    $data['token'] = $currentUser->createToken('APICourse')->plainTextToken;
    $data['name']  = $currentUser->name;
    $data['email'] = $currentUser->email;
    return  ApiResponse::sendResponse(200,"User Logged Successfully",$data);
}else{
    return  ApiResponse::sendResponse(401,"User Credentials doesnt exits",null);
}

    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function logout(Request $request)
    {
        Log::info('Logout method called');
        Log::info('User: ', ['user' => $request->user()]);
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200,"Logged Out SuccessFully",[]);
    }
}
