<?php

namespace App\Card;

use App\Card\Card;

class Hand
{
    public $deck = [];
    public $sum1 = 0; //Summa om ess räknas som 1
    public $sum14 = 0; //Summa om ess räknas som 13

    public function add(Card $card): void
    {
        $this->deck[] = $card;

        if ($card->getValue() == 1) {
            $this->sum1 += 1;
            $this->sum14 += 14;
        } else {
            $this->sum1 += $card->getValue();
            $this->sum14 += $card->getValue();
        }
    }

    public function getSumArray(): array
    {
        return [$this->sum1, $this->sum14];
    }

    public function showCardsArray(): array
    // Funktion som visar vilka kort som finns i $deck
    {
        $to_return = [];

        foreach ($this->deck as $cards) {
            // Tidigare:
            $to_return[] = [$cards->getSuit() => $cards->getValue()];
            //$to_return[] = [$cards->getSuit(), $cards->getValue()];
        }

        return $to_return;
    }
}
