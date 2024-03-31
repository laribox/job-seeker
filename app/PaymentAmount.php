<?php

namespace App;

enum PaymentAmount
{
    case WEEKLY;
    case MONTHLY;
    case YEARLY;

    /**
     * Returns the amount based on the current instance value.
     *
     * @return string The amount as a string.
     */
    public function amout(): string
    {
        return match ($this) {
            self::WEEKLY => 20,
            self::MONTHLY => 80,
            self::YEARLY => 100,
        };
    }
}
