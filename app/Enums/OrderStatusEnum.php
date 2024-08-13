<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case UNPAID = 'unpaid';
    case PAID = 'paid';
    case PREPARING = 'preparing';
    case ON_THE_WAY = 'on_the_way';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

}
