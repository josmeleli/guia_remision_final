function cambiarTipoFiltro() {
    var filtro = document.getElementById("filtro").value;
    var contenedorFecha = document.getElementById("contenedorFecha");
    var contenedorTexto = document.getElementById("contenedorTexto");
    var contenedorEstado = document.getElementById("contenedorEstado");

    if (filtro === "fecha") {
        contenedorFecha.style.display = "block";
        contenedorTexto.style.display = "none";
        contenedorEstado.style.display = "none";
    } else if (filtro === "estado") {
        contenedorFecha.style.display = "none";
        contenedorTexto.style.display = "none";
        contenedorEstado.style.display = "block";
    } else {
        contenedorFecha.style.display = "none";
        contenedorTexto.style.display = "block";
        contenedorEstado.style.display = "none";
    }
}

function limpiarCampos() {
    // Restablecer valores de los campos de filtro
    document.getElementById("filtro").selectedIndex = 0;
    document.getElementById("fecha").value = "";
    document.getElementById("texto").value = "";
    document.getElementById("estado").value = "";

    // Mostrar todas las filas de la tabla
    var tabla = document.getElementById('tablaGuias');
    var filas = tabla.getElementsByTagName('tr');
    for (var i = 1; i < filas.length; i++) {
        filas[i].style.display = '';
    }
}

// Función para realizar el filtrado
document.getElementById('filtro').addEventListener('change', function() {
    cambiarTipoFiltro();
    filtrarTabla();
});

document.getElementById('texto').addEventListener('input', function() {
    filtrarTabla();
});

document.getElementById('fecha').addEventListener('input', function() {
    filtrarTabla();
});

document.getElementById('estado').addEventListener('change', function() {
    filtrarTabla();
});

function filtrarTabla() {
    var filtro = document.getElementById('filtro').value;
    var valorFiltro;
    if (filtro === 'fecha') {
        valorFiltro = document.getElementById('fecha').value.trim().toLowerCase();
    } else if (filtro === 'estado') {
        // Obtener el texto del elemento de opción seleccionado
        var selectEstado = document.getElementById('estado');
        valorFiltro = selectEstado.options[selectEstado.selectedIndex].text.trim().toLowerCase();
    } else {
        valorFiltro = document.getElementById('texto').value.trim().toLowerCase();
    }
    var tabla = document.getElementById('tablaGuias');
    var filas = tabla.getElementsByTagName('tr');

    for (var i = 1; i < filas.length; i++) { // Empezamos desde 1 para omitir la fila de encabezado
        var filaVisible = false;
        var celdas = filas[i].getElementsByTagName('td');
        for (var j = 0; j < celdas.length; j++) {
            var textoCelda = celdas[j].innerText.toLowerCase();
            if (filtro === 'fecha') {
                // Filtrar por fecha si se selecciona el filtro de fecha
                if (textoCelda.includes(valorFiltro)) {
                    filaVisible = true;
                    break;
                }
            } else if (filtro === 'estado') {
                // Filtrar por estado si se selecciona el filtro de estado
                if (textoCelda === valorFiltro) {
                    filaVisible = true;
                    break;
                }
            } else {
                // Filtrar por texto en caso contrario
                if (textoCelda.includes(valorFiltro)) {
                    filaVisible = true;
                    break;
                }
            }
        }
        // Mostrar u ocultar la fila según el resultado del filtro
        filas[i].style.display = filaVisible ? '' : 'none';
    }
}