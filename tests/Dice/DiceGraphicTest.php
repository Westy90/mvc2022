<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceGraphicTest extends TestCase
{

    protected DiceGraphic $die;

    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDiceGraphic()
    {
        $this->die = new DiceGraphic();
        $this->assertInstanceOf("\App\Dice\DiceGraphic", $this->die);

        $res = $this->die->getAsString();
        $this->assertNotEmpty($res);
    }

    /**
     * Tests that getAsString method returns the number as string/ascii image
     */
    public function testGetAsString()
    {
        $this->die = new DiceGraphic();

        $this->die->setDice(1);

        $res = $this->die->getAsString();

        $this->assertEquals('⚀', $res);
    }
}
