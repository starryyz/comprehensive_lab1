<?php

require_once "Payment.php";

class CreditCardPayment extends Payment
{
    private string $cardNumber;

    public function __construct(float $amount, string $cardNumber)
    {
        parent::__construct($amount);
        $this->cardNumber = $cardNumber;
    }

    public function processPayment(): string
    {
        return '[Credit Card] Payment of $' . number_format($this->amount, 2) . ' has been processed.';
    }
}


