<?php
// src/controllers/CameraController.php

require_once __DIR__ . '/../models/services/cameraApiService.php';

class CameraController {
    private $cameraApiService;

    public function __construct() {
        // Obtener la ruta al archivo de configuración de la cámara
        $configFilePath = dirname(__DIR__, 2) . '/config/cameraInfo.json';

        $this->cameraApiService = new CameraApiService($configFilePath);
    }

    public function getDataForMultipleCameras($cameraNames) {
        $cameraData = [];
        foreach ($cameraNames as $cameraName) {
            try {
                $cameraData[$cameraName] = $this->cameraApiService->getCameraData($cameraName);
            } catch (Exception $e) {
                // Manejar el caso en que la cámara no se encuentre
                // Por ejemplo, puedes registrar un error o devolver un valor predeterminado
                $cameraData[$cameraName] = ['error' => $e->getMessage()];
            }
        }

        // Hacer algo con los datos obtenidos para múltiples cámaras
        return $cameraData;
    }

    public function calcularAforoTotal($cameraNames) {
        // Obtener los datos de las cámaras
        $cameraData = $this->getDataForMultipleCameras($cameraNames);
    
        // Calcular el aforo total global
        $aforoTotal = $this->calcularAforoTotalGlobal($cameraData);
    
        // Obtener totalForo y warning del archivo de configuración
        $configFilePath = dirname(__DIR__, 2) . '/config/cameraInfo.json';
        $configData = json_decode(file_get_contents($configFilePath), true);
        $warning = $configData['warning'];
        $totalForo = $configData['totalForum'];
        $warningPercentage = $configData['warning'] / 100; // Convertir el warning a porcentaje

    
        // Calcular el valor de warning en base al totalForo
        $warningValue = $totalForo * $warningPercentage;
    
        // Determinar el rango de alerta de warning
        $warningRangeStart = $totalForo - $warningValue;
        $warningRangeEnd = $totalForo;
    
        // Cargar la vista y pasar el aforo total, totalForo, warning y rango de alerta como variables
        require_once __DIR__ . '/../views/aforo_total_view.php';
    }

    private function calcularAforoTotalGlobal($cameraData) {
        $totalEntradas = 0;
        $totalSalidas = 0;

        // Calcular la suma total de entradas y salidas de todas las cámaras
        foreach ($cameraData as $data) {
            if (isset($data['entrada']) && isset($data['salida'])) {
                $totalEntradas += $data['entrada'];
                $totalSalidas += $data['salida'];
            }
        }

        // Calcular el aforo total
        return $totalEntradas - $totalSalidas;
    }
}

?>