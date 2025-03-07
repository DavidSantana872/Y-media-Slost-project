<?php
require_once "database.php";
require_once "functions.php";
require_once "mail.php";
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
   /* if (existe_numero_compra($db, $purchaseNumber)) {
        $winner = false;
        echo json_encode([
            'slots' => generate_img_slots(false), 
            'winnerStatus' => $winner == false ? false : true,
            'winnerName' => $name,
            'winnerLastName' => $lastName,
            'winnerData' => $winner == false ? false : $winner['nombre'],
            'winnerEmail' => $email,
            'bank' => $winner == false ? false : $bank,
        ]);
        exit;
    }*/
    // Generar ganador
 
    $winner = generate_winner($purchaseNumber, $premios, $db);
    // Insertar usuario en la base de datos
    $statusMailUser = null;
    $statusMailMarketing = null;
    if($winner){
       $statusMailUser = send_email(
            $mailInstance,
            $email, 
            "<!DOCTYPE html>
            <html>
                <head>
                    <meta charset='UTF-8'>
                    <title>¡Felicidades, has ganado!</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f8f9fa;
                            padding: 20px;
                            text-align: center;
                        }
                        .container {
                            background-color: #ffffff;
                            padding: 20px;
                            border-radius: 10px;
                            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                            max-width: 600px;
                            margin: auto;
                        }
                        h1 {
                            color: #007bff;
                        }
                        p {
                            font-size: 16px;
                            color: #333;
                        }
                        .footer {
                            margin-top: 20px;
                            font-size: 14px;
                            color: #666;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h1>🎉 ¡Felicidades, $nombre! 🎉</h1>
                        <p>Nos complace informarte que has ganado <strong>" . $winner['nombre'] . "</strong> en nuestra última promoción.</p>
                        <p>El departamento de <strong>Marketing</strong> se pondrá en contacto contigo al número <strong>$telephone</strong> para coordinar la entrega de tu premio.</p>
                        <p>¡Gracias por participar y ser parte de nuestra comunidad!</p>
                        <p class='footer'>Atentamente,<br>Equipo de Tienda de Perfumes</p>
                    </div>
                </body>
            </html>",
            "Felicidades, has ganado!"
    );
        $statusMailMarketing = send_email( $mailInstance, $_ENV['SMTP_USER'], 
        "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Nuevo Ganador - Notificación a Marketing</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    padding: 20px;
                    text-align: center;
                }
                .container {
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                    margin: auto;
                    text-align: left;
                }
                h2 {
                    color: #007bff;
                }
                p {
                    font-size: 16px;
                    color: #333;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 14px;
                    color: #666;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>-- Nuevo Ganador --</h2>
                <p><strong>Nombre del ganador:</strong>". $name . " " . $lastName ."</p>
                <p><strong>Premio ganado:</strong>" . $winner['nombre'] . "</p>
                <p><strong>Teléfono de contacto:</strong> ". $telephone ."</p>
                <p><strong>Correo del ganador:</strong> ". $email ."</p>
                <p>Por favor, ponganse en contacto con el ganador para coordinar la entrega del premio.</p>
                <p class='footer'>Atentamente,<br>Equipo de Tienda de Perfumes</p>
            </div>
        </body>
        </html>",
        "Nuevo ganador -". $winner['nombre'] .""
        );
    }
    try{
        insertar_usuario($db, $name, $lastName, $email, $telephone, $bank, $purchaseNumber, $winner['nombre'], $statusMailUser, $statusMailMarketing);
    }catch (Exception $e) {
        echo json_encode(['error' => 500, 'message' => $e]);
        exit;
    }
    // Devolver la respuesta en JSON
    echo json_encode([
        'slots' => generate_img_slots($winner['img_name']), 
        'winnerStatus' => $winner == false ? false : true,
        'winnerName' => $name,
        'winnerLastName' => $lastName,
        'winnerData' => $winner == false ? false : $winner['nombre'],
        'winnerEmail' => $email,
        'bank' => $winner == false ? false : $bank,
        'statusMailUser' => $statusMailUser,
        'statusMailMarketing' => $statusMailMarketing
    ]);
    exit;
}
?>
