<?php

class Booking
{
    private Member $member;
    private FitnessClass $fitnessClass;
    private string $bookingStatus;
    private float $paymentAmount;

    public function __construct(Member $member, FitnessClass $fitnessClass)
    {
        $this->member = $member;
        $this->fitnessClass = $fitnessClass;
        $this->bookingStatus = 'Pending';
        $this->paymentAmount = $fitnessClass->getPrice();
    }

    public function confirmBooking(): bool
    {
        if ($this->bookingStatus === 'Confirmed') {
            return true;
        }

        if (!$this->fitnessClass->reserveSpot()) {
            return false;
        }

        $this->bookingStatus = 'Confirmed';
        return true;
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    public function getFitnessClass(): FitnessClass
    {
        return $this->fitnessClass;
    }

    public function getBookingStatus(): string
    {
        return $this->bookingStatus;
    }

    public function getPaymentAmount(): float
    {
        return $this->paymentAmount;
    }
}
