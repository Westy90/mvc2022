<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    protected Card $card;

    /**
     * Construct object and verify that the object has the expected
     * properties, use two arguments, spades and 5.
     */
    public function testCreateCard()
    {
        $this->card = new Card("spades", 5);
        $this->assertInstanceOf("\App\Card\Card", $this->card);

        $res = $this->card->getValue();
        $this->assertNotEmpty($res);
    }

    /**
     * Test that method getValue works
     */
    public function testGetValue()
    {
        $this->card = new Card("spades", 5);

        $res = $this->card->getValue();
        $this->assertEquals(5, $res);
    }

    /**
     * Test that method getSuit works
     */
    public function testGetSuit()
    {
        $this->card = new Card("spades", 5);

        $res = $this->card->getSuit();
        $this->assertEquals("spades", $res);
    }
}
