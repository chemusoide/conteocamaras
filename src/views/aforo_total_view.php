<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aforo Total</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Aforo Total: <span id="aforoTotal"><?php echo $total; ?></span></h1>

        <div class="alert alert-max" style="<?php echo ($alertClass === 'alert alert-max' ? '' : 'display: none;'); ?>"><?php echo ($alertClass === 'alert alert-max' ? $alertMessage : ''); ?></div>
        <div class="alert alert-warning" style="<?php echo ($alertClass === 'alert alert-warning' ? '' : 'display: none;'); ?>"><?php echo ($alertClass === 'alert alert-warning' ? $alertMessage : ''); ?></div>

        <h2>Aforo de Cámaras: <span id="aforoCameras"><?php echo $aforoCameras; ?></span></h2>
        <p>Última actualización automática: <span id="last-refresh"><?php echo $ultimaActualizacion; ?></span></p>

        <h2>Aforo Manual: <span id="aforoManual"><?php echo $aforoManual; ?></span></h2>

        <button id="sumarPersonaBtn">Sumar Persona</button>
        <button id="restarPersonaBtn">Restar Persona</button>

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

    <!-- Inicializa variables JavaScript desde PHP -->
    <script>
        var totalForo = <?php echo $totalForo; ?>;
        var warningRangeStart = <?php echo $warningRangeStart; ?>;
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>