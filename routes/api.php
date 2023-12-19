<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DistanceController;
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

Route::resource('distance',DistanceController::class);
Route::get('distance/softDelete/{id}',[DistanceController::class,'softDelete'])->name('distance.softDelete');

Route::get('calculateDistance',[DistanceController::class,'calculateDistanceBetWeenTwoPoints']);