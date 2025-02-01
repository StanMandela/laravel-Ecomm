<?php

use App\Http\Controllers\ProfileController;
use App\Mail\MyEmail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;


Route::get('/', [\App\Http\Controllers\ProductController::class,'index'])->name('home');
Route::get('/product/{product:slug}', [\App\Http\Controllers\ProductsController::class, 'show'])->name('product.show');


// create route to send email
Route::get('/send-test-email', function () {
    Mail::to('test@example.com')->send(new MyEmail());
    return 'Test email has been sent!';
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
