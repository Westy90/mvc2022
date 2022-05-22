<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use two arguments, spades and 5.
     */
    public function testCreateCard()
    {
        $card = new Card("spades", 5);
        $this->assertInstanceOf("\App\Card\Card", $card);

        $res = $card->getValue();
        $this->assertNotEmpty($res);
    }

    /**
     * Test that method getValue works
     */
    public function testGetValue()
    {
        $card = new Card("spades", 5);

        $res = $card->getValue();
        $this->assertEquals(5, $res);
    }

    /**
     * Test that method getSuit works
     */
    public function testGetSuit()
    {
        $card = new Card("spades", 5);

        $res = $card->getSuit();
        $this->assertEquals("spades", $res);
    }
}
