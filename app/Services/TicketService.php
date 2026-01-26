<?php

namespace App\Services;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class TicketService
{
    public function createTicket(
        string $subject,
        User $user,
        string $message
    ): Ticket {
        return DB::transaction(function () use ($user, $subject, $message) {
            // $ticket =  Ticket::create([
            //     'user_id' => $user->id,
            //     'subject' => $subject,
            //     'priority' => TicketPriority::Low,
            //     'status' => TicketStatus::Open
            // ]);

            $ticket = $user->tickets()->create([
                'subject' => $subject,
                'priority' => TicketPriority::Low,
                'status' => TicketStatus::Open
            ]);

            // TicketMessage::create([
            //     'ticket_id' => $ticket->id,
            //     'user_id' => $user->id,
            //     'message' => $message,
            // ]);

            $ticket->messages()->create([
                'user_id' => $user->id,
                'message' => $message,
            ]);

            return $ticket->load('messages');
        });
    }

    public function addMessageToTicket(
        Ticket $ticket,
        User $user,
        string $message
    ) {
        return $ticket->messages()->create([
            'user_id' => $user->id,
            'message' => $message,
        ]);
    }
    public function updateStatus(Ticket $ticket, string $newStatus): bool
    {
        return $ticket->update([
            'status' => $newStatus,
            'closed_at' => TicketStatus::from($newStatus) === TicketStatus::Closed ? now() : null,
        ]);
    }

    public function assignAgentToTicket(Ticket $ticket, int $id){
        

        $ticket->update([
            'agent_id' => $id,
        ]);
    }
}
