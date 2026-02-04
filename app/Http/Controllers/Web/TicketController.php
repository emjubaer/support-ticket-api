<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function dashboard(){
        $tickets = Ticket::latest()->paginate(10);
        return view('admin/dashboard', compact('tickets'));
    }

    public function show(Ticket $ticket){
        $this->authorize('view', $ticket);
        return view('admin/ticket-details', compact('ticket'));
    }
}
