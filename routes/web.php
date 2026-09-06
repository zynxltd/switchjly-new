<?php

use App\Http\Controllers\Admin\AffiliateController as AdminAffiliateController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Affiliate\AuthController as AffiliateAuthController;
use App\Http\Controllers\Affiliate\DashboardController as AffiliateDashboardController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/how-it-works', function () {
    return view('how-it-works');
})->name('how-it-works');

Route::get('/affiliates', function () {
    return view('affiliates');
})->name('affiliates');

Route::get('/guides', [GuideController::class, 'index'])->name('guides.index');
Route::get('/guides/{slug}', [GuideController::class, 'show'])->name('guides.show');

Route::prefix('compare')->name('compare.')->group(function () {
    Route::get('/details', [CompareController::class, 'details'])->name('details');
    Route::post('/details', [CompareController::class, 'storeDetails'])->name('details.store');

    Route::get('/usage', [CompareController::class, 'usage'])->name('usage');
    Route::post('/usage', [CompareController::class, 'storeUsage'])->name('usage.store');

    Route::get('/deals', [CompareController::class, 'deals'])->name('deals');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');
    });

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::get('/leads', [AdminLeadController::class, 'index'])->name('leads');
        Route::get('/affiliates', [AdminAffiliateController::class, 'index'])->name('affiliates');
        Route::get('/payouts', [AdminAffiliateController::class, 'payouts'])->name('payouts');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

Route::prefix('affiliate')->name('affiliate.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AffiliateAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AffiliateAuthController::class, 'login'])->name('login.store');
    });

    Route::middleware(['auth', 'role:affiliate'])->group(function () {
        Route::get('/', AffiliateDashboardController::class)->name('dashboard');
        Route::post('/logout', [AffiliateAuthController::class, 'logout'])->name('logout');
    });
});
