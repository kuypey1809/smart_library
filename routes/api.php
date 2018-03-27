<?php

use Illuminate\Http\Request;

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

Route::get('demo', function () {
    return response()->json([
        'user' => App\Models\User::get(),
        'auth' => auth()->user(),
        'code' => 200,
    ]);
});

Route::group(['namespace' => 'Auth'], function () {
    Route::post('login', 'LoginController@apiLogin')->name('login');
    Route::post('register', 'RegisterController@apiRegister')->name('register');

    Route::middleware('auth:api')->get('logout', 'LoginController@apiLogout')->name('logout');
});
