<?php
namespace App\Application\Services;

use App\Domain\Enums\VehicleType;

class RateCalculator
{
    public function calculate(VehicleType $type, \DateTime $entry, \DateTime $exit): float
    {
        $hours = max(1, ceil(($exit->getTimestamp() - $entry->getTimestamp()) / 3600));

        return match ($type) {
            VehicleType::CAR => $hours * 5,
            VehicleType::MOTO => $hours * 3,
            VehicleType::TRUCK => $hours * 10,
        };
    }
}
