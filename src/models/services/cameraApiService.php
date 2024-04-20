<?php
// src/models/services/CameraApiService.php

require_once __DIR__ . '/../../../helpers/debug.php';

class CameraApiService {
    private $cameras;
    private $config;

    public function __construct($configFilePath) {
        $this->config = json_decode(file_get_contents($configFilePath), true);
        $this->cameras = $this->config['cameras']; // Acceder a la lista de cámaras desde la nueva estructura
    }

    public function getCameraData($cameraName) {
        // Validar que el nombre de la cámara sea una cadena no vacía
        if (!is_string($cameraName) || empty($cameraName)) {
            throw new InvalidArgumentException("El nombre de la cámara debe ser una cadena no vacía.");
        }

        // Verificar si la cámara está configurada
        if (isset($this->cameras[$cameraName])) {
            $cameraInfo = $this->cameras[$cameraName];
            
            // Obtener el token de autenticación
            $authToken = $this->getAuthToken($cameraInfo['auth'], $cameraInfo['user'], $cameraInfo['password']);

            // Construir la URL de la API de la cámara
            $cameraUrl = $cameraInfo['url'] . "api/count-data";

            // Configurar la solicitud HTTP con el token de autenticación
            $context = stream_context_create([
                'http' => [
                    'header' => "Authorization: Bearer " . $authToken
                ]
            ]);

            // Realizar la solicitud HTTP a la URL de la cámara
            $response = file_get_contents($cameraUrl, false, $context);

            // Verificar si se obtuvo una respuesta
            if ($response === false) {
                throw new Exception("No se pudo obtener respuesta de la cámara '$cameraName'.");
            }

            // Cargar el XML como un objeto SimpleXMLElement
            $xml = simplexml_load_string($response);

            // Verificar si se pudo cargar el XML correctamente
            if ($xml === false) {
                throw new Exception("Error al cargar el XML devuelto por la cámara '$cameraName'.");
            }

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

    private function getAuthToken($authUrl, $username, $password) {
        // Validar que la URL de autenticación no esté vacía
        if (empty($authUrl)) {
            throw new InvalidArgumentException("La URL de autenticación no puede estar vacía.");
        }

        // Configurar la solicitud HTTP con autenticación básica
        $context = stream_context_create([
            'http' => [
                'header' => "Authorization: Basic " . base64_encode($username . ":" . $password)
            ]
        ]);

        // Realizar la solicitud HTTP al endpoint de autenticación
        $authData = file_get_contents($authUrl, false, $context);

        // Verificar si se obtuvo una respuesta
        if ($authData === false) {
            throw new Exception("No se pudo obtener respuesta del servidor de autenticación.");
        }

        return $authData;
    }
}
?>