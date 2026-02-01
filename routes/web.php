<?php

use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\TicketController;
use App\Http\Controllers\Web\TicketMessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin/dashboard');
    })->name('dashboard');
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'store'])->name('register.post');

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->can('viewAny', App\Models\Ticket::class);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);

    // • PATCH /api/tickets/{id}/status (Agent/Admin)
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus']);
    Route::patch('/tickets/{ticket}/assignAgent', [TicketController::class, 'assignAgent']);
    Route::patch('/tickets/{ticket}/assignPriority', [TicketController::class, 'assignPriority']);
    Route::post('/tickets/{ticket}/messages', [TicketMessageController::class, 'store']);
});
