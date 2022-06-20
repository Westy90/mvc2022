<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDiceHand()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\App\Dice\DiceHand", $diceHand);
    }

    /**
     * Tests that adding die to diceHand works
     */

     public function testAddDice()
     {
        $diceHand = new DiceHand();
        $diceHand->add(new Dice());

        $res = $diceHand->getNumberDices();

        $this->assertEquals(1, $res);

     }

     /**
      * Tests that printing DiceHand as string works
      */
      public function testGetAsString()
      {
        $diceHand = new DiceHand();
        $diceHand->add(new Dice());

        $res = $diceHand->getAsString();
        $this->assertNotEmpty($res);
      }



}



