<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\EventTypeController;
use App\Http\Controllers\Api\ReservationController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('logout', [AuthController::class, 'logout']);
        Route::apiResource('events', EventController::class);
        Route::apiResource('event-types', EventTypeController::class)->except(['show']);
        Route::apiResource('locations', LocationController::class)->except(['show']);

        Route::apiResource('reservations', ReservationController::class)->except(['show']);

        Route::post('events/{event}/image', [EventController::class, 'addImage']);
        Route::post('locations/{location}/image', [LocationController::class, 'addImage']);


       // Route::get('events/{event}', [EventController::class, 'show']); ///ملاحظة
    });
