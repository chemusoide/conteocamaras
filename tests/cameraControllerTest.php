<?php
// test/camera_controller_test.php

require_once __DIR__ . '/../src/controllers/CameraController.php';

// Crear una instancia del controlador
$controller = new CameraController();

// Lista de nombres de cámaras para obtener datos
$cameras = ['camera01', 'camera02'];

// Obtener los datos para las cámaras especificadas
$data = $controller->getDataForMultipleCameras($cameras);

// Verificar si se devolvieron datos
if (!empty($data) && is_array($data)) {
    foreach ($cameras as $cameraName) {
        // Verificar si los datos de la cámara están presentes y en el formato esperado
        if (isset($data[$cameraName]) && is_array($data[$cameraName])) {
            // Aserción: Los datos de la cámara deben contener una clave "entrada" y "salida"
            assert(array_key_exists('entrada', $data[$cameraName]) && array_key_exists('salida', $data[$cameraName]), "Error: Los datos de la cámara $cameraName no están completos.");
            
            // Aserción: Los datos de entrada y salida deben ser números enteros
            assert(is_int($data[$cameraName]['entrada']) && is_int($data[$cameraName]['salida']), "Error: Los datos de entrada y salida de la cámara $cameraName deben ser números enteros.");
            
            // Imprimir los datos para la cámara si todas las aserciones pasan
            echo "Datos para la cámara $cameraName:\n";
            print_r($data[$cameraName]);
            // Imprimir un tick verde si las pruebas pasaron correctamente
            echo "\033[32m✔ Prueba exitosa: todas los test pasaron sin errores.\033[0m\n";
        } else {
            // Aserción: Debe haber datos para cada cámara
            assert(false, "Error: No se encontraron datos para la cámara $cameraName.");
        }
    }
} else {
    // Aserción: Deben devolverse datos y estar en el formato correcto
    assert(false, "Error: No se devolvieron datos o el formato es incorrecto.");
}
?>
