<?php

namespace App\Card;

use App\Card\Hand;

class Player
{
    public $hand;


    public function __construct()
    {
        $this->hand = new Hand();
    }


    public function add($cards): void
    {
        foreach ($cards as $card) {
            $this->hand->add($card);
        }
    }

    public function showCardsArray(): array
    {
        return $this->hand->showCardsArray();
    }

    public function getSumArray(): array
    {
        return $this->hand->getSumArray();
    }
}
