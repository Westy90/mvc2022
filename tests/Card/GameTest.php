<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class GameTest extends TestCase
{

    /**
     * SetUp-method
     * Construct object and add cards
     */
    protected function setUp(): void
    {
        $this->game = new Game();

        $deckArray = [
            'clubs' => [2],
            'hearts' => [1,3]
        ];

        $this->game->addDeck(new \App\Card\Deck(), $deckArray);

        $this->game->addPlayer(new \App\Card\Player()); //Banken är index 0
        $this->game->addPlayer(new \App\Card\Player()); //Spelaren är index 1

    }

    /**
     * Checks that the game construction and adding of cards in SetUp works
     * Checks that deck is added
     * Cheks that players are added
     */
    public function testCreateGame()
    {
        $this->assertInstanceOf("\App\Card\Game", $this->game);
        $this->assertInstanceOf("\App\Card\Deck", $this->game->deck);
        $this->assertInstanceOf("\App\Card\Player", $this->game->player[0]);
        $this->assertInstanceOf("\App\Card\Player", $this->game->player[1]);
    }


    /** Test that method drawCard works and returns a card
     */

    public function testDrawCard()
    {

        $res = $this->game->drawCard();

        $this->assertInstanceOf("\App\Card\Card", $res);

    }


    /** Tests that it works to deal one card to player one
     */

    public function testShowCardsArray()
    {
        $this->game->dealCards(1,1);

        $res = $this->game->showCardsArray(1);

        $this->assertEquals(array("hearts" => 3), $res[0]);
    }


    /** Tests that it works to deal three cards to player one and that getSumArray works
     */

    public function testGetSumArray()
    {
        $this->game->dealCards(3,1);

        $res = $this->game->getSumArray(1);

        $this->assertEquals(array(6, 19), $res);
    }

    /** Tests sees that the game works to play. Player wins
     */

    public function testPlay()
    {

        $deckArray = [
            'spades' => [5,6,7,8,11]
        ];

        $this->game->addDeck($this->game->deck, $deckArray);

        $this->game->dealCards(2,1); //Ger korten 11 och 8, spades

        $res = $this->game->computerPlay(); //Ger korten 7,6,5 /Player vinner

        $this->assertEquals("won", $res);
    }

}





