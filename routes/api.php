<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\QueueController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\CounterController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\TicketHistoryController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    $user = $request->user();

    // If the user is an admin, return the user directly
    if ($user->role === 'admin') {
        return $user;
    }

    // For non-admin users, load the 'counter' relationship
    return $user->load('counter');
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::get('/queue', [QueueController::class, 'index']);
    Route::get('/tickets/ticket-call', [TicketController::class, 'callingClient']);
    Route::delete('/queue/pop-first', [QueueController::class, 'lpop']);
    Route::apiResource('users', UserController::class)->only(['index', 'show']);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('counters', CounterController::class);
    Route::apiResource('tickets', TicketController::class)->only(['index', 'show', 'store', 'update']);
})->middleware('auth:sanctum');
