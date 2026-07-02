<?php

use App\Http\Controllers\Admin\CoupleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventScheduleController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GiftController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\InvitationController;
use App\Http\Controllers\Admin\LoveStoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RsvpController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PublicInvitationController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/login');

Route::prefix('admin')->name('admin.')->group(function () {

    // Auth (tanpa middleware auth)
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    });

    // Area terproteksi
    Route::middleware('auth')->group(function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::post('invitations/{invitation}/switch', [InvitationController::class, 'switch'])->name('invitations.switch');
        Route::resource('invitations', InvitationController::class)->except(['show']);

        Route::resource('hero', HeroController::class)->except(['show']);
        Route::resource('couple', CoupleController::class)->except(['show']);
        Route::resource('events', EventScheduleController::class)->except(['show']);
        Route::resource('love-story', LoveStoryController::class)->except(['show']);
        Route::resource('gallery', GalleryController::class)->except(['show']);
        Route::resource('gifts', GiftController::class)->except(['show']);

        Route::get('rsvp', [RsvpController::class, 'index'])->name('rsvp.index');
        Route::delete('rsvp/{rsvp}', [RsvpController::class, 'destroy'])->name('rsvp.destroy');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        // Hanya super-admin (dicek juga lewat permission view-user/role di controller)
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);
    });
});

Route::get('{invitation:slug}', [PublicInvitationController::class, 'show'])->name('public.invitation.show');
