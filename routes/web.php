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

Route::get('/','HomeController@index' )->name('home');
Route::get('/product/{slug}', 'HomeController@single')->name('product.single');
Route::prefix('cart')->name('cart.')->group(function (){
    Route::get('/','CartController@index')->name('index');
    Route::post('add', 'CartController@add')->name('add');
    Route::get('remove/{slug}','CartController@remove')->name('remove');
    Route::get('cancel','CartController@cancel')->name('cancel');

});



Route::get('/model', function () {
    $loja = \App\Store::find(1);

    return dd($loja->products());
});

Route::group(['middleware' => ['auth']], function () {

    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(static function () {

        Route::resource('stores', 'StoreController');
        Route::resource('products', 'ProductController');
        Route::resource('categories','CategoryController');
        Route::post('photos/remove','ProductPhotoCOntroller@removePhoto')->name('photo.remove');
    });

});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
