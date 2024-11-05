document.addEventListener('DOMContentLoaded', function() {
    const botonesCopiar = document.querySelectorAll('.boton-copiar');
    const botonesCopiar2 = document.querySelectorAll('.boton-copiar2');
    const mensajeCopiado = document.getElementById('copiadoMensaje');
    const mensajeCopiado2 = document.getElementById('copiadoMensaje2');

    function agregarEventoCopiar(botones, claseRUC, mostrarMensaje) {
        botones.forEach(boton => {
            boton.addEventListener('click', function() {
                const fila = this.closest('tr');
                const ruc = fila.querySelector(claseRUC).innerText.trim();
                
                navigator.clipboard.writeText(ruc)
                    .then(() => {
                        console.log('RUC copiado al portapapeles: ' + ruc);
                        mostrarMensaje();
                    })
                    .catch(err => {
                        console.error('Error al copiar el RUC: ', err);
                    });
            });
        });
    }

    function mostrarMensajeCopiado(mensaje) {
        mensaje.style.display = 'block';
        setTimeout(function() {
            mensaje.style.display = 'none';
        }, 1500); // Ocultar el mensaje después de 1.5 segundos
    }

    agregarEventoCopiar(botonesCopiar, '.ruc', () => mostrarMensajeCopiado(mensajeCopiado));
    agregarEventoCopiar(botonesCopiar2, '.ruc2', () => mostrarMensajeCopiado(mensajeCopiado2));
});