<?php
// Ellie
require_once "User.php";

class Member extends User{
    public function __construct(string $name, string $email){
        parent::__construct($name, $email);
    }

    public function bookClass(): string{
        return "Member {$this->name} booked a class.";
    }

}
?>
