document.addEventListener("DOMContentLoaded", function () {
    // Cantidad de estudiantes que se muestran en cada pagina de la tabla.
    const filasPorPagina = 10;

    // Elementos de la vista que se van a controlar desde JavaScript.
    const input = document.getElementById("buscarEstudiante") || document.getElementById("buscarProfesor");
    if (!input) return; // Salir si no hay input de búsqueda en la página actual

    const filaSinResultados = document.getElementById("filaSinResultados");
    const paginacion = document.getElementById("paginacionTabla");
    const botonAnterior = document.getElementById("paginaAnterior");
    const botonSiguiente = document.getElementById("paginaSiguiente");

    const selector = document.getElementById("tablaEstudiantes") ? "#tablaEstudiantes tr[data-busqueda]" : "#tablaProfesores tr[data-busqueda]";
    const filas = Array.from(document.querySelectorAll(selector));

    let paginaActual = 1;
    let filasFiltradas = filas;

    function normalizar(texto) {
        // Convierte el texto a una forma mas facil de comparar.
        return texto
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .trim();
    }

    function obtenerIniciales(texto) {
        // Crea iniciales como "jp" para "Juan Perez".
        return normalizar(texto)
            .split(/\s+/)
            .filter(Boolean)
            .map(function (palabra) {
                return palabra.charAt(0);
            })
            .join("");
    }

    function coincide(texto, busqueda) {
        // Revisa si la busqueda coincide con el nombre, apellido o iniciales.
        const textoNormalizado = normalizar(texto);
        const palabras = textoNormalizado.split(/\s+/).filter(Boolean);
        const iniciales = obtenerIniciales(texto);

        return textoNormalizado.includes(busqueda)
            || iniciales.startsWith(busqueda)
            || palabras.some(function (palabra) {
                return palabra.startsWith(busqueda);
            });
    }

    function mostrarPagina() {
        // Oculta todas las filas y luego muestra solo las de la pagina actual.
        const totalPaginas = Math.ceil(filasFiltradas.length / filasPorPagina);
        const inicio = (paginaActual - 1) * filasPorPagina;
        const fin = inicio + filasPorPagina;

        filas.forEach(function (fila) {
            fila.hidden = true;
        });

        filasFiltradas.slice(inicio, fin).forEach(function (fila) {
            fila.hidden = false;
        });

        filaSinResultados.hidden = filasFiltradas.length > 0;
        paginacion.hidden = totalPaginas <= 1;
        botonAnterior.disabled = paginaActual <= 1;
        botonSiguiente.disabled = paginaActual >= totalPaginas;
    }

    function filtrarEstudiantes() {
        // Cada vez que se escribe, se recalcula que filas coinciden.
        const busqueda = normalizar(input.value);

        filasFiltradas = filas.filter(function (fila) {
            const texto = fila.dataset.busqueda || "";
            return busqueda === "" || coincide(texto, busqueda);
        });

        paginaActual = 1;
        mostrarPagina();
    }

    botonAnterior.addEventListener("click", function () {
        if (paginaActual > 1) {
            paginaActual--;
            mostrarPagina();
        }
    });

    botonSiguiente.addEventListener("click", function () {
        const totalPaginas = Math.ceil(filasFiltradas.length / filasPorPagina);

        if (paginaActual < totalPaginas) {
            paginaActual++;
            mostrarPagina();
        }
    });

    input.addEventListener("input", filtrarEstudiantes);
    filtrarEstudiantes();
});