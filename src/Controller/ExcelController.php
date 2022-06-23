<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;


class ExcelController extends AbstractController
{
    /**
     * @Route("/excel", name="excel")
     */
    public function home(SessionInterface $session): Response
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');

        $data = [
            'title' => 'Excel playground - Home',
        ];

        //$session->set("deck", NULL);

        return $this->render('excel/home.html.twig', $data);
    }

    /**
     * @Route("/excel/read", name="excel-read")
     */
    public function read(SessionInterface $session): Response
    {

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load("mal11.xlsx");

        $dataArray = $spreadsheet->getSheetByName('11.3.1')
        ->rangeToArray(
        'B19:E23',     // The worksheet range that we want to retrieve
        NULL,        // Value that should be returned for empty cells
        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
        TRUE         // Should the array be indexed by cell row and cell column
    );

        $firstRow = min(array_keys($dataArray));
        $lastRow = max(array_keys($dataArray));


        $data = [
            'title' => 'Excel read',
            'dataArray' => $dataArray,
            'firstRow' => $firstRow,
            'lastRow' => $lastRow,
            ];

        return $this->render('excel/read.html.twig', $data);
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
