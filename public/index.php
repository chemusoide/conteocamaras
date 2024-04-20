<?php
// Establecer la zona horaria a España (UTC+2)
date_default_timezone_set('Europe/Madrid');

// Obtener la ruta al archivo de configuración de la cámara
$configFilePath = __DIR__ . '/../config/cameraInfo.json';

// Verificar si el archivo de configuración existe
if (file_exists($configFilePath)) {
    // Cargar el controlador correspondiente según la solicitud
    require_once __DIR__ . '/../src/controllers/CameraController.php';

    // Crear una instancia del controlador
    $controller = new CameraController();

    // Calcular el aforo total directamente desde el controlador, sin necesidad de pasar nombres de cámara
    $aforoData = $controller->calcularAforoTotal();

    // Extraer los datos para facilitar el acceso en la vista
    extract($aforoData);

    // Ahora incluye la vista con la ruta corregida
    require_once __DIR__ . '/../src/views/aforo_total_view.php';
} else {
    // Si el archivo de configuración no se encuentra, mostrar un mensaje de error
    echo "Error: No se encontró el archivo de configuración cameraInfo.json.";
}