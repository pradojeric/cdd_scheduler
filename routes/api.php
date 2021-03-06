<?php

use App\Http\Controllers\API\v1\ApiController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'ability:get-schedule'])->namespace('API\v1')->prefix('v1')->group( function () {
    Route::get('/get-schedules', [ApiController::class, 'getSchedules']);
    Route::get('/get-faculties', [ApiController::class, 'getFaculties']);
});

