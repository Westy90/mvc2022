<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardControllerJson
{
    /**
     * @Route("card/api/deck")
     */

    public function deck(SessionInterface $session): Response
    {
        if ($session->get("deck") == null) {
            $deck = new \App\Card\Deck();

            $playing_deck = [
                'clubs' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
                'diamonds' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
                'hearts' => [1,2,3,4,5,6,7,8,9,10,11,12,13],
                'spades' => [1,2,3,4,5,6,7,8,9,10,11,12,13]
            ];

            foreach ($playing_deck as $suit=>$values) {
                foreach ($values as $value) {
                    $deck->add(new \App\Card\Card($suit, $value));
                }
            }
        } else {
            $deck = $session->get("deck");
        }

        $deck->sortDeck();

        $data = [
            'printed_cards' => $deck->showCardsArray()
        ];

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
