<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardControllerJson
{
    private $number;



    /**
     * @Route("card/api/deck")
     */
    public function deck(SessionInterface $session): Response
    {

        $deck = $session->get("deck");

        //sort($deck->showCardsArray()[0]);

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