<?php

namespace App\Enums;

//'status', ['pending','processing' , 'completed', 'canceled']

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
}
