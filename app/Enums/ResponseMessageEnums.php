<?php

namespace App\Enums;

final class ResponseMessageEnums
{
    const OK = 'Ok';
    const WRONG_CREDENTIAL = 'There is no user with this email or password!';
    const INVALID_PAYLOAD = 'Invalid Payload!';
}
