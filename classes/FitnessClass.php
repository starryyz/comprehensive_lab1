<?php

class FitnessClass
{
    private string $className;
    private Trainer $trainer;
    private float $price;
    private int $capacity;
    private int $availableSpots;

    public function __construct(
        string $className,
        Trainer $trainer,
        float $price,
        int $capacity
    ) {
        if ($price < 0 || $capacity < 0) {
            throw new InvalidArgumentException('Price and capacity cannot be negative.');
        }

        $this->className = $className;
        $this->trainer = $trainer;
        $this->price = $price;
        $this->capacity = $capacity;
        $this->availableSpots = $capacity;
    }

    public function isAvailable(): bool
    {
        return $this->availableSpots > 0;
    }

    public function reserveSpot(): bool
    {
        if (!$this->isAvailable()) {
            return false;
        }

        $this->availableSpots--;
        return true;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getTrainer(): Trainer
    {
        return $this->trainer;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getAvailableSpots(): int
    {
        return $this->availableSpots;
    }
}
