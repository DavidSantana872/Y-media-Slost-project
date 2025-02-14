<?php
require_once "database.php";
require_once "functions.php";

header("Content-Type: application/json");

#--- Actuales Entrada ---
# parámetro 1 > userId
# parámetro 2 > purchaseNumber

# -- Actuales Salida
# parámetro 1 > userId
# parámetro 2 > purchaseNumber
# parámetro 3 > premioName
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_GET['userId'] ?? null;
    $purchaseNumber = $_GET['numeroCompra'] ?? null; // Nota que en la URL es `numeroCompra`

    if (empty($userId) || empty($purchaseNumber)) {
        echo json_encode(['error' => 'Faltan parámetros', 'purchaseNumber' => $purchaseNumber, 'userId' => $userId]);
        exit;
    }

    $premios = obtener_premios($db);
    $winner = generate_winner($purchaseNumber, $premios, $db);
    echo json_encode(['userId' => $userId, 'purchaseNumber' => $purchaseNumber, 'premioName' => $winner]);
    exit;
}

?>
