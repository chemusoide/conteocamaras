<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aforo Total</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    <!-- Zona del Aforo Total -->
    <div class="aforo-total-container">
    <div class="aforo-total">
        <span class="aforo-total-texto">AFORO TOTAL</span>
        <br/>
        <span id="aforoTotal" class="aforo-cantidad"><?php echo $total; ?></span>
    </div>
    <div class="aforo-aviso">
        <div class="alert alert-max" style="<?php echo ($alertClass === 'alert alert-max' ? '' : 'display: none;'); ?>"><?php echo ($alertClass === 'alert alert-max' ? $alertMessage : ''); ?></div>
        <div class="alert alert-warning" style="<?php echo ($alertClass === 'alert alert-warning' ? '' : 'display: none;'); ?>"><?php echo ($alertClass === 'alert alert-warning' ? $alertMessage : ''); ?></div>
    </div>

    <!-- Mitad Inferior del Documento -->
    <div class="contenedor-inferior">
        <!-- Matriz de Cámaras -->
        <div class="camaras-container" id="infoCamaras">
            <?php foreach ($cameraData as $cameraName => $data) : ?>
                <div class="camara-item">
                    <h3><?php echo $cameraName; ?></h3>
                    <?php if (!isset($data['error'])) : ?>
                        <p>Entradas: <?php echo $data['entrada']; ?></p>
                        <p>Salidas: <?php echo $data['salida']; ?></p>
                        <p>Total: <?php echo $data['entrada'] - $data['salida']; ?></p>
                    <?php else : ?>
                        <p>Error: <?php echo $data['error']; ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Información de Aforo a la Derecha -->
        <div class="info-derecha-container">
            <!-- Aforo de Cámaras -->
            <div class="aforo-camaras">
                <h2>Aforo de Cámaras: <span id="aforoCameras"><?php echo $aforoCameras; ?></span></h2>
                <p>Última actualización: <span id="last-refresh"><?php echo $ultimaActualizacion; ?></span></p>
            </div>

        <!-- Aforo Manual y Botones -->
        <div class="aforo-manual">
            <h2>Aforo Manual: <span id="aforoManual"><?php echo $aforoManual; ?></span></h2>
            <button id="sumarPersonaBtn">+ Sumar Persona</button>
            <button id="restarPersonaBtn">- Restar Persona</button>
        </div>
    </div>
</div>

    <!-- Pie de página -->
    <div class="footer">
    Power by IB Seguretad - designed and developed by <a target="_blank" href="https://informaticapolo.com">Informática POLO</a> ©<?php echo date('Y');?>
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