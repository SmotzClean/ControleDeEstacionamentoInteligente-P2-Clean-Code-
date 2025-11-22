<?php
namespace App\Application\Controllers;

use App\Application\Services\ParkingService;

class ReportController
{
    public function __construct(private ParkingService $service) {}

    public function handle()
    {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($this->service->report(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
