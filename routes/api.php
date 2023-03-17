<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MobilenumberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Models\Image;
use App\Models\Mobilenumber;
use App\Models\Order;
use App\Models\Teacher;
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

    //Many-To-Many Relationship
    Route::controller(TodoController::class)->prefix('todo')->group(function(){
        Route::post('list','list')->name('todo.list');
        Route::post('create','create')->name('todo.create');
        Route::patch('update/{id}','update')->name('todo.update');
        Route::get('get/{id}','get')->name('todo.get');
        Route::delete('delete/{id}','destroy')->name('todo.create');
    });

    //Polymorphic Relationship
    
    //one-to-one 
    Route::controller(TeamController::class)->prefix('team')->group(function(){
        Route::post('list','list')->name('team.list');
        Route::post('create','create')->name('team.create');
        Route::patch('update/{id}','update')->name('team.update');
        Route::get('get/{id}','get')->name('team.get');
        Route::delete('delete/{id}','destroy')->name('team.create');
    });

     Route::controller(PlayerController::class)->prefix('player')->group(function(){
        Route::post('list','list')->name('player.list');
        Route::post('create','create')->name('player.create');
        Route::patch('update/{id}','update')->name('player.update');
        Route::get('get/{id}','get')->name('player.get');
        Route::delete('delete/{id}','destroy')->name('player.create');
    });

    //One-To-Many
    Route::controller(StudentController::class)->prefix('student')->group(function(){
        Route::post('list','list')->name('student.list');
        Route::post('create','create')->name('student.create');
        Route::patch('update/{id}','update')->name('student.update');
        Route::get('get/{id}','get')->name('student.get');
        Route::delete('delete/{id}','destroy')->name('student.create');
    });

     //One-To-Many
     Route::controller(TeacherController::class)->prefix('teacher')->group(function(){
        Route::post('list','list')->name('teacher.list');
        Route::post('create','create')->name('teacher.create');
        Route::patch('update/{id}','update')->name('teacher.update');
        Route::get('get/{id}','get')->name('teacher.get');
        Route::delete('delete/{id}','destroy')->name('teacher.create');
    });
});
