<?php

namespace App\Http\Requests\Shared;

use App\Http\Requests\Request;
use Illuminate\Validation\Rules\RequiredIf;

class AllWithFilterRequest extends Request
{
    public function rules(): array
    {
        return [
            'page' => 'sometimes|numeric|min:0',
            'take' => 'sometimes|numeric|min:0|max:100',
            'sort' => 'sometimes|string',
            'order' => ['sometimes', 'string', new RequiredIf(!!$this->sort)],
        ];
    }
}
