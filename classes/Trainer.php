<?php
require_once "User.php";

class Trainer extends User{
    public function __construct(string $name, string $email){
        parent::__construct($name, $email);
    }

    public function leadClass(): string{
        return "Trainer {$this->name} is leading the class.";
    }

}
?>
