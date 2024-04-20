<?php
require_once __DIR__ . '/../src/controllers/CameraController.php';

$controller = new CameraController();
$aforoData = $controller->calcularAforoTotal();

echo json_encode($aforoData);