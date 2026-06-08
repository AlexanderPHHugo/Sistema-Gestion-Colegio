document.addEventListener("DOMContentLoaded", function () {
    /*
     * Este archivo controla el menu lateral.
     * Se ejecuta cuando el HTML ya cargo completamente.
     */
    const layout = document.querySelector(".app-layout");
    const boton = document.querySelector("[data-menu-button]");

    // Si la vista no tiene menu lateral, el script no hace nada.
    if (!layout || !boton) {
        return;
    }

    function actualizarEstadoInicial() {
        /*
         * En escritorio el menu empieza abierto.
         * En movil empieza cerrado para no tapar el contenido.
         */
        const esMovil = window.matchMedia("(max-width: 800px)").matches;
        boton.setAttribute("aria-expanded", esMovil ? "false" : "true");
    }

    boton.addEventListener("click", function () {
        /*
         * Cuando se hace click:
         * - En movil se agrega/quita sidebar-open.
         * - En escritorio se agrega/quita sidebar-collapsed.
         */
        const esMovil = window.matchMedia("(max-width: 800px)").matches;

        if (esMovil) {
            const abierto = layout.classList.toggle("sidebar-open");
            boton.setAttribute("aria-expanded", String(abierto));
            return;
        }

        const colapsado = layout.classList.toggle("sidebar-collapsed");
        boton.setAttribute("aria-expanded", String(!colapsado));
    });

    actualizarEstadoInicial();
});

