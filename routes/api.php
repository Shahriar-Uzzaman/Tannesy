<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;



//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::prefix('auth')->group(function (){
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
    Route::post('varification',[AuthController::class,'emailVarification']);
});

Route::middleware(['auth'])->group(function(){

    //accessable only for admin
    Route::middleware(['role:Admin'])->group(function(){
        Route::prefix('category')->group(function(){
            Route::post('create',[CategoryController::class,'create']);
            Route::put('{id}',[CategoryController::class,'update']);
            Route::delete('{id}',[CategoryController::class,'delete']);
        });
    });

    // accessable only for seller
    Route::middleware(['role:Seller'])->group(function() {
        Route::prefix('products')->group(function () {
            Route::post('/', [ProductController::class, 'create']);
            Route::post('{id}', [ProductController::class, 'update']);
            Route::delete('{id}', [ProductController::class, 'delete']);
        });
    });

    //globally accessable for all loged in user
    Route::prefix('category')->group(function(){
        Route::get('all_categories',[CategoryController::class,'findAll']);
        Route::get('one_category/{id}',[CategoryController::class,'getOne']);
    });

    Route::prefix('products')->group(function () {
        Route::get('/{user_id}', [ProductController::class, 'getByUser']);
        Route::get('/{category_id}', [ProductController::class, 'getByCategory']);
    });
});
