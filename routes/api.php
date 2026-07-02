<?php

use App\Http\Controllers\Api\InvitationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API - dikonsumsi oleh landing page undangan
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::get('invitation', [InvitationController::class, 'index']); // semua data sekaligus
    Route::get('invitation/hero', [InvitationController::class, 'hero']);
    Route::get('invitation/couples', [InvitationController::class, 'couples']);
    Route::get('invitation/events', [InvitationController::class, 'events']);
    Route::get('invitation/love-stories', [InvitationController::class, 'loveStories']);
    Route::get('invitation/galleries', [InvitationController::class, 'galleries']);
    Route::get('invitation/gifts', [InvitationController::class, 'gifts']);

    Route::post('rsvp', [InvitationController::class, 'storeRsvp']);

    Route::prefix('invitations/{invitation:slug}')->group(function () {
        Route::get('/', [InvitationController::class, 'index']);
        Route::get('hero', [InvitationController::class, 'hero']);
        Route::get('couples', [InvitationController::class, 'couples']);
        Route::get('events', [InvitationController::class, 'events']);
        Route::get('love-stories', [InvitationController::class, 'loveStories']);
        Route::get('galleries', [InvitationController::class, 'galleries']);
        Route::get('gifts', [InvitationController::class, 'gifts']);
        Route::post('rsvp', [InvitationController::class, 'storeRsvp']);
    });

    // Endpoint terproteksi (opsional, contoh: dashboard SPA terpisah konsumsi via token)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('rsvp', [InvitationController::class, 'rsvpList'])->middleware('permission:view-rsvp');
    });
});
