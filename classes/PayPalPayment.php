<?php
// star
require_once "Payment.php";

class PayPalPayment extends Payment
{
    private string $email;

    public function __construct(float $amount, string $email)
    {
        parent::__construct($amount);
        $this->email = $email;
    }

    public function processPayment(): string
    {
        return '[PayPal] Payment of $' . number_format($this->amount, 2) . ' has been processed.';
    }
}