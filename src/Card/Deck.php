<?php

namespace App\Card;

use App\Card\Card;
use App\Card\Hand;

class Deck extends Hand
{

    public function shuffleDeck(): void
    {
        shuffle($this->deck);
    }

    public function sortDeck(): void
    {
        asort($this->deck);
    }

    public function drawCardArray(int $number = 1): array
    {
        $to_return = [];

        for ($i = 0; $i < $number; $i++)
        {
            $card = array_pop($this->deck);

            $to_return[] = [$card->getSuit() => $card->getValue()];

        }

        return $to_return;

    }

    public function poppedArrayCards(int $number = 1): array
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

}
