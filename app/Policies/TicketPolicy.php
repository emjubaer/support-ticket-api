<?php

namespace App\Policies;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isAgent() || $user->isCustomer();
    }

    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->isAdmin() || $user->isAgent()) {
            return true;
        }
        return $ticket->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isCustomer();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateStatus(User $user, Ticket $ticket, string $newStatus): bool
    {
        return $user->isAdmin() || $user->isAgent() && $ticket->canChangeToStatus(TicketStatus::from($newStatus));
    }

    public function assignAgent(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin();
    }

    public function addMessage(User $user, Ticket $ticket): bool
    {
        if ($ticket->isClosed()) return false;

        if ($user->isAdmin() || $user->isAgent()) return true;

        return $ticket->user_id === $user->id;
    }

}
