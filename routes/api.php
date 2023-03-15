<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MobilenumberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Image;
use App\Models\Mobilenumber;
use App\Models\Order;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
});

Route::middleware(['auth:sanctum'])->group(function(){
   Route::controller(ImageController::class)->prefix('image')->group(function()
   {
        Route::post('list','list')->name('image.list');
        Route::post('create','create')->name('image.create');
        Route::patch('update/{id}','update')->name('image.update');
        Route::get('get/{id?}','get')->name('image.get');
        Route::delete('delete/{id}','destroy')->name('image.create');
   });

   Route::controller(UserController::class)->prefix('user')->group(function(){
        Route::post('list','list')->name('user.list');
        Route::patch('update/{id}','update')->name('user.update');
        Route::get('get','get')->name('user.get');
        Route::delete('delete','destroy')->name('user.create');
   });

   Route::controller(MobilenumberController::class)->prefix('mobile')->group(function(){
        Route::post('list','list')->name('mobile.list');
        Route::post('create','create')->name('mobile.create');
        Route::patch('update/{id}','update')->name('mobile.update');
        Route::get('get','get')->name('mobile.get');
        Route::delete('delete/{id}','destroy')->name('mobile.create');
    });

    Route::controller(CategoryController::class)->prefix('category')->group(function(){
        Route::post('list','list')->name('category.list');
        Route::post('create','create')->name('category.create');
        Route::patch('update/{id}','update')->name('category.update');
        Route::get('get/{id}','get')->name('category.get');
        Route::delete('delete/{id}','destroy')->name('category.create');
    });

    Route::controller(ProductController::class)->prefix('product')->group(function(){
        Route::post('list','list')->name('product.list');
        Route::post('create','create')->name('product.create');
        Route::patch('update/{id}','update')->name('product.update');
        Route::get('get/{id}','get')->name('product.get');
        Route::delete('delete/{id}','destroy')->name('product.create');
    });

    Route::controller(OrderController::class)->prefix('order')->group(function(){
        Route::post('list','list')->name('order.list');
        Route::post('create','create')->name('order.create');
        Route::patch('update/{id}','update')->name('order.update');
        Route::get('get/{id}','get')->name('order.get');
        Route::delete('delete/{id}','destroy')->name('order.create');
    });

});
