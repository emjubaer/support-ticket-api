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
}
