<?php

declare(strict_types=1);

namespace App\Domain\Models;

class CompanyModel
{
    public function __construct(
        private string $id,
        private string $name,
        private string $streetAddress,
        private string $city,
        private string $zip,
        private string $phone,
        private string $email
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
