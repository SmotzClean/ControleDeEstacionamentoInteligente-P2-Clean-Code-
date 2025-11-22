<?php
namespace App\Domain\Enums;

enum VehicleType: string {
    case CAR = 'carro';
    case MOTO = 'moto';
    case TRUCK = 'caminhao';
}
