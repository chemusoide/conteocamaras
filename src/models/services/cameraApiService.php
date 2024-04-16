<?php
// src/models/services/CameraApiService.php

// Incluir el archivo de definición de dd() para DEBUG
require_once __DIR__ . '/../../../helpers/debug.php';

class CameraApiService {
    private $cameras;

    public function __construct($configFilePath) {
        $config = file_get_contents($configFilePath);
        $this->cameras = json_decode($config, true);
    }

    public function getCameraData($cameraName) {
        if (isset($this->cameras[$cameraName])) {
            $cameraInfo = $this->cameras[$cameraName];
            $url = $cameraInfo['url'] . "api/count-data";
    
            // Configurar la solicitud HTTP con autenticación básica
            $context = stream_context_create([
                'http' => [
                    'header' => "Authorization: Basic " . base64_encode($cameraInfo['user'] . ":" . $cameraInfo['password'])
                ]
            ]);
    
            // Realizar la solicitud HTTP a la URL de la cámara
            $response = file_get_contents($url, false, $context);
    
            // Cargar el XML como un objeto SimpleXMLElement
            $xml = simplexml_load_string($response);

            // Definir los espacios de nombres
            $xml->registerXPathNamespace('ns2', 'http://www.xovis.com/count-data');

            // Obtener el conteo de entrada y salida
            $line = $xml->xpath('//ns2:line')[0];
            $entradaGente = (int) $line->{'fw-count'};
            $salidaGente = (int) $line->{'bw-count'};

            // Verificar si la solicitud fue exitosa
            $statusNode = $xml->children('http://www.xovis.com/count-data')->{'request-status'}->children('http://www.xovis.com/common-types')->{'status'};
            $status = (string) $statusNode;

            if ($status !== 'OK') {
                throw new Exception("Error al obtener los datos de la cámara '$cameraName'.");
            }
    
            return ['entrada' => $entradaGente, 'salida' => $salidaGente];
        } else {
            throw new Exception("La cámara '$cameraName' no se encuentra en la configuración.");
        }
    }
    
}
?>