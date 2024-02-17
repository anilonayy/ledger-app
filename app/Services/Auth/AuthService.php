<?php

namespace App\Services\Auth;

use App\Enums\ResponseMessageEnums;
use App\Http\Resources\User\UserResource;
use App\Models\Role;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly RoleRepositoryInterface $roleRepository,
        private readonly AuthRepositoryInterface $authRepository,
    ){}

    /**
     * @param object $payload
     * @return array
     */
    public function login(object $payload): array
    {
        $user = $this->userRepository->getUserByEmail($payload->email);

        if (!$user->id || !Hash::check($payload->password, $user->password)) {
            throw new UnauthorizedHttpException('', ResponseMessageEnums::WRONG_CREDENTIAL,
                code:Response::HTTP_UNAUTHORIZED);
        }

        return [
            'token' => $this->authRepository->getToken($user, $payload->device),
            'user' => UserResource::make($user)
        ];
    }

    /**
     * @param object $payload
     * @return array
     */
    public function register(object $payload): array
    {
        $user = $this->userRepository->create($payload);
        $this->roleRepository->assignRole($user, $this->roleRepository->getRoleByName('user'));

        return [
            'token' => $this->authRepository->getToken($user, $payload->device),
            'user' => $user
        ];
    }
}
