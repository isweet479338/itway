<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\SalesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::post('/orders', [SalesController::class, 'store'])->name('orders.store');
Route::get('sales/{sale}/invoice', action: [SalesController::class, 'printInvoice'])->name('sales.invoice');
Route::get('sales-dashboard', [SalesController::class, 'dashboard'])->name('sales.dashboard');
Route::get('sales-report', [SalesController::class, 'report'])->name('sales.report');

Route::resource('sales', SalesController::class);

require __DIR__.'/auth.php';
