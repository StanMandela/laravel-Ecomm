<?php
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/test', function () {
    return 'This is a test route';
});
Route::post('/login', [AuthController::class, 'login_new']);
Route::post('/register', [AuthController::class, 'register_new']);


Route::middleware(['auth:sanctum','admin'])->group( function(){

    Route::get('/users', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);


});