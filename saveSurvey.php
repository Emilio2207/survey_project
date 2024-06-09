<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Manejar solicitudes OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "survey";

header('Content-Type: application/json');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar que el método de la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Método no permitido"));
    exit;
}

// Leer los datos de la encuesta
$data = json_decode(file_get_contents('php://input'), true);

// Validar datos recibidos
if (!isset($data['gender']) || !isset($data['age']) || !isset($data['preference']) || !isset($data['pageTimes'])) {
    echo json_encode(array("status" => "error", "message" => "Datos incompletos"));
    exit;
}

// Función para convertir segundos en formato hh:mm:ss
function formatDuration($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}

// Formatear las duraciones
foreach ($data['pageTimes'] as $page => $times) {
    $data['pageTimes'][$page]['duration'] = formatDuration($times['duration']);
}

$page_times = json_encode($data['pageTimes']);

// Preparar y vincular
$stmt = $conn->prepare("INSERT INTO respuestas (genero, edad, preferencia_bebida, page_times) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}
$stmt->bind_param("siss", $genero, $edad, $preferencia_bebida, $page_times);

// Establecer parámetros y ejecutar
$genero = $data['gender'];
$edad = $data['age'];
$preferencia_bebida = $data['preference'];

if ($stmt->execute()) {
    echo json_encode(array("status" => "success", "message" => "Datos guardados exitosamente"));
} else {
    echo json_encode(array("status" => "error", "message" => "Error al guardar los datos"));
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>


