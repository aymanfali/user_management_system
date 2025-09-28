<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\UserEntity;

interface UserRepositoryInterface
{
    public function create(UserEntity $entity): UserEntity;

    public function findById(string $id): ?UserEntity;
    public function findByEmail(string $email): ?UserEntity;

    public function all(): array;

    public function update(UserEntity $entity): UserEntity;

    public function delete(string $id): void;
}
