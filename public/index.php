<?php
// Establecer la zona horaria a España (UTC+2)
date_default_timezone_set('Europe/Madrid');

$view = $_GET['view'] ?? 'default'; // 'default' es la vista por defecto

// Obtener la ruta al archivo de configuración de la cámara
$configFilePath = __DIR__ . '/../config/cameraInfo.json';

if (file_exists($configFilePath)) {
    require_once __DIR__ . '/../src/controllers/CameraController.php';
    $controller = new CameraController();
    $aforoData = $controller->calcularAforoTotal();
    extract($aforoData);

    // Decide qué vista cargar en función del parámetro 'view'
    switch ($view) {
        case 'simple':
            require_once __DIR__ . '/../src/views/aforo_total_simple.php';
            break;
        case 'avisos':
            require_once __DIR__ . '/../src/views/aforo_total_avisos.php';
            break;
        case 'default':
            require_once __DIR__ . '/../src/views/aforo_total_view.php';
            break;
        default:
            echo "Error: Vista no reconocida.";
            break;
    }
} else {
    echo "Error: No se encontró el archivo de configuración cameraInfo.json.";
}