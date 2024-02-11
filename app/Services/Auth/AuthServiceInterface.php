<?php

namespace App\Services\Auth;

interface AuthServiceInterface
{
    /**
     * @param object $payload
     * @return array
     */
    public function login(object $payload): array;

    /**
     * @param object $payload
     * @return array
     */
    public function register(object $payload): array;
}
