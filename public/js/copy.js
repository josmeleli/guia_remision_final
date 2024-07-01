const botonesCopiar = document.querySelectorAll('.boton-copiar');
const mensajeCopiado = document.getElementById('copiadoMensaje');

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

function mostrarMensajeCopiado() {
    mensajeCopiado.style.display = 'block';
    setTimeout(function() {
        mensajeCopiado.style.display = 'none';
    }, 1500); // Ocultar el mensaje después de 1.5 segundos
}