<?php
namespace App\Domain\Repositories;

use PDO;
use App\Domain\Entities\ParkingRecord;
use App\Domain\Enums\VehicleType;

class SQLiteParkingRepository implements ParkingRepositoryInterface
{
    public function __construct(private PDO $pdo) {}

    public function add(ParkingRecord $r): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO parking (plate, type, entry_at) VALUES (?, ?, ?)"
        );
        $stmt->execute([
            $r->plate(),
            $r->type()->value,
            $r->entryAt()->format('Y-m-d H:i:s')
        ]);
    }

    public function findActiveByPlate(string $plate): ?ParkingRecord {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM parking WHERE plate=? AND exit_at IS NULL"
        );
        $stmt->execute([$plate]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        return new ParkingRecord(
            id: $data['id'],
            plate: $data['plate'],
            type: VehicleType::from($data['type']),
            entryAt: new \DateTime($data['entry_at']),
            exitAt: null,
            amount: null
        );
    }

    public function update(ParkingRecord $r): void {
        $stmt = $this->pdo->prepare(
            "UPDATE parking SET exit_at=?, amount=? WHERE id=?"
        );
        $stmt->execute([
            $r->exitAt()->format('Y-m-d H:i:s'),
            $r->amount(),
            $r->id()
        ]);
    }

    public function getReport(): array {
        return $this->pdo->query("
            SELECT type, COUNT(*) as total, SUM(amount) as revenue 
            FROM parking WHERE amount IS NOT NULL GROUP BY type
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
}
