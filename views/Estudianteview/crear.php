<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar estudiante</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/menu.js" defer></script>
</head>
<body>
    <div class="app-layout">
        <?php
        $moduloActivo = "estudiantes";
        require "views/Partials/sidebar.php";
        ?>

        <main class="app-content">
            <!-- Barra superior del contenido. -->
            <header class="app-topbar">
                <button class="hamburger-button" type="button" data-menu-button aria-expanded="true" aria-label="Abrir menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <h1>Estudiantes</h1>
            </header>

            <div class="container">
                <!-- Titulo de la pantalla de registro. -->
                <div class="page-header">
                    <h2>Registrar estudiante</h2>
                </div>

                <!-- Mensajes que explican que campos deben corregirse. -->
                <?php if (!empty($errores)): ?>
                    <div class="error-box">
                        <strong>Corrige los siguientes errores:</strong>
                        <ul>
                            <?php foreach ($errores as $error): ?>
                                <li><?php echo h($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Formulario que envia la informacion para crear un estudiante. -->
                <form class="form-card" action="index.php?modulo=estudiante&accion=guardar" method="POST">

                    <div class="form-group">
                        <label>DNI:</label>
                        <input
                            type="text"
                            name="dni"
                            value="<?php echo h($datos["dni"] ?? ""); ?>"
                            required
                            minlength="8"
                            maxlength="8"
                            pattern="[0-9]{8}"
                            title="Ingrese exactamente 8 dígitos">
                    </div>

                    <div class="form-group">
                        <label>Nombre:</label>
                        <input
                            type="text"
                            name="nombre"
                            value="<?php echo h($datos["nombre"] ?? ""); ?>"
                            required
                            maxlength="80"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                            title="Ingrese solo letras y espacios">
                    </div>

                    <div class="form-group">
                        <label>Apellido paterno:</label>
                        <input
                            type="text"
                            name="ape_paterno"
                            value="<?php echo h($datos["ape_paterno"] ?? ""); ?>"
                            required
                            maxlength="80"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                            title="Ingrese solo letras y espacios">
                    </div>

                    <div class="form-group">
                        <label>Apellido materno:</label>
                        <input
                            type="text"
                            name="ape_materno"
                            value="<?php echo h($datos["ape_materno"] ?? ""); ?>"
                            required
                            maxlength="80"
                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ ]+"
                            title="Ingrese solo letras y espacios">
                    </div>

                    <div class="form-group">
                        <label>Dirección:</label>
                        <input
                            type="text"
                            name="direccion"
                            value="<?php echo h($datos["direccion"] ?? ""); ?>"
                            maxlength="150">
                    </div>

                    <div class="form-group">
                        <label>Teléfono:</label>
                        <input
                            type="text"
                            name="telefono"
                            value="<?php echo h($datos["telefono"] ?? ""); ?>"
                            minlength="6"
                            maxlength="15"
                            pattern="[0-9]{6,15}"
                            title="Ingrese entre 6 y 15 dígitos">
                    </div>

                    <div class="form-group">
                        <label>Semestre:</label>
                        <input
                            type="number"
                            name="semestre"
                            value="<?php echo h($datos["semestre"] ?? ""); ?>"
                            required
                            min="1"
                            max="10">
                    </div>

                    <!-- Botones principales del formulario. -->
                    <div class="form-actions">
                        <button class="button" type="submit">Guardar</button>
                        <a class="button button-secondary" href="index.php?modulo=estudiante">Cancelar</a>
                    </div>

                </form>
            </div>
        </main>
    </div>
</body>
</html>