<?php

namespace App\Http\Controllers;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->user()->tickets()->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request, TicketService $ticketService)
    {
        $ticket = $ticketService->createTicket($request->user(), $request->subject);

        return response()->json([
            'message' => "Ticket created succsessfull.",
            'ticket' => $ticket,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return response()->json($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
