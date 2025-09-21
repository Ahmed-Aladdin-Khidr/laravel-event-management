<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\AttendeeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'singOut'])
    ->middleware('auth:sanctum');

// Public routes (no authorization needed)
Route::apiResource('events', EventController::class)
    ->only(['index', 'show']);

// Protected routes with authorization middleware
Route::apiResource('events', EventController::class)
    ->only(['store', 'update', 'destroy'])
    ->middleware(['auth:sanctum', 'throttle:api']);

// Event-specific authorization middleware
Route::put('events/{event}', [EventController::class, 'update'])
    ->middleware(['auth:sanctum', 'can:update,event']);

Route::delete('events/{event}', [EventController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'can:delete,event']);

// Attendee routes with authorization
Route::apiResource('events.attendees', AttendeeController::class)
    ->scoped()
    ->only(['index', 'show']);

Route::post('events/{event}/attendees', [AttendeeController::class, 'store'])
    ->middleware(['auth:sanctum', 'can:create,App\Models\Attendee']);

Route::delete('events/{event}/attendees/{attendee}', [AttendeeController::class, 'destroy'])
    ->middleware(['auth:sanctum', 'can:delete,attendee']);

