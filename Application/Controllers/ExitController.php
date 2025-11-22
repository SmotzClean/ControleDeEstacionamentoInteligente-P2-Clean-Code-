<?php
namespace App\Application\Controllers;

use App\Application\Services\ParkingService;

class ExitController
{
    public function __construct(private ParkingService $service) {}

    public function handle()
    {
        $plate = $_POST['plate'] ?? '';

        $amount = $this->service->exit($plate);

        echo "Total a pagar: R$ {$amount}";
    }
}
