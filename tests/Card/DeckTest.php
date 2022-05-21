<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Deck.
 */
class DeckTest extends TestCase
{

    /**
     * SetUp-method
     * Construct object and add cards
     */
    protected function setUp(): void
    {
        $this->deck = new Deck();

        $deckArray = [
            'clubs' => [2],
            'hearts' => [1,3],
            'diamonds' => [13],
            'spades' => [4]
        ];

        foreach ($deckArray as $suit=>$values)
        {
            foreach ($values as $value)
            {
                $this->deck->add(new \App\Card\Card($suit, $value));
            }
        }
    }

    /**
     * Checks that the construction and adding of cards in SetUp works
     */
    public function testCreateDeck()
    {
        $this->assertInstanceOf("\App\Card\Hand", $this->deck);

        $res = $this->deck->getSumArray();
        $this->assertNotEmpty($res);
    }


    /** Test that method shuffle decks works, that the
     * original deck is shuffled after the method has been used
     */
    public function testShuffleDeck()
    {
        $oldDeck = clone $this->deck;

        $this->deck->shuffleDeck();

        $this->assertNotEquals($oldDeck, $this->deck);
    }

    /** Test that method sort decks works, that the
     * original deck is sorted after the method has been used
     */
    public function testSortDeck()
    {
        $oldDeck = clone $this->deck;

        $this->deck->sortDeck();

        $this->assertNotEquals($oldDeck->showCardsArray(), $this->deck->showCardsArray());
    }


    /** Test that method drawCardArray works, that
     * array with card suit and value is returned
     */
    public function testDrawCardArray()
    {
        $res = $this->deck->drawCardArray();

        $this->assertEquals([['spades' => 4]], $res);
    }


    /** Test that method drawCard works, that one card
     * is returned and that its of instance of class Card
     */
    public function testDrawCard()
    {
        $res = $this->deck->drawCard();

        $this->assertInstanceOf("\App\Card\Card", $res);
    }


    /** Test that method poppedArrayCards works, that one card
     * is returned and that its of instance of class Card.
     */
    public function testpoppedArrayCards()
    {
        $res = $this->deck->poppedArrayCards();
        $this->assertInstanceOf("\App\Card\Card", $res[0]);
    }

    /** Test that the reaming amount of cards is decreased after popping
     */
    public function testremainingCards()
    {
        $before = $this->deck->remainingCards();

        $this->deck->poppedArrayCards();

        $res = $this->deck->remainingCards();

        $this->assertEquals(4, $before - 1);
    }

}



