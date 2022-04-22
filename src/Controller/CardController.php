<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card-home")
     */
    public function home( SessionInterface $session ): Response
    {
        $die = new \App\Dice\Dice();

        $data = [
            'title' => 'Card Deck - Home',
        ];

        $session->set("deck", NULL);

        //Funkar denna även när session är rensad? Blir den null då?
        if ($session->get("deck") == NULL) {
            $deck = new \App\Card\Deck();

            $playing_deck = [
                'clubs' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
                'diamonds' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
                'hearts' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
                'spades' => [1,2,3,4,5,6,7,8,9,10,11,12,13]
            ];

            foreach ($playing_deck as $suit=>$values) {

                foreach ($values as $value) {

                    $deck->add(New \App\Card\Card($suit, $value));

                }
            }
            $session->set("deck", $deck);
        }


        //Skapa kortleken i denna vy? (utan att visa den)
        return $this->render('card/home.html.twig', $data);
    }

    /**
     * @Route("/card/deck", name="card-deck")
     */
    public function deck(SessionInterface $session ): Response
    {

        $deck = $session->get("deck");

        $data = [
            'title' => 'Deck',
            'printed_cards' => $deck->getAllCards()
        ];

        return $this->render('card/deck.html.twig', $data);
    }


    /**
     * @Route("/card/deck/shuffle", name="card-deck-shuffle")
     */
    public function shuffle(SessionInterface $session ): Response
    {


        $deck = $session->get("deck");

        $deck->shuffleDeck();

        $data = [
            'title' => 'Deck',
            'printed_cards' => $deck->getAllCards()
        ];

        $session->set("deck", $deck);


        return $this->render('card/deck.html.twig', $data);
    }


    /**
     * @Route("/card/deck/draw/{number}", name="card-deck-draw")
     */
    public function draw(
        SessionInterface $session,
        int $number = 1
    ): Response
    {

        $deck = $session->get("deck");

        $drawn_card = $deck->drawCard($number);

        $data = [
            'title' => 'Deck',
            'draw_card' => $drawn_card,
            'remaining_cards' => $deck->remainingCards()
        ];

        $session->set("deck", $deck);

        return $this->render('card/draw.html.twig', $data);
    }





    /**
     * @Route("card/deck/deal/{players}/{cards}", name="card-deck-deal")
     */
    public function deal(
        SessionInterface $session,
        int $players = 1,
        int $cards = 1
    ): Response
    {
        $player = [];
        $playerCards = [];

        $deck = $session->get("deck");

        for ($i = 0; $i < $players; $i++)
        {

            $player[$i] = new \App\Card\Player();
            $card = $deck->drawCardArray($cards);
            $player[$i]->add($card);

            $playerCards[$i] = $player[$i]->getCardsArray();

        }



        #$playerCards = [["katt", "häst"], ["hund", "elefant"]];

        //$drawn_card = $deck->drawCard($number);

        $data = [
            'title' => 'Deck',
            'playercards' => $playerCards,
            'remaining_cards' => $deck->remainingCards()
        ];

        $session->set("deck", $deck);

        return $this->render('card/deal.html.twig', $data);
    }

}
