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


    public function showCardsArray(): array
    {
        $to_return = [];


        foreach ($this->hand as $cards) 
        {
            $to_return[] = [$cards->getSuit() => $cards->getValue()];
        }

        return $to_return;

    }

}
