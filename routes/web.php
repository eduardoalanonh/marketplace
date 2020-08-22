<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/model', function () {
   $loja = \App\Store::find(1);

  return dd($loja->products());
});



Route::prefix('admin')->namespace('Admin')->group(static function (){
    Route::prefix('stores')->group(function (){
        Route::get('/','StoreController@index');
        Route::get('/create','StoreController@create');
        Route::post('/store','StoreController@store');
    });
});
