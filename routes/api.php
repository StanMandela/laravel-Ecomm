<?php
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', [AuthController::class, 'getUser']);

Route::post('/login', [AuthController::class, 'login_new']);
Route::post('/register', [AuthController::class, 'register_new']);
Route::post('/reg', [ProductsController::class, 'makePostTransaction']);


Route::middleware(['auth:sanctum','admin'])->group( function(){

    Route::get('/user', [AuthController::class,'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('/product', ProductsController::class);

});