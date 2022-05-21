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

        $this->game->addDeck($deckArray);

        $this->game->deck->shuffleDeck();
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

        //$res = $this->player->getSumArray();
        //$this->assertNotEmpty($res);
    }


    /** Test that method showCardsArray works
     */

    /* public function testShowCardsArray()
    {
        $check = array(array("clubs" => 2), array("hearts" => 1), array("hearts" => 3));

        $this->assertEquals($check, $this->player->showCardsArray());
    }*/


    /** Test that method getSum returns the correct sum for the player
     */

    /* public function testGetSum()
    {
        $this->assertEquals([6, 19], $this->player->getSumArray());
    }*/

}



