<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\AuthorTicketController;
use Illuminate\Support\Facades\Route;

// localhost/api/v1/tickets?filter[status]=X,C&filter[title]=*velit*&include=author&sort=-createdAt

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('tickets', TicketController::class);
        Route::apiResource('authors', AuthorController::class);
        Route::apiResource('authors.tickets', AuthorTicketController::class);
    });
});
