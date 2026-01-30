<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\TicketMessageController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->can('viewAny', App\Models\Ticket::class);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);

    // • PATCH /api/tickets/{id}/status (Agent/Admin)
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus']);
    Route::patch('/tickets/{ticket}/assignAgent', [TicketController::class, 'assignAgent']);
    Route::patch('/tickets/{ticket}/assignPriority', [TicketController::class, 'assignPriority']);
    Route::post('/tickets/{ticket}/messages', [TicketMessageController::class, 'store']);
});
