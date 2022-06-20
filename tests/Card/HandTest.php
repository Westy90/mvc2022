<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class HandTest extends TestCase
{
    protected Hand $hand;

    /**
     * Construct object and verify that the object has the expected
     * properties, an array of cards is then added.
     */
    public function testCreateHand()
    {
        $hand = new Hand();
        $this->assertInstanceOf("\App\Card\Hand", $hand);

        $deckArray = [
            'clubs' => [1,2,3],
            'diamonds' => [1,2,3],
            'hearts' => [1,2,3],
            'spades' => [1,2,3]
        ];

        foreach ($deckArray as $suit=>$values) {
            foreach ($values as $value) {
                $hand->add(new \App\Card\Card($suit, $value));
            }
        }

        $res = $hand->getSumArray();
        $this->assertNotEmpty($res);
    }


    /**
     * Test that method showCardsArray works
     */
    public function testshowCardsArray()
    {
        $hand = new Hand();

        $deckArray = [
            'clubs' => [1,2],
            'hearts' => [7,9]
        ];

        foreach ($deckArray as $suit=>$values) {
            foreach ($values as $value) {
                $hand->add(new \App\Card\Card($suit, $value));
            }
        }

        $array = array(array("clubs" => 1), array("clubs" => 2), array("hearts" => 7), array("hearts" => 9));

        $res = $hand->showCardsArray();
        $this->assertEquals($array, $res);
        //
    }

    /**
     * Test that method getSumArray works
     */
    public function testGetSumArray()
    {
        $hand = new Hand();

        $deckArray = [
            'clubs' => [1,2],
            'hearts' => [7,9]
        ];

        foreach ($deckArray as $suit=>$values) {
            foreach ($values as $value) {
                $hand->add(new \App\Card\Card($suit, $value));
            }
        }

        $array = array(19,32);

        $res = $hand->getSumArray();
        $this->assertEquals($array, $res);
    }
}
