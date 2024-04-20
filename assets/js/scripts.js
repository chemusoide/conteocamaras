$(document).ready(function() {
    if ($('#aforoTotal').length) {
        let aforoTotalInicial = parseInt($('#aforoTotal').text()) || 0;
        actualizarAlertas(aforoTotalInicial);

        $('#sumarPersonaBtn').click(function() { actualizarAforoManual(1); });
        $('#restarPersonaBtn').click(function() { actualizarAforoManual(-1); });

        setInterval(function() {
            $('#last-refresh').text(new Date().toLocaleString('es-ES', { timeZone: 'Europe/Madrid' }));
        }, 60000); // Actualizar cada minuto
    }

    if ($('#aforoTotal').hasClass('aforo-total')) {
        setInterval(fetchAforoTotal, 5000);  // Actualiza el aforo total cada 5 segundos
    }

    function actualizarAlertas(aforoTotal) {
        $('.alert-max, .alert-warning').hide();  // Oculta todas las alertas primero
        
        if (aforoTotal >= totalForo) {
            $('.alert-max').show().text("¡Aforo máximo alcanzado!");
        } else if (aforoTotal >= warningRangeStart && aforoTotal < totalForo) {
            $('.alert-warning').show().text("¡Aviso de aforo cercano al máximo!");
        }
        
        $('#aforoTotal').toggleClass('negative', aforoTotal < 0);
    }

    function actualizarAforoManual(cambio) {
        $.post(cambio > 0 ? 'incrementar_aforo.php' : 'decrementar_aforo.php', { cambio: cambio }, function(response) {
            var data = JSON.parse(response);
            
            $('#aforoTotal').text(data.total);
            $('#aforoManual').text(data.aforoManual);
            $('#aforoCameras').text(data.aforoCameras);
            
            actualizarAlertas(data.total);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error al actualizar aforo manual: ", textStatus, errorThrown);
        });
    }

    function fetchAforoTotal() {
        $.get('fetch_aforo_total.php', function(data) {
            var result = JSON.parse(data);
            $('#aforoTotal').text(result.total);
            $('#alert').attr('class', result.alertClass).text(result.alertMessage);

            if (result.total < 0) {
                $('#aforoTotal').addClass('negative');
            } else {
                $('#aforoTotal').removeClass('negative');
            }
        });
    }
});