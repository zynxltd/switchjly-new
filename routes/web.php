<?php

use App\Http\Controllers\CompareController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');

Route::prefix('compare')->name('compare.')->group(function () {
    Route::get('/details', [CompareController::class, 'details'])->name('details');
    Route::post('/details', [CompareController::class, 'storeDetails'])->name('details.store');

    Route::get('/usage', [CompareController::class, 'usage'])->name('usage');
    Route::post('/usage', [CompareController::class, 'storeUsage'])->name('usage.store');

    Route::get('/deals', [CompareController::class, 'deals'])->name('deals');
});
