<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de profesores</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/menu.js" defer></script>
    <script src="assets/js/busqueda.js" defer></script>
</head>
<body>
    <div class="app-layout">
        <?php
        $moduloActivo = "profesores";
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
                <h1>Profesores</h1>
            </header>

            <div class="container">
                <!-- Encabezado principal y boton para abrir el formulario de registro. -->
                <div class="page-header">
                    <h2>Lista de profesores SENATINO</h2>

                    <div class="actions">
                        <a class="button button-secondary" href="index.php?modulo=estudiante">
                            Ver estudiantes
                        </a>

                        <a class="button" href="index.php?modulo=profesor&accion=crear">
                            Nuevo profesor
                        </a>
                    </div>
                </div>

                <!-- Campo usado por JavaScript para filtrar los profesores visibles. -->
                <section class="search-panel">
                    <div class="search-group">
                        <label for="buscarProfesor">Búsqueda:</label>
                        <input
                            type="search"
                            id="buscarProfesor"
                            placeholder="Ejemplo: juan, perez o jp"
                            autocomplete="off">
                    </div>
                </section>

                <!-- Tabla principal con todos los profesores cargados desde MySQL. -->
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
                                <th>Correo</th>
                                <th>Especialidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaProfesores">
                            <?php foreach ($profesores as $profesor): ?>
                                <!-- data-busqueda guarda el texto que se revisa al escribir en el buscador. -->
                                <tr data-busqueda="<?php echo h($profesor["nombre"] . " " . $profesor["ape_paterno"] . " " . $profesor["ape_materno"] . " " . $profesor["especialidad"]); ?>">
                                    <td><?php echo h($profesor["id"]); ?></td>
                                    <td><?php echo h($profesor["dni"]); ?></td>
                                    <td><?php echo h($profesor["nombre"]); ?></td>
                                    <td><?php echo h($profesor["ape_paterno"]); ?></td>
                                    <td><?php echo h($profesor["ape_materno"]); ?></td>
                                    <td><?php echo h($profesor["direccion"]); ?></td>
                                    <td><?php echo h($profesor["correo"]); ?></td>
                                    <td><?php echo h($profesor["especialidad"]); ?></td>
                                    <td>
                                        <div class="actions">
                                            <a class="action-button action-edit" href="index.php?modulo=profesor&accion=editar&id=<?php echo h($profesor["id"]); ?>">
                                                Editar
                                            </a>
                                            <a class="action-button action-delete" href="index.php?modulo=profesor&accion=eliminar&id=<?php echo h($profesor["id"]); ?>"
                                                onclick="return confirm('¿Está seguro de eliminar este profesor?')">
                                                Eliminar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <!-- Esta fila aparece cuando la busqueda no encuentra coincidencias. -->
                            <tr class="empty-row" id="filaSinResultados" hidden>
                                <td colspan="9">No se encontraron profesores con esa búsqueda.</td>
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