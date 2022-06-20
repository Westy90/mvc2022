<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceGraphicTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDiceGraphic()
    {
        $die = new DiceGraphic();
        $this->assertInstanceOf("\App\Dice\DiceGraphic", $die);

        $res = $die->getAsString();
        $this->assertNotEmpty($res);
    }

    /**
     * Tests that getAsString method returns the number as string/ascii image
     */
    public function testGetAsString()
    {
        $die = new DiceGraphic();

        $die->setDice(1);

        $res = $die->getAsString();

        $this->assertEquals('⚀', $res);
    }
}
