<?php
    // star
    abstract class Payment{
        protected float $amount;

        public function __construct(float $amount){
            $this->amount = $amount;
        }
        
        abstract  function processPayment(): string;
    }


?>