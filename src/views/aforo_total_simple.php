<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aforo Total Simplificado</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="aforo-simple">
    <div class="aforo-simple-container">
        <img src="../assets/img/Logo.png" alt="Logotipo de la Empresa" class="logo-empresa"/>
        <div class="aforo-total-simple">AFORO TOTAL</div>
        <div id="aforoTotal" class="aforo-total <?php echo ($aforoData['total'] < 0) ? 'negative' : ''; ?>">
            <?php echo $aforoData['total']; ?>
        </div>
        <div id="alert" class="aforo-aviso-simple <?php echo $aforoData['alertClass']; ?>">
            <?php echo $aforoData['alertMessage']; ?>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var totalForo = <?php echo $totalForo; ?>;
        var warningRangeStart = <?php echo $warningRangeStart; ?>;
    </script>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>
