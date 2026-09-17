<?php
// ellie
class Trainer{
    protected string $name;
    protected string $email;

    public function __construct(string $name, string $email){
        $this->name = $name;
        $this->email = $email;
    }

    public function leadClass(): string{
        return "Trainer {$this->name} is leading the class.";
    }

    public function viewProfile(): string{
        return "Name: {$this->name}, Email: {$this->email}";
    }
}
?>
