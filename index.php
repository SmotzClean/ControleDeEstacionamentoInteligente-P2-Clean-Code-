<?php
require __DIR__ . "/vendor/autoload.php";

use App\Application\Services\ParkingService;
use App\Application\Services\RateCalculator;
use App\Domain\Repositories\SQLiteParkingRepository;

$pdo = require __DIR__ . "/Infra/Database/connection.php";

$service = new ParkingService(
    new SQLiteParkingRepository($pdo),
    new RateCalculator()
);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Estacionamento Inteligente</title>
</head>
<body>
<h1>Controle de Estacionamento</h1>

<h2>Entrada</h2>
<form method="POST" action="?action=entry">
    Placa: <input name="plate" required>
    Tipo:
    <select name="type">
        <option value="carro">Carro</option>
        <option value="moto">Moto</option>
        <option value="caminhao">Caminhão</option>
    </select>
    <button type="submit">Registrar Entrada</button>
</form>

<h2>Saída</h2>
<form method="POST" action="?action=exit">
    Placa: <input name="plate" required>
    <button type="submit">Registrar Saída</button>
</form>

<h2>Relatório</h2>
<a href="?action=report">Ver relatório (JSON)</a>

<hr>

<?php
if (!isset($_GET["action"])) {
    exit;
}

$action = $_GET["action"];

if ($action === "entry") {
    try {
        (new App\Application\Controllers\EntryController($service))->handle();
        echo "<p style='color: green'>Entrada registrada com sucesso.</p>";
    } catch (Exception $e) {
        echo "<p style='color: red'>" . $e->getMessage() . "</p>";
    }
}


if ($action === "exit") {
    try {
        (new App\Application\Controllers\ExitController($service))->handle();
        echo "<p style='color: green'>Saída registrada com sucesso.</p>";
    } catch (Exception $e) {
        echo "<p style='color: red'>" . $e->getMessage() . "</p>";
    }
}


if ($action === "report") {

    ob_start();
    (new App\Application\Controllers\ReportController($service))->handle();
    $json = ob_get_clean();

    $report = json_decode($json, true);

    echo "<h2>Relatório de Faturamento</h2>";

    echo "<table border='1' cellpadding='8' cellspacing='0'>
            <tr>
                <th>Tipo</th>
                <th>Total</th>
                <th>Faturamento (R$)</th>
            </tr>";

    foreach ($report as $item) {
        echo "<tr>
                <td>{$item['type']}</td>
                <td>{$item['total']}</td>
                <td>" . number_format($item['revenue'], 2, ',', '.') . "</td>
              </tr>";
    }

    echo "</table>";
}

?>
</body>
</html>
