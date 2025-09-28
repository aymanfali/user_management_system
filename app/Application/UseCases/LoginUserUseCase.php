<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PragmaRX\Google2FA\Google2FA;

class LoginUserUseCase
{
    private UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function execute(string $email, string $password, string $oneTimePassword): array
    {
        $user = $this->userRepo->findByEmail($email);

        if (!$user || !Hash::check($password, $user->getPassword())) {
            Log::warning('Failed login attempt', [
                'email' => $email,
                'ip'    => request()->ip(),
            ]);

            throw new \Exception('Invalid credentials');
        }

        // Validate 2FA
        $google2fa = new Google2FA();
        if (!$google2fa->verifyKey($user->getGoogle2FASecret(), $oneTimePassword)) {
            Log::warning('Failed 2FA attempt', [
                'user_id' => $user->getId(),
                'ip'      => request()->ip(),
            ]);

            throw new \Exception('Invalid 2FA code');
        }

        // Issue Sanctum token
        $sanctumUser = \App\Models\User::find($user->getId());
        $token = $sanctumUser->createToken('auth_token')->plainTextToken;

        Log::info('User logged in', [
            'user_id' => $user->getId(),
            'ip'      => request()->ip(),
        ]);

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }
}
