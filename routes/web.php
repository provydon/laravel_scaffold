<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', 'PageController@getIndex')->name('index');
Route::get('/google-redirect', 'SocialAuthController@googleRedirect')->name('google-redirect');
Route::get('/google-callback', 'SocialAuthController@googleCallback')->name('google-callback');
Route::get('/facebook-redirect', 'SocialAuthController@facebookRedirect')->name('facebook-redirect');
Route::get('/facebook-callback', 'SocialAuthController@facebookCallback')->name('facebook-callback');




Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // GroupChat
    Route::resource('groups', 'GroupController');
    Route::resource('conversations', 'ConversationController');
});
