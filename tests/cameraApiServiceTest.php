<?php
// tests/cameraApiServiceTest.php

require_once __DIR__ . '/../src/models/services/cameraApiService.php';

class CameraApiServiceTest {
    
    public function testGetCameraData() {
        // Obtener la ruta al archivo de configuración de la cámara
        $configFilePath = dirname(__DIR__) . '/config/cameraInfo.json';
    
        // Crear una instancia de la clase CameraApiService
        $cameraApiService = new CameraApiService($configFilePath);
    
        // Ejecutar el método getCameraData() para una cámara específica (o varias cámaras)
        $cameraData = $cameraApiService->getCameraData('camera01');
    
        // Verificar que los datos obtenidos son válidos (por ejemplo, un array)
        assert(is_array($cameraData), 'Los datos de la cámara no son un array válido');
    
        // Agregar más aserciones según sea necesario para verificar la estructura de los datos devueltos
        // Por ejemplo, puedes verificar la presencia de las claves "entrada" y "salida"
        assert(array_key_exists('entrada', $cameraData), 'Falta el campo "entrada" en los datos de la cámara');
        assert(array_key_exists('salida', $cameraData), 'Falta el campo "salida" en los datos de la cámara');
    }

}

// Ejecutar pruebas
$cameraApiServiceTest = new CameraApiServiceTest();
$cameraApiServiceTest->testGetCameraData();

// Imprimir un tick verde si las pruebas pasaron correctamente
echo "\033[32m✔ Prueba exitosa: todas los test pasaron sin errores.\033[0m\n";

?>
