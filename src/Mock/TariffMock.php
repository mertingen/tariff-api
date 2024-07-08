<?php

namespace App\Mock;

use App\Entity\Tariff;

class TariffMock
{
    /**
     * Returns an array of mock Tariff objects.
     *
     * @return Tariff[]
     */
    public function getTariffs(): array
    {
        return [
            new Tariff(name: "Product A", type: 1, baseCost: 5, additionalKwhCost: 22),
            new Tariff(name: "Product B", type: 2, baseCost: 800, additionalKwhCost: 30,  includedKwh: 4000)
        ];
    }
}