<?php

namespace App\Entity;

class Tariff
{
    public string $name;               // Name of the tariff
    public int $type;                  // Type of the tariff (integer)
    public float $baseCost;            // Base cost of the tariff
    public float $additionalKwhCost;   // Additional cost per kWh
    public int $includedKwh;           // Included kWh amount (optional)

    /**
     * Constructor to initialize a Tariff object.
     *
     * @param string $name Name of the tariff
     * @param int $type Type of the tariff
     * @param float $baseCost Base cost of the tariff
     * @param float $additionalKwhCost Additional cost per kWh
     * @param int $includedKwh Included kWh amount (optional, default is 0)
     */
    public function __construct(string $name, int $type, float $baseCost, float $additionalKwhCost, int $includedKwh = 0)
    {
        $this->name = $name;
        $this->type = $type;
        $this->baseCost = $baseCost;
        $this->additionalKwhCost = $additionalKwhCost;
        $this->includedKwh = $includedKwh;
    }
}
