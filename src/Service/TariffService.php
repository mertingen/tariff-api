<?php

namespace App\Service;

use App\Entity\Tariff;

class TariffService
{
    public function calculateAnnualCost(Tariff $tariff, $consumption): float|int
    {
        switch ($tariff->type) {
            case 1:
                return $tariff->baseCost * 12 + $consumption * $tariff->additionalKwhCost / 100;
            case 2:
                if ($consumption <= $tariff->includedKwh) {
                    return $tariff->baseCost;
                } else {
                    return $tariff->baseCost + ($consumption - $tariff->includedKwh) * $tariff->additionalKwhCost / 100;
                }
            default:
                return 0;
        }
    }
}
