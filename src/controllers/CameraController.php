<?php
// src/controllers/CameraController.php

require_once __DIR__ . '/../models/services/cameraApiService.php';
require_once __DIR__ . '/../models/Database.php';  // Asegúrate de que tienes un archivo que maneje la conexión a la base de datos.

class CameraController {
    private $cameraApiService;
    private $db;
    private $config;
    private $cameraNames;  // Almacenar los nombres de las cámaras para uso interno.

    public function __construct() {
        $configFilePath = dirname(__DIR__, 2) . '/config/cameraInfo.json';
        $this->config = json_decode(file_get_contents($configFilePath), true);
        $this->cameraApiService = new CameraApiService($configFilePath);
        $this->db = new Database();
        $this->cameraNames = array_keys($this->config['cameras']);  // Cargar los nombres de las cámaras desde la configuración.
    }

    public function getDataForMultipleCameras() {
        $cameraData = [];
        foreach ($this->cameraNames as $cameraName) {  // Utiliza la lista interna de nombres de cámaras.
            try {
                $cameraData[$cameraName] = $this->cameraApiService->getCameraData($cameraName);
            } catch (Exception $e) {
                $cameraData[$cameraName] = ['error' => $e->getMessage()];
            }
        }
        return $cameraData;
    }

    public function getAforoManual() {
        return $this->db->getAforoManual();
    }

    public function updateAforoManual($aforoManual) {
        return $this->db->updateAforoManual($aforoManual);
    }

    public function calcularAforoTotal() {
        $cameraData = $this->getDataForMultipleCameras();
        $aforoCameras = $this->calcularAforoTotalGlobal($cameraData);
        $aforoManual = $this->getAforoManual();
    
        $aforoTotal = $aforoCameras + $aforoManual;
    
        $totalForo = $this->config['totalForum'];
        $warning = $this->config['warning'];
        $warningPercentage = $warning / 100;
        $warningRangeStart = $totalForo * $warningPercentage;
        $ultimaActualizacion = date('d/m/Y - H:i');
    
        $alertMessage = '';
        $alertClass = '';
        if ($aforoTotal >= $totalForo) {
            $alertMessage = '¡Aforo máximo alcanzado!';
            $alertClass = 'alert alert-max';
        } elseif ($aforoTotal >= $warningRangeStart) {
            $alertMessage = '¡Aviso de aforo cercano al máximo!';
            $alertClass = 'alert alert-warning';
        }
    
        return [
            'total' => $aforoTotal,
            'aforoCameras' => $aforoCameras,
            'aforoManual' => $aforoManual,
            'cameraData' => $cameraData,
            'alertMessage' => $alertMessage,
            'alertClass' => $alertClass,
            'ultimaActualizacion' => $ultimaActualizacion,
            'totalForo' => $totalForo,
            'warningRangeStart' => $warningRangeStart 
        ];
    }

    private function calcularAforoTotalGlobal($cameraData) {
        $totalEntradas = 0;
        $totalSalidas = 0;
        foreach ($cameraData as $data) {
            if (isset($data['entrada']) && isset($data['salida'])) {
                $totalEntradas += $data['entrada'];
                $totalSalidas += $data['salida'];
            }
        }
        return $totalEntradas - $totalSalidas;
    }
}
?>