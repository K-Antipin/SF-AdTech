<?php

namespace App\Models;

use App\Kernel\Auth\User;

class Offer
{
    public function __construct(
        private int $id,
        private string $name,
        private string $description,
        private float $price,
        private string $url,
        private string $active,
        private string $ban,
        private string $createdAt,
        private array $subscribers = [],
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function price(): int|float
    {
        return $this->price;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function isActive(): bool
    {
        return (bool) $this->active;
    }

    public function ban(): bool
    {
        return (bool) $this->ban;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return array<Subscribe>
     */
    public function subscribers(): array
    {
        return $this->subscribers;
    }
}
