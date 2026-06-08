<?php

require_once "config/Database.php";
require_once "config/helpers.php";
require_once "config/Session.php";
require_once "models/Usuario.php";

class AuthController
{
    private $modelo;

    public function __construct()
    {
        /*
         * Prepara el modelo Usuario.
         * Este modelo sera usado para buscar usuarios y registrar cuentas nuevas.
         */
        $database = new Database();
        $db = $database->conectar();

        $this->modelo = new Usuario($db);
    }

    public function login()
    {
        /*
         * Muestra el formulario de inicio de sesion.
         * Las variables se crean para que la vista pueda usarlas sin errores.
         */
        $errores = [];
        $usuario = "";

        require_once "views/auth/login.php";
    }

    public function registro()
    {
        /*
         * Muestra el formulario para crear usuario.
         * $datos guarda lo escrito si el formulario tiene errores.
         */
        $errores = [];
        $datos = [];

        require_once "views/auth/registro.php";
    }

    public function registrar()
    {
        /*
         * Procesa el formulario de registro.
         * Primero valida, luego encripta la contrasena y finalmente guarda.
         */
        $datos = $this->obtenerDatosRegistro();
        $errores = $this->validarRegistro($datos);

        if (!empty($errores)) {
            require_once "views/auth/registro.php";
            return;
        }

        /*
         * password_hash crea un hash seguro.
         * Nunca se guarda la contrasena escrita en texto normal.
         */
        $datos["password"] = password_hash($datos["password"], PASSWORD_DEFAULT);
        $datos["rol"] = "usuario";

        try {
            $this->modelo->guardar($datos);
        } catch (PDOException $e) {
            /*
             * Si MySQL rechaza el registro por DNI o usuario duplicado,
             * se muestra un mensaje claro al usuario.
             */
            $errores[] = $this->mensajeErrorRegistro($e);
            require_once "views/auth/registro.php";
            return;
        }

        header("Location: index.php?accion=login");
        exit;
    }

    public function autenticar()
    {
        /*
         * Procesa el login.
         * Recibe usuario y contrasena, busca el usuario y compara el hash.
         */
        $usuario = trim($_POST["usuario"] ?? "");
        $password = $_POST["password"] ?? "";
        $errores = [];

        if ($usuario === "" || $password === "") {
            $errores[] = "Ingrese usuario y contrasena.";
            require_once "views/auth/login.php";
            return;
        }

        $usuarioEncontrado = $this->modelo->obtenerPorUsuario($usuario);

        /*
         * password_verify compara:
         * - la contrasena escrita en el formulario
         * - el hash guardado en la base de datos
         */
        if (!$usuarioEncontrado || !password_verify($password, $usuarioEncontrado["password"])) {
            $errores[] = "Usuario o contrasena incorrectos.";
            require_once "views/auth/login.php";
            return;
        }

        /*
         * Cambia el ID de sesion despues de iniciar sesion.
         * Esto ayuda a evitar que se reutilice una sesion anterior.
         */
        session_regenerate_id(true);

        /*
         * Guarda solo datos necesarios en sesion.
         * No se guarda la contrasena ni el hash.
         */
        $_SESSION["usuario"] = [
            "id" => $usuarioEncontrado["id"],
            "nombre" => $usuarioEncontrado["nombre"],
            "usuario" => $usuarioEncontrado["usuario"],
            "rol" => $usuarioEncontrado["rol"],
        ];

        header("Location: index.php?accion=menu");
        exit;
    }

    public function menu()
    {
        /*
         * Muestra la pantalla principal.
         * protegerRuta impide entrar al menu sin iniciar sesion.
         */
        protegerRuta();
        require_once "views/menu.php";
    }

    public function logout()
    {
        /*
         * Cierra sesion.
         * Se limpian datos de $_SESSION, cookie y sesion del servidor.
         */
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                "",
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        header("Location: index.php?accion=login");
        exit;
    }

    private function obtenerDatosRegistro()
    {
        /*
         * Centraliza la lectura del formulario de registro.
         * trim quita espacios sobrantes al inicio y final.
         */
        return [
            "nombre" => trim($_POST["nombre"] ?? ""),
            "ape_pat" => trim($_POST["ape_pat"] ?? ""),
            "ape_mat" => trim($_POST["ape_mat"] ?? ""),
            "dni" => trim($_POST["dni"] ?? ""),
            "usuario" => trim($_POST["usuario"] ?? ""),
            "password" => $_POST["password"] ?? "",
            "password_confirmacion" => $_POST["password_confirmacion"] ?? "",
        ];
    }

    private function validarRegistro($datos)
    {
        /*
         * Valida todas las reglas para crear usuario.
         * Si algo esta mal, agrega mensajes al arreglo $errores.
         */
        $errores = [];

        $this->validarNombre($errores, $datos["nombre"], "El nombre");
        $this->validarNombre($errores, $datos["ape_pat"], "El apellido paterno");
        $this->validarNombre($errores, $datos["ape_mat"], "El apellido materno");

        if (!preg_match("/^[0-9]{8}$/", $datos["dni"])) {
            $errores[] = "El DNI debe tener exactamente 8 digitos.";
        }

        if (!preg_match("/^[A-Za-z0-9_]{4,50}$/", $datos["usuario"])) {
            $errores[] = "El usuario debe tener de 4 a 50 caracteres, usando letras, numeros o guion bajo.";
        }

        /*
         * Regla de contrasena fuerte:
         * minimo 8 caracteres, una minuscula, una mayuscula, un numero y un simbolo.
         */
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/", $datos["password"])) {
            $errores[] = "La contrasena debe tener minimo 8 caracteres, mayuscula, minuscula, numero y simbolo.";
        }

        if ($datos["password"] !== $datos["password_confirmacion"]) {
            $errores[] = "Las contrasenas no coinciden.";
        }

        return $errores;
    }

    private function validarNombre(&$errores, $valor, $campo)
    {
        /*
         * Valida nombres y apellidos de usuarios.
         * Acepta letras y espacios, pero no numeros.
         */
        if ($valor === "") {
            $errores[] = $campo . " es obligatorio.";
            return;
        }

        if (strlen($valor) > 80) {
            $errores[] = $campo . " no debe superar 80 caracteres.";
        }

        if (!preg_match("/^[\p{L} ]+$/u", $valor)) {
            $errores[] = $campo . " solo debe contener letras y espacios.";
        }
    }

    private function mensajeErrorRegistro($e)
    {
        /*
         * El codigo 23000 suele indicar duplicados en campos UNIQUE,
         * como dni o usuario.
         */
        if ($e->getCode() === "23000") {
            return "El DNI o usuario ya se encuentra registrado.";
        }

        return "No se pudo registrar el usuario. Intente nuevamente.";
    }
}
