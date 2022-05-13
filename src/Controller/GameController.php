<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GameController extends AbstractController
{

    /**
     * @Route("/game", name="game-home")
     */
    public function game(SessionInterface $session): Response
    {


        $game = new \App\Card\Game();

        $game->addDeck(new \App\Card\Deck());
        $game->deck->shuffleDeck();
        $game->addPlayer(new \App\Card\Player()); //Banken är index 0
        $game->addPlayer(new \App\Card\Player()); //Spelaren är index 1


        $session->set("game", $game);

        $data = [
            'title' => 'Game - home',
        ];

        return $this->render('game/home.html.twig', $data);
    }

    /**
     * @Route("/game/doc", name="game-doc")
     */
    public function doc(): Response
    {

        $data = [
            'title' => 'Game documentation',
        ];

        return $this->render('game/doc.html.twig', $data);
    }

    /**
     * @Route("/game/play", name="play")
     */
    public function play(SessionInterface $session): Response
    {

        $game = $session->get("game");
        $outcome = Null;

        $game->dealCards(1, 1); //Ger ett kort till player1


        if ($game->getSumArray(1)[0] > 21 and $game->getSumArray(1)[1] > 21) {

            $outcome = "lost";

        }

        $data = [
            'title' => 'Game - home',
            'game' => $game,
            'outcome' => $outcome,
        ];

        return $this->render('game/play.html.twig', $data);
    }

    /**
     * @Route("/stay", name="stay")
     */
    public function stay(SessionInterface $session): Response
    {

        $game = $session->get("game");

        $data = [
            'title' => 'Game - home',
            'game' => $game,
            'outcome' => $game->computerPlay(),
        ];

        return $this->render('game/play.html.twig', $data);
    }

}


/*
$player = [];


$deck = $session->get("deck");

for ($i = 0; $i < $players; $i++)
{

    $player[$i] = new \App\Card\Player();
    $cardz = $deck->poppedArrayCards($cards);
    $player[$i]->add($cardz);
}

$data = [
    'title' => 'Deck',
    'playercards' => $playerCards,
    'remaining_cards' => $deck->remainingCards()
];
*/



