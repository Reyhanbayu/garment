<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProcessResource;
use App\Http\Controllers\userApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('process/{id}', [ApiController::class, 'getProcessUser']);
Route::get('material/quantity/{id}',[ApiController::class,'getMaterialQuantity']);
Route::get('colour/search',[ApiController::class,'searchColour']);
