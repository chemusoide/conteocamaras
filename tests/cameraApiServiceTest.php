<?php
// tests/CameraApiServiceTest.php

require_once __DIR__ . '/../src/models/services/CameraApiService.php';

class CameraApiServiceTest {
    
    public function testGetCameraData() {
        // Obtener la ruta al archivo de configuración de la cámara
        $configFilePath = dirname(__DIR__) . '/config/cameraInfo.json';
    
        // Crear una instancia de la clase CameraApiService
        $cameraApiService = new CameraApiService($configFilePath);
    
        // Ejecutar el método getCameraData() para una cámara específica (o varias cámaras)
        $cameraData = $cameraApiService->getCameraData('camera01');
    
        // Verificar que los datos obtenidos son válidos (por ejemplo, un array)
        if (!is_array($cameraData)) {
            echo "Error: Los datos de la cámara no son un array válido\n";
            exit(1); // Terminar el script con un código de error
        }
    
        // Agregar más aserciones según sea necesario para verificar la estructura de los datos devueltos
        // Por ejemplo, puedes verificar la presencia de las claves "entrada" y "salida"
        if (!array_key_exists('entrada', $cameraData)) {
            echo "Error: Falta el campo 'entrada' en los datos de la cámara\n";
            exit(1); // Terminar el script con un código de error
        }
        if (!array_key_exists('salida', $cameraData)) {
            echo "Error: Falta el campo 'salida' en los datos de la cámara\n";
            exit(1); // Terminar el script con un código de error
        }

        // Si llegamos aquí, todas las aserciones pasaron correctamente
        echo "\033[32m✔ Prueba exitosa: todas los test pasaron sin errores.\033[0m\n";
    }
}

// Ejecutar pruebas
$cameraApiServiceTest = new CameraApiServiceTest();
$cameraApiServiceTest->testGetCameraData();