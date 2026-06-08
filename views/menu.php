<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menu principal</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/menu.js" defer></script>
</head>
<body>
    <div class="app-layout">
        <?php
        /*
         * $moduloActivo indica al menu lateral que opcion debe resaltarse.
         * sidebar.php es compartido por menu y modulos internos.
         */
        $moduloActivo = "menu";
        require "views/partials/sidebar.php";
        ?>

        <main class="app-content">
            <!-- Barra superior del contenido. El boton hamburguesa colapsa el menu lateral. -->
            <header class="app-topbar">
                <button class="hamburger-button" type="button" data-menu-button aria-expanded="true" aria-label="Abrir menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <h1>Menu principal</h1>
            </header>

            <!-- Panel de bienvenida del sistema. -->
            <section class="dashboard-panel">
                <h2>Modulos del sistema</h2>
                <p>Selecciona un modulo desde el menu lateral para empezar a trabajar.</p>
            </section>

            <!-- Tarjetas de modulos. Luego puedes agregar Profesor, Curso, etc. -->
            <section class="menu-grid">
                <a class="menu-option" href="index.php?modulo=estudiante">
                    <span>Estudiantes</span>
                    <small>Registrar, editar, buscar y eliminar estudiantes.</small>
                </a>
                <a class="menu-option" href="index.php?modulo=profesor">
                    <span>Profesores</span>
                    <small>Registrar, editar, buscar y eliminar profesores.</small>
                </a>
            </section>
        </main>
    </div>
</body>
</html>