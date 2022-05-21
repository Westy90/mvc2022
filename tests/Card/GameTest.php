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

    }

    /**
     * Checks that the  of player construction and adding of cards in SetUp works
     */
    public function testCreateDeck()
    {
        $this->assertInstanceOf("\App\Card\Player", $this->player);

        $res = $this->player->getSumArray();
        $this->assertNotEmpty($res);
    }


    /** Test that method showCardsArray works
     */
    public function testShowCardsArray()
    {
        $check = array(array("clubs" => 2), array("hearts" => 1), array("hearts" => 3));

        $this->assertEquals($check, $this->player->showCardsArray());
    }


    /** Test that method getSum returns the correct sum for the player
     */
    public function testGetSum()
    {
        $this->assertEquals([6, 19], $this->player->getSumArray());
    }

}



