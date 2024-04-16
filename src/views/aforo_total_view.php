<!-- views/aforo_total_view.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aforo Total</title>

    <style>
        /* Estilos CSS */
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Aforo Total -->
        <?php
        echo "<h2>Aforo Total: <span id='aforoTotal'>$aforoTotal</span></h2>";

         // Mostrar alertas según el aforo total y los valores de configuración
         if ($aforoTotal >= $totalForo) {
            echo '<div class="alert alert-max">¡Aforo máximo alcanzado!</div>';
        } elseif ($aforoTotal >= $warningRangeStart && $aforoTotal <= $warningRangeEnd) {
            echo '<div class="alert alert-warning">¡Aviso de aforo cercano al máximo!</div>';
        }
        ?>
    
        <!-- Contador manual -->
        <p>Contador Manual: <span id="contadorManual">0</span></p>

        <!-- Botones para sumar y restar personas al aforo máximo -->
        <button onclick="sumarPersona()">Sumar Persona</button>
        <button onclick="restarPersona()">Restar Persona</button>

        <!-- Desglose por cámaras -->
        <?php
        // Mostrar el desglose por cámaras
        foreach ($cameraData as $cameraName => $data) {
            echo "<h3>$cameraName</h3>";
            if (isset($data['entrada']) && isset($data['salida'])) {
                echo "Entradas: {$data['entrada']}<br>";
                echo "Salidas: {$data['salida']}<br>";
            } else {
                echo "Error: {$data['error']}<br>";
            }
        }
        ?>
    </div>

    <script>
        // Contador manual
        let contador = 0;

        function sumarPersona() {
            contador++;
            actualizarContador();
            sumarAlAforoTotal();
        }

        function restarPersona() {
            if (contador > 0) {
                contador--;
                actualizarContador();
                restarDelAforoTotal();
            }
        }

        function actualizarContador() {
            document.getElementById("contadorManual").innerText = contador;
        }

        function sumarAlAforoTotal() {
            // Obtener el valor actual del aforo total
            let aforoTotal = parseInt(document.getElementById("aforoTotal").innerText);

            // Incrementar el aforo total y actualizar el elemento HTML
            aforoTotal++;
            document.getElementById("aforoTotal").innerText = aforoTotal;
        }

        function restarDelAforoTotal() {
            // Obtener el valor actual del aforo total
            let aforoTotal = parseInt(document.getElementById("aforoTotal").innerText);

            // Decrementar el aforo total si es mayor que cero y actualizar el elemento HTML
            if (aforoTotal > 0) {
                aforoTotal--;
                document.getElementById("aforoTotal").innerText = aforoTotal;
            }
        }
    </script>
</body>
</html>
