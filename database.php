<?php
try {
    $db = new PDO("sqlite:" . __DIR__ . "/db-slots.sqlite");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
$db->exec("CREATE TABLE IF NOT EXISTS premios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT,
    disponibles INTEGER,
    cada_n_compras INTEGER,
    img_name TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT,
    apellido TEXT,
    email TEXT,
    telefono TEXT,
    banco TEXT,
    purchase_number INTEGER,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$existing = $db->query("SELECT COUNT(*) FROM premios")->fetchColumn();
if ($existing == 1) {
    $db->exec("INSERT INTO premios (nombre, cada_n_compras, disponibles, img_name) VALUES 
        ('🎁 Voucher 10,000 pesos', 5, 1000, '10k.png'),   
        ('🎁 Voucher 20,000 pesos', 24, 200, '20k.png'),  
        ('🌸 Perfume', 11, 500, 'perfume.png'),               
        ('✈️ Viaje aéreo para 2 personas', 499, 10, 'argetina.png'),          
        ('🇧🇷 Viaje a Brasil para 2 personas', 2500, 1, 'brasil.png'),     
        ('🚗 Automovil 0 km', 4950, 1, 'auto.png')      
    ");
}
function obtener_premios($db) {
    $premios = $db->query("SELECT * FROM premios")->fetchAll(PDO::FETCH_ASSOC);
    return ($premios);
}

function update_disponibilidad($db, $premio, $disponible) {
    $db->exec("UPDATE premios SET disponibles = $disponible WHERE id = $premio[id]");
}

function insertar_usuario($db, $nombre, $apellido, $email, $telefono, $banco, $purchase_number) {
    $stmt = $db->prepare("INSERT INTO usuarios (nombre, apellido, email, telefono, banco, purchase_number) VALUES (:nombre, :apellido, :email, :telefono, :banco, :purchase_number)");
    $stmt->execute([
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':email' => $email,
        ':telefono' => $telefono,
        ':banco' => $banco,
        ':purchase_number' => $purchase_number
    ]);
}

function existe_numero_compra($db, $numero) {
    $stmt = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE purchase_number = :numero");
    $stmt->execute([':numero' => $numero]);
    return $stmt->fetchColumn() > 0;
}
?>
