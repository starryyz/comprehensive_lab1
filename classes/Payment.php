<?php
// star 
abstract class Payment
{
    protected float $amount;

    public function __construct(float $amount)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Payment amount cannot be negative.');
        }

        $this->amount = $amount;
    }

    abstract public function processPayment(): string;

    public function getAmount(): float
    {
        return $this->amount;
    }
}

function processAnyPayment(Payment $payment): string
{
    return $payment->processPayment();
}