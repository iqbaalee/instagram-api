<?php

use App\Http\Controllers\ApiController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('v1')->group(function(){
    Route::get('/getAccountById', [ApiController::class, 'getAccountById']);
    Route::get('/getAccountByName', [ApiController::class, 'getAccountByName']);
    Route::get('/getMediaByUsername', [ApiController::class, 'getMediaByUsername']);
    Route::get('/getAccountFollowers', [ApiController::class, 'getAccountFollowers']);
    Route::get('/getFeed', [ApiController::class, 'getFeed']);
    Route::get('/getInbox', [ApiController::class, 'getInbox']);
});
