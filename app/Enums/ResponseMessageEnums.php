<?php

namespace App\Enums;

final class ResponseMessageEnums
{
    const SERVER_ERROR = 'An error occurred on the server! Please try again later!';
    const OK = 'Ok';
    const CREATED = 'Created';
    const ACCEPTED = 'Accepted';
    const BAD_REQUEST = 'Bad Request';
    const UNAUTHORIZED = 'Unauthorized';
    const FORBIDDEN = 'Forbidden';
    const NOT_FOUND = 'Not Found';
    const WRONG_CREDENTIAL = 'There is no user with this email or password!';
    const INVALID_PAYLOAD = 'Invalid Payload!';
}
