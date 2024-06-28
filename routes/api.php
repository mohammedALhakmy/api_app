<?php

use App\Helpers\ApiResponse;
use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\DomainController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
## -------------- SETTINGS MODULE
Route::get('/setting',SettingController::class);

## ------------- CITIES MODULE
Route::get('/Cities',CityController::class);

## ------------- DISTRICTS MODULE
Route::get('/District',DistrictController::class);


## ------------- MESS AGES MODULE
Route::post('/Message',MessageController::class);

## ------------- DOMAINS MODULE
Route::get('/domains',DomainController::class);


## ------------- AUTH MODULE
Route::controller(AuthController::class)->group(function() {
    Route::post('register', 'index');
    Route::post('/login', 'login');
   // Route::middleware('auth:sanctum')->post('/logout','logout');
});

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::prefix('ads')->controller(AdController::class)->group(function (){
    //bssic
    Route::get('/','index');
    Route::get('/create','create');
    Route::get('/latest','latest');
    Route::get('/domain/{domain_id}','domain');
    Route::get('/search','search');
    // User Api ads endpoint
    Route::middleware('auth:sanctum')->group(function (){
       Route::post('creates','creates');
       Route::post('update/{adId}','update');
       Route::get('delete/{adId}','delete');
       Route::get('/myads','myads');
    });
});
/*Route::post('/logout',function (Illuminate\Http\Request $request){
    $request->user()->currentAccessToken()->delete();
    return ApiResponse::sendResponse(204,"Logged Out SuccessFully",[]);
})->middleware('auth:sanctum');*/
//Route::post('/logout', 'logout')->middleware('auth:sanctum');

