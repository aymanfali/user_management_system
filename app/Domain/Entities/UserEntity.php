<?php

namespace App\Domain\Entities;

class UserEntity
{
    private string $id;
    private string $name;
    private string $email;

    public function __construct(string $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function changeName(string $name): void
    {
        if (strlen($name) < 3) {
            throw new \InvalidArgumentException("Name must be at least 3 characters long.");
        }
        $this->name = $name;
    }

    public function changeEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email format.");
        }
        $this->email = $email;
    }
}
