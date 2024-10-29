<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\CounterController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\TicketHistoryController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('counters', CounterController::class);
    Route::apiResource('tickets', TicketController::class)->only(['index', 'show']);
    Route::apiResource('ticketHistories', TicketHistoryController::class)->only(['index', 'show']);
})->middleware(['auth:sanctum']);
