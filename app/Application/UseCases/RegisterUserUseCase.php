<?php

namespace App\Application\UseCases;

use App\Domain\Entities\UserEntity;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    public function execute(string $name, string $email, string $password): UserEntity
    {
        $hashedPassword = Hash::make($password);

        $user = new UserEntity(
            Str::uuid()->toString(),
            $name,
            $email,
            $hashedPassword
        );

        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();

        $user->setGoogle2FASecret($secret);

        // Save user as usual via repository
        $this->userRepo->create($user);

        // Optionally return QR code URL for the user to scan:
        $qrUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->getEmail(),
            $secret
        );

        return $this->userRepo->create($user);
    }
}
