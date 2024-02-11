<?php

namespace App\Services\Auth;

use App\Enums\ResponseMessageEnums;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService implements AuthServiceInterface
{

    /**
     * @param object $payload
     * @return array
     */
    public function login(object $payload): array
    {
        $user = User::where('email', $payload->email)->first();

        if (!$user || !Hash::check($payload->password, $user->password)) {
            throw new UnauthorizedHttpException('', ResponseMessageEnums::WRONG_CREDENTIAL,
                code:Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => UserResource::make($user)
        ];
    }

    /**
     * @param object $payload
     * @return array
     */
    public function register(object $payload): array
    {
        $user = User::create([
            'name' => $payload->name,
            'email' => $payload->email,
            'password' => Hash::make($payload->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => UserResource::make($user)
        ];
    }
}
