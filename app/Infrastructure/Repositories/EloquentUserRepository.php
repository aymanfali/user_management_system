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
        $user->id       = $entity->getId();         // optional if DB generates
        $user->name     = $entity->getName();
        $user->email    = $entity->getEmail();
        $user->password = $entity->getPassword();   // already hashed
        $user->save();

        // Return a new UserEntity with DB-generated data
        return new UserEntity(
            $user->id,
            $user->name,
            $user->email,
            $user->password
        );
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $user = User::where('email', $email)->first();
        if (!$user) return null;

        return new UserEntity(
            $user->id,
            $user->name,
            $user->email,
            $user->password
        );
    }

    public function findById(string $id): ?UserEntity
    {
        $user = User::find($id);
        if (!$user) return null;

        return new UserEntity(
            $user->id,
            $user->name,
            $user->email,
            $user->password
        );
    }

    public function update(UserEntity $entity): UserEntity
    {
        $user = User::findOrFail($entity->getId());
        $user->name     = $entity->getName();
        $user->email    = $entity->getEmail();
        $user->password = $entity->getPassword();
        $user->save();

        return new UserEntity(
            $user->id,
            $user->name,
            $user->email,
            $user->password
        );
    }
}
