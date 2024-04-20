<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aforo Total</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .alert-warning {
            background-color: #ffe800;
        }
        .alert-max {
            background-color: #ff0000;
        }
        .negative {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Aforo Total: <span id="aforoTotal"><?php echo $total; ?></span></h1>

        <?php if ($alertMessage): ?>
            <div class="<?php echo $alertClass; ?>"><?php echo $alertMessage; ?></div>
        <?php endif; ?>

        <h2>Aforo de Cámaras: <span id="aforoCameras"><?php echo $aforoCameras; ?></span></h2>
        <p>Última actualización automática: <span id="last-refresh"><?php echo $ultimaActualizacion; ?></span></p>

        <h2>Aforo Manual: <span id="aforoManual"><?php echo $aforoManual; ?></span></h2>

        <button id="sumarPersonaBtn">Sumar Persona</button>
        <button id="restarPersonaBtn">Restar Persona</button>

        <!-- Desglose por cámaras -->
        <div id="infoCamaras">
            <?php foreach ($cameraData as $cameraName => $data) : ?>
                <h3><?php echo $cameraName; ?></h3>
                <?php if (!isset($data['error'])) : ?>
                    <p>Entradas: <?php echo $data['entrada']; ?></p>
                    <p>Salidas: <?php echo $data['salida']; ?></p>
                    <p>Total: <?php echo $data['entrada'] - $data['salida']; ?></p>
                <?php else : ?>
                    <p>Error: <?php echo $data['error']; ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('sumarPersonaBtn').addEventListener('click', function() {
                actualizarAforoManual(1); // Llama a incrementar
            });

            document.getElementById('restarPersonaBtn').addEventListener('click', function() {
                actualizarAforoManual(-1); // Llama a decrementar
            });

            function actualizarAforoManual(cambio) {
                $.post(cambio > 0 ? 'incrementar_aforo.php' : 'decrementar_aforo.php', { cambio: cambio }, function(response) {
                    var data = JSON.parse(response);
                    $('#aforoTotal').text(data.total);
                    $('#aforoManual').text(data.aforoManual);
                    $('#aforoCameras').text(data.aforoCameras);
                    actualizarAlertas(data.total);
                    $('#last-refresh').text(data.ultimaActualizacion);
                });
            }

            function actualizarAlertas(aforoTotal) {
                // Oculta ambas alertas primero
                $('.alert-max').hide();
                $('.alert-warning').hide();

                // Muestra la alerta apropiada basada en el aforo total
                if (aforoTotal >= <?php echo $totalForo; ?>) {
                    $('.alert-max').show();
                } else if (aforoTotal >= <?php echo $warningRangeStart; ?> && aforoTotal < <?php echo $totalForo; ?>) {
                    $('.alert-warning').show();
                }
            }

            // Llamar a actualizarAlertas inmediatamente después de cargar la página
            let aforoTotalInicial = parseInt(document.getElementById("aforoTotal").innerText) || 0;
            actualizarAlertas(aforoTotalInicial);
                    
        });
    </script>
</body>
</html>