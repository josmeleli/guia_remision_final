document.addEventListener('DOMContentLoaded', function() {
    const botonesCopiar = document.querySelectorAll('.boton-copiar');
    const botonesCopiar2 = document.querySelectorAll('.boton-copiar2');
    const mensajeCopiado = document.getElementById('copiadoMensaje');
    const mensajeCopiado2 = document.getElementById('copiadoMensaje2');

    botonesCopiar.forEach(boton => {
        boton.addEventListener('click', function() {
            const fila = this.closest('tr');
            const ruc = fila.querySelector('.ruc').innerText.trim();
            
            navigator.clipboard.writeText(ruc)
                .then(() => {
                    console.log('RUC copiado al portapapeles: ' + ruc);
                    mostrarMensajeCopiado();
                })
                .catch(err => {
                    console.error('Error al copiar el RUC: ', err);
                });
        });
    });

    botonesCopiar2.forEach(boton => {
        boton.addEventListener('click', function() {
            const fila = this.closest('tr');
            const ruc = fila.querySelector('.ruc2').innerText.trim();
            
            navigator.clipboard.writeText(ruc)
                .then(() => {
                console.log('RUC copiado al portapapeles: ' + ruc);
                mostrarMensajeCopiado2();
                })
                .catch(err => {
                console.error('Error al copiar el RUC: ', err);
                });
        });
    });

    function mostrarMensajeCopiado2() {
        mensajeCopiado2.style.display = 'block';
        setTimeout(function() {
            mensajeCopiado2.style.display = 'none';
        }, 1500); // Ocultar el mensaje después de 1.5 segundos
    }

    function mostrarMensajeCopiado() {
        mensajeCopiado.style.display = 'block';
        setTimeout(function() {
            mensajeCopiado.style.display = 'none';
        }, 1500); // Ocultar el mensaje después de 1.5 segundos
    }
});
