<?php

namespace App\Tests;

use App\Entity\Tariff;
use App\Service\TariffService;
use PHPUnit\Framework\TestCase;

class TariffServiceTest extends TestCase
{
    public function testCalculateAnnualCostForType1()
    {
        // Arrange
        $tariff = new Tariff("Product A", 1, 5, 22);
        $service = new TariffService();

        // Act
        $annualCost = $service->calculateAnnualCost($tariff, 1000);

        // Assert
        $this->assertEquals(5 * 12 + 1000 * 22 / 100, $annualCost);
    }

    public function testCalculateAnnualCostForType2WithinIncludedKwh()
    {
        // Arrange
        $tariff = new Tariff("Product B", 2, 800, 30, 4000);
        $service = new TariffService();

        // Act
        $annualCost = $service->calculateAnnualCost($tariff, 3000);

        // Assert
        $this->assertEquals(800, $annualCost);
    }

    public function testCalculateAnnualCostForType2ExceedingIncludedKwh()
    {
        // Arrange
        $tariff = new Tariff("Product B", 2, 800, 30, 4000);
        $service = new TariffService();

        // Act
        $annualCost = $service->calculateAnnualCost($tariff, 5000);

        // Assert
        $this->assertEquals(800 + (5000 - 4000) * 30 / 100, $annualCost);
    }
}
