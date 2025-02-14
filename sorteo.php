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
# parámetro 3 > awardName
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);
    $purchaseNumber = filter_input(INPUT_GET, 'purchaseNumber', FILTER_SANITIZE_NUMBER_INT);
    if (empty($userId) || empty($purchaseNumber)) {
        echo json_encode(['error' => 400]);
        exit;
    }
    $premios = obtener_premios($db);
    if ($premios === false) {
        echo json_encode(['error' => 'Failed to obtain awards']);
        exit;
    }
    $winner = generate_winner($purchaseNumber, $premios, $db);
    if ($winner === false) {
        echo json_encode(['error' => 'Failed to generate winner']);
        exit;
    }

    echo json_encode(['userId' => $userId, 'purchaseNumber' => $purchaseNumber, 'awardName' => $winner]);
    exit;
}

?>
