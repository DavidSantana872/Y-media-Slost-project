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
$db->exec("DELETE FROM premios"); // limpiando datos
$db->exec("INSERT INTO premios (nombre, cada_n_compras, disponibles) VALUES 
    ('🎁 Voucher 10,000 pesos', 5, 1000),   
    ('🎁 Voucher 20,000 pesos', 25, 200),  
    ('🌸 Perfume', 10, 500),               
    ('✈️ Viaje aéreo para 2 personas', 500, 10),          
    ('🇧🇷 Viaje a Brasil para 2 personas', 2500, 1),     
    ('🚗 Automovil 0 km', 4950, 1)      
");

function obtener_premios($db) {
    $premios = $db->query("SELECT * FROM premios")->fetchAll(PDO::FETCH_ASSOC);
    return ($premios);
}

function update_disponibilidad($db, $premio, $disponible) {
    $db->exec("UPDATE premios SET disponibles = $disponible WHERE id = $premio[id]");
}
?>
