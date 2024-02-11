<?php

namespace App\Services\User;

interface UserServiceInterface
{

    /**
     * @param object $payload
     * @return array
     */
    public function store(object $payload): array;
}
