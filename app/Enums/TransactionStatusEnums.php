<?php

namespace App\Enums;

enum TransactionStatusEnums: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case CANCELLED = 'cancelled';
}
