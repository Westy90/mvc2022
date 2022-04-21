<?php

namespace App\Card;

class Card
{

    public $suit = "";
    public $value = 0;


    public function __construct(string $suit, int $value)
    {
        $this->suit = $suit;
        $this->value = $value;
    }

    public function getSuit(): string
    {

        return $this->suit;


    }

    public function getValue(): int
    {

        return $this->value;

    }

    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
