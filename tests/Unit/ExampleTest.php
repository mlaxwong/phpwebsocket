<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testToTry()
    {
        $this->assertEquals(3, array_sum([1, 2]));
    }
}