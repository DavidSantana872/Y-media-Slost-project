<?php
require_once "database.php";
require_once "functions.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos desde POST (no GET)
    // Read the input stream
    $body = file_get_contents("php://input");
    // Decode the JSON object
    $object = json_decode($body, true);

    $userId = filter_var($object['userId'], FILTER_SANITIZE_NUMBER_INT);
    $purchaseNumber = filter_var($object['purchaseNumber'], FILTER_SANITIZE_NUMBER_INT);
    $name = filter_var($object['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_var($object['lastName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($object['email'], FILTER_SANITIZE_EMAIL);
    $telephone = filter_var($object['telephone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $bank = filter_var($object['bank'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validar que no haya datos vacíos
    if (!$userId || !$purchaseNumber || !$name || !$lastName || !$email || !$telephone || !$bank) {
        echo json_encode(['error' => 400, 'message' => 'Missing required fields']);
        exit;
    }

    // Obtener premios de la base de datos
    $premios = obtener_premios($db);
    if ($premios === false) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to obtain awards']);
        exit;
    }

   
    // Validar que el número de compra no exista
    if (existe_numero_compra($db, $purchaseNumber)) {
        $winner = false;
        echo json_encode([
            'slots' => generate_img_slots(false), 
            'winnerStatus' => $winner == false ? false : true,
            'winnerName' => $name,
            'winnerLastName' => $lastName,
            'winnerData' => $winner == false ? false : $winner['nombre'],
            'winnerEmail' => $email,
            'bank' => $winner == false ? false : $bank
        ]);
        exit;
    }
    // Generar ganador
    $winner = generate_winner($purchaseNumber, $premios, $db);
    // Insertar usuario en la base de datos
    insertar_usuario($db, $name, $lastName, $email, $telephone, $bank, $purchaseNumber);

    // Devolver la respuesta en JSON
    echo json_encode([
        'slots' => generate_img_slots($winner['img_name']), 
        'winnerStatus' => $winner == false ? false : true,
        'winnerName' => $name,
        'winnerLastName' => $lastName,
        'winnerData' => $winner == false ? false : $winner['nombre'],
        'winnerEmail' => $email,
        'bank' => $winner == false ? false : $bank
    ]);
    exit;
}
?>
