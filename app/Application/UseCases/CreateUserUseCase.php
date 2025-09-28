<?php

namespace App\Application\UseCases;

use App\Domain\Entities\UserEntity;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Str;

class CreateUserUseCase
{
    private UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function execute(string $name, string $email): UserEntity
    {
        $user = new UserEntity(Str::uuid()->toString(), $name, $email);
        return $this->userRepo->create($user);
    }
}
