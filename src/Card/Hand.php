<?php

namespace App\Card;

use App\Card\Card;

class Hand
{

    public $deck = [];

    public function add(Card $card): void
    {
        $this->deck[] = $card;
    }

    public function showCardsArray(): array
    {
        $to_return = [];


        foreach ($this->deck as $cards)
        {
            $to_return[] = [$cards->getSuit() => $cards->getValue()];
        }

        return $to_return;

    }


}
