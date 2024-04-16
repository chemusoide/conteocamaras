<?php

// Cargar el controlador correspondiente según la solicitud
require_once '../src/controllers/CameraController.php';

// Crear una instancia del controlador
$controller = new CameraController();

// Llamar al método correspondiente según la solicitud (por ejemplo, según la URL)
$aforoTotal = $controller->calcularAforoTotal(['camera01', 'camera02']);

// Cargar la vista del aforo total y pasar el resultado como una variable
require_once '../src/views/aforo_total_view.php';