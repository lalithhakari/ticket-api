<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\AuthorTicketController;
use App\Http\Controllers\Api\V1\TicketController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('tickets', TicketController::class);
        Route::put('tickets/{ticket}', [TicketController::class, 'replace'])->name('tickets.replace');

        Route::apiResource('authors', AuthorController::class);

        Route::apiResource('authors.tickets', AuthorTicketController::class);
        Route::put('authors/{author}/tickets/{ticket}', [AuthorTicketController::class, 'replace'])->name('authors.tickets.replace');
    });
});
