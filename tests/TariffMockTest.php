<?php

namespace App\Tests;

use App\Entity\Tariff;
use App\Mock\TariffMock;
use PHPUnit\Framework\TestCase;

class TariffMockTest extends TestCase
{
    public function testGetTariffs()
    {
        // Create an instance of TariffMock
        $mock = new TariffMock();

        // Call the getTariffs method to retrieve tariffs
        $tariffs = $mock->getTariffs();

        // Assertions
        $this->assertCount(2, $tariffs); // Ensure there are exactly 2 tariffs
        $this->assertInstanceOf(Tariff::class, $tariffs[0]); // Check if the first element is an instance of Tariff
        $this->assertInstanceOf(Tariff::class, $tariffs[1]); // Check if the second element is an instance of Tariff
    }
}
