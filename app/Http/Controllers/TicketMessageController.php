<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketMessageController extends Controller
{
    public function store(
        Request $request,
        Ticket $ticket,
        TicketService $ticketService
    ) {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = $ticketService->addMessageToTicket(
            $ticket,
            $request->user(),
            $request->message
        );

        return response()->json([
            'message' => "Message added to ticket successfully.",
            'ticketMessage' => $message,
        ]);
    }
}
