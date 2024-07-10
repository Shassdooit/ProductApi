<?php

namespace App\Enums;

enum OrderStatusEnum
{
    const PROCESSING = 'processing';
    const PREPARING = 'preparing';
    const ON_THE_WAY = 'on_the_way';
    const DELIVERED = 'delivered';
    const CANCELLED = 'cancelled';
    public static function getValues(): array
    {
        return [
            self::PROCESSING,
            self::PREPARING,
            self::ON_THE_WAY,
            self::DELIVERED,
            self::CANCELLED,
        ];
    }
}
