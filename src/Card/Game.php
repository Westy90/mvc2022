<?php

namespace App\Card;

use App\Card\Card;

class Game
{
    public $deckArray = [
        'clubs' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        'diamonds' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        'hearts' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        'spades' => [1,2,3,4,5,6,7,8,9,10,11,12,13]
    ];

    public $deck;

    public $player = []; //Banken är index 0

    public function addDeck($deck): void
    {
        $this->deck = $deck;

        foreach ($this->deckArray as $suit=>$values) {
            foreach ($values as $value) {
                $deck->add(new \App\Card\Card($suit, $value));
            }
        }
    }

    public function addPlayer($player): void
    {
        $this->player[] = $player;
    }


    public function drawCard(): Card
    //Returnerar ett kort
    {
        return $this->deck->drawCard();
    }

    public function dealCards($number, $player): void
    {
        for ($i = 0; $i < $number; $i++) {
            $this->player[$player]->add([$this->deck->drawCard()]); //Behöver vara array
        }
    }

    public function showCardsArray($player): array
    {
        return $this->player[$player]->showCardsArray();
    }

    public function getSumArray($player): array
    {
        return $this->player[$player]->getSumArray();
    }



    public function getPlayerDataArray(): array
    {
        $playerData = [];

        for ($i = 0; $i < count($this->player) - 1; $i++) {
            $playerData[$i]["cardsArray"] = $this->player[$i]->showCardsArray();
            $playerData[$i]["sumArray"] = $this->player[$i]->getSumArray();
        }

        return $playerData;
    }


    public function checkPlayerCards(): string
    {
        $to_return = "";

        if ($this->getSumArray(1)[0] > 21 and $this->getSumArray(1)[1] > 21) {
            $to_return = "lost";
        } elseif ($this->getSumArray(1)[0] == 21 or $this->getSumArray(1)[1] == 21) {
            $to_return = "won";
        }

        return $to_return;
    }

    public function computerPlay(): string
    {
        $this->dealCardsComputer();

        return $this->evaluate();
    }

    public function dealCardsComputer(): void
    {
        while ($this->getSumArray(0)[0] < 17 or $this->getSumArray(0)[1] < 17) {
            $this->dealCards(1, 0);
        }
    }

    public function evaluate(): string
    {
        if ($this->getSumArray(0)[0] > 21 and $this->getSumArray(0)[1] > 21) {
            return "won";
        } else {
            if ($this->getSumArray(0)[1] > 21) {
                $computerBestScore = $this->getSumArray(0)[0];
            } else {
                $computerBestScore = $this->getSumArray(0)[1];
            }

            if ($this->getSumArray(1)[1] > 21) {
                $userBestScore = $this->getSumArray(1)[0];
            } else {
                $userBestScore = $this->getSumArray(1)[1];
            }

            if ($userBestScore > $computerBestScore) {
                return "won";
            }

            return "lost";
        }
    }
}
