<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDice()
    {
        $die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $die);

        $res = $die->getAsString();
        $this->assertNotEmpty($res);
    }

    /**
     * Tests that getAsString method returns the number as string
     */
    public function testGetAsString()
    {
        $die = new Dice();

        $die->setDice(1);

        $res = $die->getAsString();

        $this->assertEquals("1", $res);
    }

        /**
     * Tests that roll returns die in a value between 1 - 6
     */
    public function testRoll()
    {
        $die = new Dice();

        $die->setDice(100);

        $die->roll();

        $res = $die->getDice();

        $this->assertGreaterThan(0, $res);
        $this->assertLessThan(7, $res);

    }
}



