<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\UserEntity;

interface UserRepositoryInterface
{

    public function create(UserEntity $user): UserEntity;

    public function findByEmail(string $email): ?UserEntity;

    public function findById(string $id): ?UserEntity;

    public function update(UserEntity $user): UserEntity;
}
