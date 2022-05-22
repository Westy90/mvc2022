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
    public function home(SessionInterface $session): Response
    {
        $die = new \App\Dice\Dice();

        $data = [
            'title' => 'Card Deck - Home',
        ];

        //$session->set("deck", NULL);

        if ($session->get("deck") == null) {
            return $this->redirectToRoute("card-deck-new");
        }

        return $this->render('card/home.html.twig', $data);
    }

    /**
     * @Route("/card/deck/new", name="card-deck-new")
     */
    public function new(SessionInterface $session): Response
    {
        $data = [
        'title' => 'Card Deck - Home - Deck is resetted!',
        ];

        $deck = new \App\Card\Deck();

        $playing_deck = [
        'clubs' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        'diamonds' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        'hearts' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        'spades' => [1,2,3,4,5,6,7,8,9,10,11,12,13]
        ];

        foreach ($playing_deck as $suit => $values) {
            foreach ($values as $value) {
                $deck->add(new \App\Card\Card($suit, $value));
            }
        }
        $session->set("deck", $deck);

        return $this->render('card/home.html.twig', $data);
    }

    /**
     * @Route("/card/deck2", name="card-deck-joker")
     */
    public function joker(SessionInterface $session): Response
    {
        $deck = new \App\Card\Deck();

        $playing_deck = [
        'clubs' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        'diamonds' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        'hearts' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        'spades' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
        'joker' => [0,0]
        ];

        foreach ($playing_deck as $suit => $values) {
            foreach ($values as $value) {
                $deck->add(new \App\Card\Card($suit, $value));
            }
        }
        $session->set("deck", $deck);


        $data = [
        'title' => 'Card Deck - with joker!',
        'printed_cards' => $deck->showCardsArray()
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    /**
     * @Route("/card/deck", name="card-deck")
     */
    public function deck(SessionInterface $session): Response
    {
        $deck = $session->get("deck");

        $deck->sortDeck();

        $data = [
            'title' => 'Card Deck',
            'printed_cards' => $deck->showCardsArray()
        ];

        return $this->render('card/deck.html.twig', $data);
    }


    /**
     * @Route("/card/deck/shuffle", name="card-deck-shuffle")
     */
    public function shuffle(SessionInterface $session): Response
    {
        $deck = $session->get("deck");

        $deck->shuffleDeck();

        $data = [
            'title' => 'Deck',
            'printed_cards' => $deck->showCardsArray()
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
    ): Response {
        $deck = $session->get("deck");

        $data = [
            'title' => 'Deck',
            'printed_cards' => $deck->drawCardArray($number),
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
        int $players = 3,
        int $cards = 4
    ): Response {
        $player = [];
        $playerCards = [];

        $deck = $session->get("deck");

        for ($i = 0; $i < $players; $i++) {
            $player[$i] = new \App\Card\Player();
            $cardz = $deck->poppedArrayCards($cards);
            $player[$i]->add($cardz);

            $playerCards[$i] = $player[$i]->showCardsArray();
        }

        $data = [
            'title' => 'Deck',
            'playercards' => $playerCards,
            'remaining_cards' => $deck->remainingCards()
        ];

        $session->set("deck", $deck);

        return $this->render('card/deal.html.twig', $data);
    }
}
