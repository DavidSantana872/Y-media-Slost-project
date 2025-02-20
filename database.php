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
    cada_n_compras INTEGER
)");

$db->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT,
    apellido TEXT,
    email TEXT,
    telefono TEXT,
    banco TEXT
)");

$existing = $db->query("SELECT COUNT(*) FROM premios")->fetchColumn();
if ($existing == 0) {
    $db->exec("INSERT INTO premios (nombre, cada_n_compras, disponibles) VALUES 
        ('🎁 Voucher 10,000 pesos', 5, 1000),   
        ('🎁 Voucher 20,000 pesos', 24, 200),  
        ('🌸 Perfume', 11, 500),               
        ('✈️ Viaje aéreo para 2 personas', 499, 10),          
        ('🇧🇷 Viaje a Brasil para 2 personas', 2500, 1),     
        ('🚗 Automovil 0 km', 4950, 1)      
    ");
}
function obtener_premios($db) {
    $premios = $db->query("SELECT * FROM premios")->fetchAll(PDO::FETCH_ASSOC);
    return ($premios);
}

function update_disponibilidad($db, $premio, $disponible) {
    $db->exec("UPDATE premios SET disponibles = $disponible WHERE id = $premio[id]");
}

function insertar_usuario($db, $nombre, $apellido, $email, $telefono, $banco) {
    $stmt = $db->prepare("INSERT INTO usuarios (nombre, apellido, email, telefono, banco) VALUES (:nombre, :apellido, :email, :telefono, :banco)");
    $stmt->execute([
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':email' => $email,
        ':telefono' => $telefono,
        ':banco' => $banco
    ]);
}
?>
