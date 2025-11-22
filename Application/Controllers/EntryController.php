<?php
namespace App\Application\Controllers;

use App\Application\Services\ParkingService;
use App\Domain\Enums\VehicleType;

class EntryController
{
    public function __construct(private ParkingService $service) {}

    public function handle()
    {
        $plate = $_POST['plate'] ?? '';
        $typeValue = $_POST['type'] ?? 'carro';

        $type = VehicleType::from($typeValue);

        $this->service->enter($plate, $type);

        echo "Entrada registrada!";
    }
}
