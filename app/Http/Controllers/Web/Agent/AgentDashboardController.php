<?php

namespace App\Http\Controllers\Web\Agent;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AgentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $agent = $request->user();
        if (!$agent->isAgent()) {
            abort(403, 'Unauthorized');
        }

        $baseQuery = Ticket::where('agent_id', $agent->id);

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'open' => (clone $baseQuery)->where('status', TicketStatus::Open)->count(),
            'in_progress' => (clone $baseQuery)->where('status', TicketStatus::InProgress)->count(),
            'closed' => (clone $baseQuery)->where('status', TicketStatus::Closed)->count(),
        ];

        $tickets = Ticket::with('customer')->where('agent_id', $agent->id)->latest()->take(10)->get();

        return view('agent.agentdashboard', compact('stats', 'tickets'));
    }

    public function ticketIndex(Request $request)
    {
        $agent = $request->user();
        if (!$agent->isAgent()) {
            abort(403, 'Unauthorized');
        }

        $tickets = Ticket::with('customer')->where('agent_id', $agent->id)->latest()->paginate(10);

        return view('agent.agentTicketIndex', compact('tickets'));
    }

    public function ticketDetails(Ticket $ticket){
        $this->authorize('view', $ticket);

        return view('agent.ticketDetails', compact('ticket'));
    }
}
