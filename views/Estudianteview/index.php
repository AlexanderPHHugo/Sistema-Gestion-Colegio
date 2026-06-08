<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de estudiantes</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/menu.js" defer></script>
    <script src="assets/js/busqueda.js" defer></script>
</head>
<body>
    <div class="app-layout">
        <?php
        $moduloActivo = "estudiantes";
        require "views/Partials/sidebar.php";
        ?>

        <main class="app-content">
            <!-- Barra superior del contenido. El boton hamburguesa colapsa el menu lateral. -->
            <header class="app-topbar">
                <button class="hamburger-button" type="button" data-menu-button aria-expanded="true" aria-label="Abrir menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <h1>Estudiantes</h1>
            </header>

            <div class="container">
                <!-- Encabezado principal y boton para abrir el formulario de registro. -->
                <div class="page-header">
                    <h2>Lista de estudiantes SENATINO</h2>

                    <div class="actions">
                        <a class="button button-secondary" href="index.php?modulo=profesor">
                            Ver profesores
                        </a>

                        <a class="button" href="index.php?modulo=estudiante&accion=crear">
                            Nuevo estudiante
                        </a>
                    </div>
                </div>

                <!-- Campo usado por JavaScript para filtrar los estudiantes visibles. -->
                <section class="search-panel">
                    <div class="search-group">
                        <label for="buscarEstudiante">Búsqueda:</label>
                        <input
                            type="search"
                            id="buscarEstudiante"
                            placeholder="Ejemplo: juan, perez o jp"
                            autocomplete="off">
                    </div>
                </section>

                <!-- Tabla principal con todos los estudiantes cargados desde MySQL. -->
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>DNI</th>
                                <th>Nombre</th>
                                <th>Apellido paterno</th>
                                <th>Apellido materno</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Semestre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaEstudiantes">
                            <?php foreach ($estudiantes as $estudiante): ?>
                                <!-- data-busqueda guarda el texto que se revisa al escribir en el buscador. -->
                                <tr data-busqueda="<?php echo h($estudiante["nombre"] . " " . $estudiante["ape_paterno"] . " " . $estudiante["ape_materno"]); ?>">
                                    <td><?php echo h($estudiante["id"]); ?></td>
                                    <td><?php echo h($estudiante["dni"]); ?></td>
                                    <td><?php echo h($estudiante["nombre"]); ?></td>
                                    <td><?php echo h($estudiante["ape_paterno"]); ?></td>
                                    <td><?php echo h($estudiante["ape_materno"]); ?></td>
                                    <td><?php echo h($estudiante["direccion"]); ?></td>
                                    <td><?php echo h($estudiante["telefono"]); ?></td>
                                    <td><?php echo h($estudiante["semestre"]); ?></td>
                                    <td>
                                        <div class="actions">
                                            <a class="action-button action-edit" href="index.php?modulo=estudiante&accion=editar&id=<?php echo h($estudiante["id"]); ?>">
                                                Editar
                                            </a>
                                            <a class="action-button action-delete" href="index.php?modulo=estudiante&accion=eliminar&id=<?php echo h($estudiante["id"]); ?>"
                                                onclick="return confirm('¿Está seguro de eliminar este estudiante?')">
                                                Eliminar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <!-- Esta fila aparece cuando la busqueda no encuentra coincidencias. -->
                            <tr class="empty-row" id="filaSinResultados" hidden>
                                <td colspan="9">No se encontraron estudiantes con esa búsqueda.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Botones manejados por JavaScript para mostrar 10 registros por pagina. -->
                <div class="pagination" id="paginacionTabla" hidden>
                    <button class="button button-secondary" type="button" id="paginaAnterior">Anterior</button>
                    <button class="button button-secondary" type="button" id="paginaSiguiente">Siguiente</button>
                </div>
            </div>
        </main>
    </div>
</body>
</html>