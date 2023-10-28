<?php

namespace App\Models;

use App\Models\Offer;

class Subscribe
{
    public function __construct(
        private int $id,
        private int $userId,
        private int $offerId,
        private string $name,
        private float $price,
        private string $url,
        private string $hash,
        private string $active,
        private string $ban,
        private string $createdAt,
        private string $updatedAt,
        private ?Offer $offer
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function offerId(): string
    {
        return $this->offerId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): float
    {
        return $this->price;
    }
    
    public function url(): string
    {
        return $this->url;
    }

    public function hash(): string
    {
        return $this->hash;
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

    public function offer(): ?Offer
    {
        return $this->offer;
    }
}