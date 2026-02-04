<?php

namespace App\Enums;

enum TicketPriority: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public static function values(): array{
        return array_column(static::cases(), 'value');
    }

    //to show the string value in blades
    public function label(): string{
        return match($this){
            TicketPriority::Low => 'Low',
            TicketPriority::Medium => 'Medium',
            TicketPriority::High => 'High',
        };
    }
}
