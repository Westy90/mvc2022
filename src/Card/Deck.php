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

            $to_return .= $this->add_cards_print($card);
        }

        return $to_return;

    }

    protected function add_cards_print($card): string
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

        return " " . $card->getSuit() . " " . $value . " |";

    }

    public function shuffleDeck(): void
    {
        shuffle($this->deck);
    }

    public function drawCard(int $number = 1): string
    {

        $to_return = "|";

        for ($i = 0; $i < $number; $i++)
        {
            $card = array_pop($this->deck);

            $to_return .= $this->add_cards_print($card);

        }

        return $to_return;
    }

    public function drawCardArray(int $number = 1): array
    {
        $to_return = [];

        for ($i = 0; $i < $number; $i++)
        {
            $card = array_pop($this->deck);

            $to_return[] = $card;

        }

        return $to_return;

    }




    public function remainingCards(): int
    {
        return count($this->deck);
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
