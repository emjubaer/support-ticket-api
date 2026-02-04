<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Open = 'open';
    case InProgress = 'in_progress';
    case Resolved = 'resolved';
    case Closed = 'closed';

    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }

    //to show the string value in blades
    public function label(): string
    {
        return match ($this) {
            TicketStatus::Open => 'Open',
            TicketStatus::InProgress => 'In Progress',
            TicketStatus::Resolved => 'Resolved',
            TicketStatus::Closed => 'Closed',
        };
    }
}
