<?php
require_once __DIR__ . '/../src/controllers/CameraController.php';

$controller = new CameraController();
$aforoManual = $controller->getAforoManual();
$cambio = isset($_POST['cambio']) ? intval($_POST['cambio']) : -1;
$nuevoAforoManual = $aforoManual + $cambio;

$result = $controller->updateAforoManual($nuevoAforoManual);
$aforoData = $controller->calcularAforoTotal();

echo json_encode($aforoData);
