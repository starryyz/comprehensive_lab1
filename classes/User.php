<?php
    //star
    class User{
        protected string $name;
        protected string $email;

        public function __construct(string $name, string $email){
            $this->name = $name;
            $this->email = $email;
        }

        public function viewProfile(): string{
            return "Name: {$this->name}, Email: {$this->email}";
        }
    }

?>
