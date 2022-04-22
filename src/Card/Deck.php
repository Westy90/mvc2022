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

    public function showCardsArray(): array
    {
        $to_return = [];


        foreach ($this->deck as $cards)
        {
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
