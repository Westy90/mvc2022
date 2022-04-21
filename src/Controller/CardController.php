<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            'title' => 'Dice',
            'array_num' => [],
            'new_string' => "",

        ];

        $deck = new \App\Card\Deck();

        $playing_deck = [
            'clubs' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
            'diamonds' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
            'hearts' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
            'spades' => [1,2,3,4,5,6,7,8,9,10,11,12,13]
        ];

        foreach ($playing_deck as $suit=>$values) {

            foreach ($values as $value) {

                /*$data['array_num'][] = $suit;
                $data['array_num'][] = $value;*/

                $deck->add(New \App\Card\Card($suit, $value));

            }
        }

        $session->set("deck", $deck);

        //Skapa kortleken i denna vy? (utan att visa den)
        return $this->render('card/home.html.twig', $data);
    }

    /**
     * @Route("/card/deck", name="card-deck")
     */
    public function roll(SessionInterface $session ): Response
    {

        $deck = $session->get("deck");

        $data = [
            'title' => 'Deck',
            'printed_cards' => $deck->getAllCards()
        ];


        return $this->render('card/deck.html.twig', $data);
    }
}
