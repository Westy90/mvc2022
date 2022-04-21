<?php

namespace App\Card;

use App\Card\Card;

class Deck
{

    private $deck = [];



    public function add(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function getAllCards(): string
    {

        $to_return = "|";

        foreach ($this->deck as $card)
        {

            $value = strval($card->getValue());

            if ($value == "1")
            {
                $value = "ace";
            }
            elseif ($value == "11")
            {
                $value = "jack";
            }
            elseif ($value == "12")
            {
                $value = "queen";
            }
            elseif ($value == "13")
            {
                $value = "king";
            }

            $to_return .= " " . $card->getSuit() . " " . $value . " |";
        }

        return $to_return;

    }

    public function shuffleDeck(): void
    {
        shuffle($this->deck);
    }



    /*public function __construct()
    {
        $this->current_deck = self::deck;
    }*/

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
