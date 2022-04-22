<?php

namespace App\Card;

use App\Card\Card;

class Hand
{

    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }


    public function drawCardArray(): array
    {
        $to_return = [];


        foreach ($this->hand as $cards) {

            $to_return[] = [$cards->getSuit() => $cards->getValue()];
        }

        return $to_return;

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
}
