<?php
/*
 * Si una vista no define $moduloActivo, se usa texto vacio.
 * Asi el menu funciona aunque ninguna opcion este seleccionada.
 */
$moduloActivo = $moduloActivo ?? "";
?>

<!-- Menu lateral principal. -->
<aside class="app-sidebar" data-menu-list>
    <!-- Cabecera con nombre del sistema y usuario conectado. -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
            </svg>
        </div>
        <div class="sidebar-title-info">
            <strong>SisAcadémico</strong>
            <small><?php echo h($_SESSION["usuario"]["nombre"]); ?></small>
        </div>
    </div>

    <!-- Navegacion principal del sistema. -->
    <nav class="sidebar-nav">
        <a class="<?php echo $moduloActivo === "menu" ? "active" : ""; ?>" href="index.php?accion=menu">
            <svg class="sidebar-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <span>Inicio</span>
        </a>
        <a class="<?php echo $moduloActivo === "estudiantes" ? "active" : ""; ?>" href="index.php?modulo=estudiante">
            <svg class="sidebar-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Estudiantes</span>
        </a>
        <a class="<?php echo $moduloActivo === "profesores" ? "active" : ""; ?>" href="index.php?modulo=profesor">
            <svg class="sidebar-icon" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Profesores</span>
        </a>
    </nav>

    <!-- Pie del menu con rol y cierre de sesion. -->
    <div class="sidebar-footer">
        <div class="footer-role">
            <small>Rol:</small>
            <span><?php echo h($_SESSION["usuario"]["rol"]); ?></span>
        </div>
        <a class="logout-btn" href="index.php?accion=logout">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            <span>Cerrar sesión</span>
        </a>
    </div>
</aside>
