<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aforo Total Simplificado</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="aforo-container">
        <h1>Aforo Total Actual:</h1>
        <div id="aforoTotal" class="aforo-total <?php echo ($aforoData['total'] < 0) ? 'negative' : ''; ?>">
            <?php echo $aforoData['total']; ?>
        </div>
        <div id="alert" class="<?php echo $aforoData['alertClass']; ?>">
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
