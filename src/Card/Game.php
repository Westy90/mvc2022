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

                $deck->add(New \App\Card\Card($suit, $value));
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

        for ($i = 0; $i < $number; $i++)
        {
            $this->player[$player]->add([$this->deck->drawCard()]); //Behöver vara array
        }

    }

    public function showCardsArray($player): array
    {

        return $this->player[$player]->showCardsArray();
    }


    /*
    public function showCardsArray(): array
    {
        $to_return = [];


        foreach ($this->deck as $cards)
        {
            $to_return[] = [$cards->getSuit() => $cards->getValue()];
        }

        return $to_return;

    }
    */

}

/*
public function new(SessionInterface $session ): Response
{

$data = [
    'title' => 'Card Deck - Home - Deck is resetted!',
];

$deck = new \App\Card\Deck();



foreach ($playing_deck as $suit=>$values) {

    foreach ($values as $value) {

        $deck->add(New \App\Card\Card($suit, $value));

    }
}
$session->set("deck", $deck);

return $this->render('card/home.html.twig', $data);
}
*/

