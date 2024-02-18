<?php

namespace App\Enums;

enum TransactionTypeEnums: string
{
    case CREDIT = 'credit';
    case TRANSFER = 'transfer';
    const WITHDRAW = 'withdraw';
}
