<?php

namespace App\Policies\V1\Tickets;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Ticket $ticket): bool
    {
        // TODO can add token level permissions here, like: $user->tokenCan('ticket.update')
        return $user->id === $ticket->user_id;
    }

    public function replace(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    public function destroy(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }
}
