<?php

use App\Http\Controllers\Admin\AffiliateController as AdminAffiliateController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\GuideController as AdminGuideController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Affiliate\AuthController as AffiliateAuthController;
use App\Http\Controllers\Affiliate\CreativesController as AffiliateCreativesController;
use App\Http\Controllers\Affiliate\DashboardController as AffiliateDashboardController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\LeadController;
use App\Support\GuideArticles;
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

Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0'],
        ['loc' => route('how-it-works'), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => route('guides.index'), 'changefreq' => 'weekly', 'priority' => '0.9'],
        ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.6'],
        ['loc' => route('affiliates'), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ['loc' => route('compare.details'), 'changefreq' => 'weekly', 'priority' => '0.9'],
    ];

    foreach (array_keys(GuideArticles::all()) as $slug) {
        $urls[] = [
            'loc' => route('guides.show', $slug),
            'changefreq' => 'monthly',
            'priority' => '0.8',
        ];
    }

    return response()
        ->view('sitemap', ['urls' => $urls])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::prefix('compare')->name('compare.')->group(function () {
    Route::get('/details', [CompareController::class, 'details'])->name('details');
    Route::post('/details', [CompareController::class, 'storeDetails'])->name('details.store');

    Route::get('/usage', [CompareController::class, 'usage'])->name('usage');
    Route::post('/usage', [CompareController::class, 'storeUsage'])->name('usage.store');

    Route::get('/deals', [CompareController::class, 'deals'])->name('deals');
    Route::post('/deals', [CompareController::class, 'update'])->name('deals.update');
    Route::get('/go/{deal}', [CompareController::class, 'redirect'])->name('redirect');
    Route::get('/apply/{deal}', [CompareController::class, 'apply'])->name('apply');
    Route::post('/apply/{deal}', [CompareController::class, 'storeApply'])->name('apply.store');
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

        Route::prefix('cms')->name('cms.')->group(function () {
            Route::resource('guides', AdminGuideController::class)->except(['show']);
            Route::resource('faqs', AdminFaqController::class)->except(['show']);
            Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);
            Route::get('/settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
            Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
        });

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
        Route::get('/creatives', AffiliateCreativesController::class)->name('creatives');
        Route::post('/logout', [AffiliateAuthController::class, 'logout'])->name('logout');
    });
});
