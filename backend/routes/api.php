<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ClubController;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('events', EventsController::class);
    Route::apiResource('clubs', ClubController::class);

    Route::post('/clubs/{id}/join', [ClubController::class, 'join']);
    Route::get('/clubs/{id}/members', [ClubController::class, 'members']);

    Route::post('/events/{id}/rsvp', [EventsController::class, 'rsvp']);
    Route::post('/events/{id}/cancel-rsvp', [EventsController::class, 'cancelRsvp']);
});
