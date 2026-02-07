<?php

use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\TicketController;
use App\Http\Controllers\Web\TicketMessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TicketController::class, 'dashboard'])->name('dashboard');
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'store'])->name('register.post');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index')->can('viewAny', App\Models\Ticket::class);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

    // • PATCH /api/tickets/{id}/status (Agent/Admin)
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::patch('/tickets/assignAgent', [TicketController::class, 'assignAgent'])->name('assignAgent');
    Route::patch('/tickets/assignPriority', [TicketController::class, 'assignPriority'])->name('changePriority');
    Route::post('/tickets/{ticket}/messages', [TicketMessageController::class, 'store'])->name('tickets.messages.store');


});

Route::get('/test', function () {
    return view('admin.tickets.ticket-details', [
        'ticket' => App\Models\Ticket::with('messages.user')->first(),
    ]);
});
