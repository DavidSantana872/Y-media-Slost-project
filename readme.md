# API slots, encargada de generar premio sorpresa para los clientes.

# Parámetros esperados 

# --- Actuales Entradas ---
parámetro 1 > userId
parámetro 2 > purchaseNumber

# -- Actuales Salida
parámetro 1 > userId
parámetro 2 > purchaseNumber
parámetro 3 > awardName

# --- Respuesta de endpoint ---
{
  "userId": "12",
  "purchaseNumber": "2500",
  "awardName": "🇧🇷 Viaje a Brasil para 2 personas"
}

# --- Functions.php --- 

Funciones especiales para la generación del ganador mediante las condiciones obtenidas de la db 

# --- Sorteo.php ---

Fichero encargado de responder con el premio establecido para el userId, código respectivo a la solicitud GET 

# --- Database.php ---
Conexión a la db generada en Sqlite, funciones para obtener y actualizar cada premio