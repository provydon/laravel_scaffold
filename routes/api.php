<?php

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


 // Auth Routes
 Route::post('login', 'Api\AuthController@login')->middleware(["validate:login"]);
 Route::post('logout', 'Api\AuthController@logout')->middleware(["validate:login"]);
 Route::post('register', 'Api\AuthController@register')->middleware(["validate:register"]);
 Route::post('forgot-password', 'Api\AuthController@forgotPassword')->middleware(["validate:forgot-password"]);


// Logged In Routes
Route::middleware(['auth:sanctum'])->group(function () {

     // User Routes
     Route::get('user', 'Api\UserController@index');
     Route::post('user/update', 'Api\UserController@update')->middleware(["validate:update-user"]);
});