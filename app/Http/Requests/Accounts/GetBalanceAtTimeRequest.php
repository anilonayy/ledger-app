<?php

namespace App\Http\Requests\Accounts;

use App\Enums\DateFormatEnums;
use App\Enums\DateTimeEnums;
use App\Http\Requests\Request;

class GetBalanceAtTimeRequest extends Request
{
    public function rules(): array
    {
        return [
            'date' => "required|date|date_format:".DateTimeEnums::ISO8601,
            'account_id' => 'sometimes|integer|exists:accounts,id',
        ];
    }
}
