<?php

namespace App\Domain\Entities;

class UserEntity
{
    private string $id;
    private string $name;
    private string $email;
    private string $password; // hashed password
    private ?string $google2faSecret;

    public function __construct(string $id, string $name, string $email, string $password, ?string $google2faSecret = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->google2faSecret = $google2faSecret;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    // ✅ Setters / Business rules
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

    public function changePassword(string $hashedPassword): void
    {
        if (strlen($hashedPassword) === 0) {
            throw new \InvalidArgumentException("Password cannot be empty.");
        }
        $this->password = $hashedPassword;
    }

    public function getGoogle2FASecret(): ?string
    {
        return $this->google2faSecret;
    }

    public function setGoogle2FASecret(string $secret): void
    {
        $this->google2faSecret = $secret;
    }
}
