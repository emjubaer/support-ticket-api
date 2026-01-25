<?php

namespace App\Http\Controllers;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Requests\StatusChangeRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return TicketResource::collection(
            $request->user()->tickets()->with('messages')->latest()->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request, TicketService $ticketService)
    {
        $ticket = $ticketService->createTicket(
            $request->subject,
            $request->user(),
            $request->message
        );

        return response()->json([
            'message' => "Ticket created successfully.",
            'ticket' => $ticket,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return TicketResource::make($ticket->load('messages.user', 'customer'));
    }    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(StatusChangeRequest $request, Ticket $ticket, TicketService $ticketService)
    {

        $isUpdated =  $ticketService->updateStatus(
            $ticket,
            $request->status
        );

        return response()->json(
            ['message' => $isUpdated ? "Update Successfully." : "Something went wrong"]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
