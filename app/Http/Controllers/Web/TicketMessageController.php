<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMessageRequest;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketMessageController extends Controller
{
     public function store(AddMessageRequest $request, Ticket $ticket, TicketService $ticketService)
    {
        $message = $ticketService->addMessageToTicket(
            $ticket,
            $request->user(),
            $request->message
        );

        return redirect()->route('tickets.show', $ticket)->with('success', 'Message added to ticket successfully.');
    }
}
