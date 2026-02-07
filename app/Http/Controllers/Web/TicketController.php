<?php

namespace App\Http\Controllers\Web;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StatusChangeRequest;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::latest()->paginate(10);
        $agents = User::where('role', UserRole::Agent)->get();
        $priorities = TicketPriority::cases();

        return view('admin.tickets.index', compact('tickets', 'agents', 'priorities'));
    }

    public function dashboard()
    {
        $tickets = Ticket::latest()->paginate(10);

        $stats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', TicketStatus::Open)->count(),
            'in_progress' => Ticket::where('status', TicketStatus::InProgress)->count(),
            'closed' => Ticket::where('status', TicketStatus::Closed)->count(),
        ];
        return view('admin/dashboard', compact('tickets', 'stats'));
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        //checking the messages and their users role
        // dd($ticket->load('messages.user')->messages->map(fn ($msg)=> $msg->user?->role));

        return view('admin/ticket-details', compact('ticket'));
    }

    public function updateStatus(StatusChangeRequest $request, Ticket $ticket, TicketService $ticketService)
    {
        $isUpdated = $ticketService->updateStatus(
            $ticket,
            $request->status
        );

        return redirect()->back();
    }

    public function assignAgent(Request $request,)
    {

        $validated = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'agent_id' => 'nullable|exists:users,id',
        ]);
        $ticket = Ticket::findOrFail($request->input('ticket_id'));

        $this->authorize('assign', $ticket);


        $ticket->update(['agent_id' => $validated['agent_id']]);

        return redirect()->back()->with('success', 'Agent assigned successfully');
    }

    public function assignPriority(Request $request)
    {
        $validated =  $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket = Ticket::findOrFail($request->input('ticket_id'));

        $this->authorize('assign', $ticket);


        $ticket->update(['priority' => $validated['priority']]);

        return redirect()->back()->with('success', 'Priority updated successfully');
    }
}
