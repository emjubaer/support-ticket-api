<?php

namespace App\Services;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;

class TicketService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createTicket(User $user, string $subject)
    {

        $ticket =  Ticket::create([
            'user_id' => $user->id,
            'subject' => $subject,
            'priority' => TicketPriority::Low,
            'status' => TicketStatus::Open
        ]);

        return $ticket;
    }
}
