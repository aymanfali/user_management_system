<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Entities\UserEntity;

class UpdateUserUseCase
{
    private UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function execute(string $id, string $name, string $email): ?UserEntity
    {
        $user = $this->userRepo->findById($id);
        if (!$user) return null;

        $user->changeName($name);
        $user->changeEmail($email);

        return $this->userRepo->update($user);
    }
}
