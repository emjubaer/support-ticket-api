<?php

use App\Http\Controllers\Web\AgentController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\TicketController;
use App\Http\Controllers\Web\TicketMessageController;
use App\Models\Ticket;
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
    Route::post('/tickets', [TicketController::class, 'createTicket'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

    //Agents Route
    Route::get('/agents', [AgentController::class, 'agentsIndex'])->name('agents.index');
    Route::get('/agents/{agent}', [AgentController::class, 'agentDetails'])->name('agent.show');
    Route::post('/agents', [AgentController::class, 'store'])->name('agents.store')->middleware('isAdmin');

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
