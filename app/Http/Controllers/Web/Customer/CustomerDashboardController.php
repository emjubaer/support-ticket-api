<?php

namespace App\Http\Controllers\Web\Customer;

use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddMessageRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Mail\AdminTicketCreateMail;
use App\Mail\CustomerTicketCreateMail;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CustomerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $customer = $request->user();

        // Security Check
        //if (!$customer->isCustomer()) {
       //     abort(403, 'Unauthorized');
      //  }

        // Base Query (customer specific tickets)
        $baseQuery = Ticket::where('user_id', $customer->id);

        // Ticket Statistics
        $stats = [
            'total' => (clone $baseQuery)->count(),

            'open' => (clone $baseQuery)
                ->where('status', TicketStatus::Open)
                ->count(),

            'in_progress' => (clone $baseQuery)
                ->where('status', TicketStatus::InProgress)
                ->count(),

            'closed' => (clone $baseQuery)
                ->where('status', TicketStatus::Closed)
                ->count(),
        ];

        // Latest Tickets (last 10)
        $tickets = Ticket::with('agent')
            ->where('user_id', $customer->id)
            ->latest()
            ->take(10)
            ->get();

        return view('customer.customerDashboard', compact('stats', 'tickets'));
    }

     public function ticketIndex(Request $request)
    {
        $customer = $request->user();
        // if (!$customer->isCustomer()) {
        //     abort(403, 'Unauthorized');
        // }

        $tickets = Ticket::with('agent')->where('user_id', $customer->id)->latest()->paginate(10);

        return view('customer.customerTicketIndex', compact('tickets'));
    }

    public function ticketDetails(Ticket $ticket){
        // $this->authorize('view', $ticket);

        return view('customer.ticketDetails', compact('ticket'));
    }

    public function createTicket(StoreTicketRequest $request, TicketService $ticketService){
        $ticket = $ticketService->createTicket(
            $request->subject,
            $request->user(),
            $request->message
        );
        // dd($ticket->messages->first()->message);
        // dd($request->user()->email);
        // Mail::to($request->user()->email)->send(new CustomerTicketCreateMail($ticket));
        $admin = User::admins()->first();
        Mail::to($admin->email)->send(new AdminTicketCreateMail($ticket));



        return redirect()->route('customer.ticket.show', $ticket)->with('success', 'Ticket created successfully');
        }



public function store(AddMessageRequest $request, Ticket $ticket, TicketService $ticketService)
    {
        $message = $ticketService->addMessageToTicket(
            $ticket,
            $request->user(),
            $request->message
        );

        return redirect()->route('customer.ticket.show', $ticket);
    }

}
