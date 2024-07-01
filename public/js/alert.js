document.addEventListener("DOMContentLoaded", function() {
    // Obtener el botón de "Consultar"
    var consultarBtn = document.getElementById('consultarBtn');
    
    // Agregar un evento de clic al botón de "Consultar"
    consultarBtn.addEventListener('click', function() {
        // Obtener el valor del RUC ingresado
        var rucInput = document.getElementById('rucInput');
        var rucValue = rucInput.value.trim();

        // Verificar si se ingresó un RUC
        if (rucValue !== '') {
            // Realizar una solicitud AJAX para verificar si el RUC está registrado
            fetch('/verificar-ruc?ruc=' + rucValue)
                .then(response => response.json())
                .then(data => {
                    if (data.registrado) {
                        // Si el RUC está registrado, no hacer nada (o realizar alguna acción adicional)
                        // Aquí podrías habilitar otros campos del formulario, por ejemplo
                    } else {
                        // Si el RUC no está registrado, mostrar una alerta al usuario
                        alert('El RUC no está registrado. Por favor, regístrelo en la sección de Transportistas antes de continuar.');
                        // Mostrar el formulario de transportistas
                        document.getElementById('conductor-form').classList.add('show');
                    }
                })
                .catch(error => {
                    console.error('Error al verificar el RUC:', error);
                });
        } else {
            // Si no se ingresó un RUC, mostrar una alerta al usuario
            alert('Por favor, ingrese un RUC antes de consultar.');
        }
    });
});