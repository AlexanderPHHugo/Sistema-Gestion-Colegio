<?php
/*
 * Todas las pantallas pasan por aqui mediante la variable "accion" de la URL.
 * Ejemplo: index.php?accion=estudiantes
 */
require_once "config/Session.php";
require_once "controllers/AuthController.php";
require_once "controllers/EstudianteController.php";
require_once "controllers/ProfesorController.php";

// Inicia la sesion antes de decidir que pantalla mostrar.
iniciarSesionSegura();

/*
 * Obtiene el modulo seleccionado (por defecto "estudiante").
 */
$modulo = $_GET["modulo"] ?? "estudiante";

/*
 * Resuelve la accion principal.
 * - Si llega en la URL, se usa directamente.
 * - Si no llega, pero si el modulo (ej. modulo=profesor), asumimos "index" (listar).
 * - Si no hay nada, va al menu si ya inicio sesion, o a login.
 */
if (isset($_GET["accion"])) {
    $accion = $_GET["accion"];
} else {
    if (isset($_GET["modulo"])) {
        $accion = "index";
    } else {
        $accion = usuarioAutenticado() ? "menu" : "login";
    }
}

// Remapeo de acciones antiguas para compatibilidad
if ($accion === "estudiantes") {
    $modulo = "estudiante";
    $accion = "index";
} elseif ($accion === "profesores") {
    $modulo = "profesor";
    $accion = "index";
}

// Estas acciones se pueden usar sin haber iniciado sesion.
$accionesPublicas = ["login", "autenticar", "registro", "registrar"];

// Bloquea cualquier intento de entrar a modulos privados sin iniciar sesion.
if (!in_array($accion, $accionesPublicas) && !usuarioAutenticado()) {
    header("Location: index.php?accion=login");
    exit;
}

// El controlador de autenticacion se usa para login, registro, menu y logout.
$authController = new AuthController();

/*
 * Este switch funciona como un enrutador simple.
 * Segun la accion recibida, llama al metodo correspondiente del controlador.
 */
switch ($accion) {
    case "login":
        // Si ya inicio sesion, no tiene sentido volver al login.
        if (usuarioAutenticado()) {
            header("Location: index.php?accion=menu");
            exit;
        }
        $authController->login();
        break;

    case "autenticar":
        // Procesa el usuario y la contrasena enviados desde el login.
        $authController->autenticar();
        break;

    case "registro":
        // Muestra el formulario para crear una cuenta nueva.
        if (usuarioAutenticado()) {
            header("Location: index.php?accion=menu");
            exit;
        }
        $authController->registro();
        break;

    case "registrar":
        // Guarda un usuario nuevo si sus datos son validos.
        $authController->registrar();
        break;

    case "menu":
        // Pantalla principal del sistema despues del login.
        $authController->menu();
        break;

    case "logout":
        // Cierra la sesion actual.
        $authController->logout();
        break;

    case "index":
        if ($modulo === "profesor") {
            $controller = new ProfesorController();
        } else {
            $controller = new EstudianteController();
        }
        $controller->index();
        break;

    case "crear":
        if ($modulo === "profesor") {
            $controller = new ProfesorController();
        } else {
            $controller = new EstudianteController();
        }
        $controller->crear();
        break;

    case "guardar":
        if ($modulo === "profesor") {
            $controller = new ProfesorController();
        } else {
            $controller = new EstudianteController();
        }
        $controller->guardar();
        break;

    case "editar":
        if ($modulo === "profesor") {
            $controller = new ProfesorController();
        } else {
            $controller = new EstudianteController();
        }
        $controller->editar();
        break;

    case "actualizar":
        if ($modulo === "profesor") {
            $controller = new ProfesorController();
        } else {
            $controller = new EstudianteController();
        }
        $controller->actualizar();
        break;

    case "eliminar":
        if ($modulo === "profesor") {
            $controller = new ProfesorController();
        } else {
            $controller = new EstudianteController();
        }
        $controller->eliminar();
        break;

    default:
        echo "Accion no encontrada";
        break;
}