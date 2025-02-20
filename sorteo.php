<?php
require_once "database.php";
require_once "functions.php";

header("Content-Type: application/json");

#--- Actuales Entrada ---
# parámetro 1 > userId
# parámetro 2 > purchaseNumber
# parámetro 3 > name
# parámetro 4 > lastName
# parámetro 5 > email
# parámetro 6 > telephone
# parámetro 7 > bank


# -- Actuales Salida
# parámetro 1 > userId
# parámetro 2 > purchaseNumber
# parámetro 3 > awardName
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);
    $purchaseNumber = filter_input(INPUT_GET, 'purchaseNumber', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_GET, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
    $telephone = filter_input(INPUT_GET, 'telephone', FILTER_SANITIZE_STRING);
    $bank = filter_input(INPUT_GET, 'bank', FILTER_SANITIZE_STRING);

    if (empty($userId) || empty($purchaseNumber) || empty($name) || empty($lastName) || empty($email) || empty($telephone) || empty($bank)) {
        echo json_encode(['error' => 400]);
        exit;
    }
    $premios = obtener_premios($db);
    if ($premios === false) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to obtain awards']);
        exit;
    }
    // insertar_usuario($db, $name, $lastName, $email, $telephone, $bank);
    insertar_usuario($db, $name, $lastName, $email, $telephone, $bank);
    
    $winner = generate_winner($purchaseNumber, $premios, $db);

    echo json_encode(['userId' => $userId, 'purchaseNumber' => $purchaseNumber, 'awardName' => $winner]);
    exit;
}

?>
