<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;

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



Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);


Route::middleware('auth:api')->group(function () {
    Route::post('profile', [ProfileController::class, 'show']);
    Route::post('logout', [ProfileController::class, 'logout']);

    Route::apiResource('products', ProductController::class);
});

