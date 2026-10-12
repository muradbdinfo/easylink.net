<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\CoverageAreaController as AdminCoverageAreaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\StatController as AdminStatController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CorporateController;
use App\Http\Controllers\CoverageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// Public website
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/corporate', [CorporateController::class, 'index'])->name('corporate');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/coverage', [CoverageController::class, 'index'])->name('coverage.index');
Route::post('/coverage/check', [CoverageController::class, 'check'])->name('coverage.check');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authenticated user profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return request()->user()->is_admin
            ? redirect()->route('admin.dashboard')
            : redirect()->route('home');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin panel
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('packages', AdminPackageController::class)->except(['create', 'edit', 'show']);
    Route::resource('services', AdminServiceController::class)->except(['create', 'edit', 'show']);
    Route::resource('sliders', AdminSliderController::class)->except(['create', 'edit', 'show']);
    Route::resource('testimonials', AdminTestimonialController::class)->except(['create', 'edit', 'show']);
    Route::resource('partners', AdminPartnerController::class)->except(['create', 'edit', 'show']);
    Route::resource('blog-posts', AdminBlogPostController::class)->except(['create', 'edit', 'show']);
    Route::resource('coverage-areas', AdminCoverageAreaController::class)->except(['create', 'edit', 'show']);
    Route::resource('faqs', AdminFaqController::class)->except(['create', 'edit', 'show']);
    Route::resource('stats', AdminStatController::class)->except(['create', 'edit', 'show']);

    Route::get('contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::patch('contact-messages/{contactMessage}', [AdminContactMessageController::class, 'update'])->name('contact-messages.update');
    Route::delete('contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

    Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
