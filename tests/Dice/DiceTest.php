<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{

    protected Dice $die;

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDice()
    {

        $this->die = new Dice();
        $this->assertInstanceOf("\App\Dice\Dice", $this->die);

        $res = $this->die->getAsString();
        $this->assertNotEmpty($res);
    }

    /**
     * Tests that getAsString method returns the number as string
     */
    public function testGetAsString()
    {
        $this->die = new Dice();

        $this->die->setDice(1);

        $res = $this->die->getAsString();

        $this->assertEquals("1", $res);
    }

        /**
     * Tests that roll returns die in a value between 1 - 6
     */
    public function testRoll()
    {
        $this->die = new Dice();

        $this->die->setDice(100);

        $this->die->roll();

        $res = $this->die->getDice();

        $this->assertGreaterThan(0, $res);
        $this->assertLessThan(7, $res);

    }
}



