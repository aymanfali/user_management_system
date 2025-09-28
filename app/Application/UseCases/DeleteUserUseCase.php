<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\UserRepositoryInterface;

class DeleteUserUseCase
{
    private UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function execute(string $id): void
    {
        $this->userRepo->delete($id);
    }
}
