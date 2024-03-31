<?php

namespace App;

enum PaymentAmount
{
    case WEEKLY;
    case MONTHLY;
    case YEARLY;

    public function name(): string
    {
        return match ($this) {
            self::WEEKLY => 20,
            self::MONTHLY => 80,
            self::YEARLY => 100,
        };
    }
}
