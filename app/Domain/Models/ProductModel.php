<?php

declare(strict_types=1);

namespace App\Domain\Models;

final readonly class ProductModel
{
    public function __construct(
        private string $id,
        private string $name,
        private int $price,
        private string $currency
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

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
