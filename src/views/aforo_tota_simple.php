<?php
require_once __DIR__ . '/../src/controllers/CameraController.php';

$controller = new CameraController();
$aforoData = $controller->calcularAforoTotal();  // Asegúrate de que este método devuelva el aforo total y el estado de los mensajes.

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aforo Total Simplificado</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .aforo-container {
            text-align: center;
        }
        .alert {
            padding: 10px;
            margin-top: 20px;
            font-weight: bold;
        }
        .alert-warning {
            color: #e6a800;
        }
        .alert-max {
            color: #d40d12;
        }
    </style>
</head>
<body>
    <div class="aforo-container">
        <h1>Aforo Total Actual:</h1>
        <div id="aforoTotal" class="aforo-total"><?php echo $aforoData['total']; ?></div>
        <div id="alert" class="<?php echo $aforoData['alertClass']; ?>"><?php echo $aforoData['alertMessage']; ?></div>
    </div>

    <script>
        function fetchAforoTotal() {
            $.get('fetch_aforo_total.php', function(data) {
                var result = JSON.parse(data);
                $('#aforoTotal').text(result.total);
                $('#alert').attr('class', result.alertClass).text(result.alertMessage);
            });
        }

        $(document).ready(function() {
            setInterval(fetchAforoTotal, 5000);  // Actualiza el aforo total cada 5 segundos
        });
    </script>
</body>
</html>
