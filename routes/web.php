<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\StallController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('vendors', VendorController::class);
    Route::resource('stalls', StallController::class);
    Route::resource('payments', PaymentController::class);

    Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
    Route::get('/payments/{payment}/print-receipt', [PaymentController::class, 'printReceipt'])->name('payments.print-receipt');

    Route::post('/stalls/{stall}/assign-vendor', [StallController::class, 'assignVendor'])->name('stalls.assign-vendor');

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/vendors', [ReportController::class, 'vendors'])->name('vendors');
        Route::get('/stalls', [ReportController::class, 'stalls'])->name('stalls');
        Route::get('/revenue', [ReportController::class, 'revenue'])->name('revenue');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');
    });

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
