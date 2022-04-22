<?php

namespace App\Card;

use App\Card\Hand;

class Player
{

    private $hand;


    function __construct()
    {
        $this->hand = new Hand();

    }


    public function add($cards): void
    {

        foreach ($cards as $card)
        {
            $this->hand->add($card);
        }

    }

    public function getCardsArray(): array {

        return $this->hand->drawCardArray();
    }



    //Ta bort nedan..

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
