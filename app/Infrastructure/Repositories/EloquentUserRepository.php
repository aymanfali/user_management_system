<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\UserEntity;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function create(UserEntity $entity): UserEntity
    {
        $user = new User();
        $user->id    = $entity->getId();
        $user->name  = $entity->getName();
        $user->email = $entity->getEmail();
        $user->save();

        return new UserEntity($user->id, $user->name, $user->email);
    }

    public function findById(string $id): ?UserEntity
    {
        $user = User::find($id);
        return $user ? new UserEntity($user->id, $user->name, $user->email) : null;
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $user = User::where('email', $email)->first();
        return $user ? new UserEntity($user->id, $user->name, $user->email) : null;
    }

    public function all(): array
    {
        return User::all()
            ->map(fn($user) => new UserEntity($user->id, $user->name, $user->email))
            ->toArray();
    }

    public function update(UserEntity $entity): UserEntity
    {
        $user = User::findOrFail($entity->getId());
        $user->name  = $entity->getName();
        $user->email = $entity->getEmail();
        $user->save();

        return new UserEntity($user->id, $user->name, $user->email);
    }

    public function delete(string $id): void
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
