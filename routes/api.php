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

Route::apiResource('product', 'ProductController');
Route::group(['prefix'=>'product/{product}/price', 'namespace'=>'Product'], function(){
    Route::post('', 'ProductPricesController@store');
    Route::put('/{type}', 'ProductPricesController@update');
    Route::delete('/{type}', 'ProductPricesController@destroy');
    Route::get('', 'ProductPricesController@index');
});
