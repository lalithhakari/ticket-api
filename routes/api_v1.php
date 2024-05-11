<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\AuthorTicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// localhost/api/tickets?filter[status]=X,C&filter[title]=*velit*&include=author&sort=-createdAt

Route::apiResource('tickets', TicketController::class);
Route::apiResource('authors', AuthorController::class);
Route::apiResource('authors.tickets', AuthorTicketController::class);
