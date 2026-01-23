<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TicketStatus;
use App\Enums\TicketPriority;

class Ticket extends Model
{
    protected $casts = [
        'closed_at' => 'datetime',
        'status' => TicketStatus::class,
        'priority' => TicketPriority::class,

    ];

    protected $fillable = [
        'user_id',
        'agent_id',
        'subject',
        'priority',
        'status',
        'closed_at',
    ];

    // Relationships
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }


    // Helpers
    public function isOpen(): bool
    {
        return $this->status === TicketStatus::Open;
    }

    public function isInProgress(): bool
    {
        return $this->status === TicketStatus::InProgress;
    }
    public function isResolved(): bool
    {
        return $this->status === TicketStatus::Resolved;
    }
    public function isClosed(): bool
    {
        return $this->status === TicketStatus::Closed;
    }
}
