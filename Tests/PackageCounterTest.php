<?php

use AAbramenko\HomeWork\Tasks\PackageCounter;
use PHPUnit\Framework\TestCase;

class PackageCounterTest extends TestCase
{

    public function testCalculationOfTheNumberOfPackages() {
        $this->assertEquals(
            [
                36 => 2,
                12 => 2,
                3 => 1
            ],
            PackageCounter::getCount([12, 3, 36], 99)
        );
        $this->assertEquals(
            [
                10 => 1,
                5 => 1,
            ],
            PackageCounter::getCount([5, 10], 15)
        );
        $this->assertEquals(
            [
                10 => 0,
                5 => 1,
            ],
            PackageCounter::getCount([5, 10], 3)
        );
        $this->assertEquals(
            [
                3 => 2,
            ],
            PackageCounter::getCount([3], 5)
        );
    }
}
