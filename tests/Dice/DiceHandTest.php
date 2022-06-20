<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceHandTest extends TestCase
{

    protected DiceHand $diceHand;

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDiceHand()
    {
        $this->diceHand = new DiceHand();
        $this->assertInstanceOf("\App\Dice\DiceHand", $this->diceHand);
    }

    /**
     * Tests that adding die to diceHand works
     */

     public function testAddDice()
     {
        $this->diceHand = new DiceHand();
        $this->diceHand->add(new Dice());

        $res = $this->diceHand->getNumberDices();

        $this->assertEquals(1, $res);

     }

     /**
      * Tests that printing DiceHand as string works
      */
      public function testGetAsString()
      {
        $this->diceHand = new DiceHand();
        $this->diceHand->add(new Dice());

        $res = $this->diceHand->getAsString();
        $this->assertNotEmpty($res);
      }



}



