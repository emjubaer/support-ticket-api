<?php

namespace App\Http\Controllers\Web;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StatusChangeRequest;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(){


        $tickets = Ticket::latest()->paginate(10);

        return view('admin.tickets.index', compact('tickets',));
    }
    public function dashboard(){
        $tickets = Ticket::latest()->paginate(10);

        $stats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', TicketStatus::Open)->count(),
            'in_progress' => Ticket::where('status', TicketStatus::InProgress)->count(),
            'closed' => Ticket::where('status', TicketStatus::Closed)->count(),
        ];
        return view('admin/dashboard', compact('tickets', 'stats'));
    }

    public function show(Ticket $ticket){
        $this->authorize('view', $ticket);

        //checking the messages and their users role
       // dd($ticket->load('messages.user')->messages->map(fn ($msg)=> $msg->user?->role));

        return view('admin/ticket-details', compact('ticket'));
    }

    public function updateStatus(StatusChangeRequest $request, Ticket $ticket, TicketService $ticketService)
    {
        $isUpdated =  $ticketService->updateStatus(
            $ticket,
            $request->status
        );

        return redirect()->back();
    }
}
