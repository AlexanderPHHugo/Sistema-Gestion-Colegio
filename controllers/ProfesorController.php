<?php

require_once "config/Database.php";
require_once "config/helpers.php";
require_once "models/Profesor.php";

class ProfesorController
{
    private $modelo;

    public function __construct()
    {
        $database = new Database();
        $db = $database->conectar();

        $this->modelo = new Profesor($db);
    }

    public function index()
    {
        $profesores = $this->modelo->listar();
        require_once "views/Profesorview/index.php";
    }

    public function crear()
    {
        $errores = [];
        $datos = [];

        require_once "views/Profesorview/crear.php";
    }

    public function guardar()
    {
        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validarProfesor($datos);

        if (!empty($errores)) {
            require_once "views/Profesorview/crear.php";
            return;
        }

        try {
            $this->modelo->guardar(
                $datos["dni"],
                $datos["nombre"],
                $datos["ape_paterno"],
                $datos["ape_materno"],
                $this->valorOpcional($datos["direccion"]),
                $datos["especialidad"],
                $datos["correo"]
            );
        } catch (PDOException $e) {
            $errores[] = $this->mensajeErrorBaseDatos($e);
            require_once "views/Profesorview/crear.php";
            return;
        }

        header("Location: index.php?modulo=profesor");
        exit;
    }

    public function editar()
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if (!$id) {
            echo "ID no valido";
            return;
        }

        $profesor = $this->modelo->obtenerPorId($id);

        if (!$profesor) {
            echo "Profesor no encontrado";
            return;
        }

        $errores = [];
        $datos = $profesor;

        require_once "views/Profesorview/editar.php";
    }

    public function actualizar()
    {
        $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

        if (!$id) {
            echo "ID no valido";
            return;
        }

        $datos = $this->obtenerDatosFormulario();
        $datos["id"] = $id;
        $errores = $this->validarProfesor($datos);

        if (!empty($errores)) {
            require_once "views/Profesorview/editar.php";
            return;
        }

        try {
            $this->modelo->actualizar(
                $id,
                $datos["dni"],
                $datos["nombre"],
                $datos["ape_paterno"],
                $datos["ape_materno"],
                $this->valorOpcional($datos["direccion"]),
                $datos["especialidad"],
                $datos["correo"]
            );
        } catch (PDOException $e) {
            $errores[] = $this->mensajeErrorBaseDatos($e);
            require_once "views/Profesorview/editar.php";
            return;
        }

        header("Location: index.php?modulo=profesor");
        exit;
    }

    public function eliminar()
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if (!$id) {
            echo "ID no valido";
            return;
        }

        $this->modelo->eliminar($id);

        header("Location: index.php?modulo=profesor");
        exit;
    }

    private function obtenerDatosFormulario()
    {
        return [
            "dni" => trim($_POST["dni"] ?? ""),
            "nombre" => trim($_POST["nombre"] ?? ""),
            "ape_paterno" => trim($_POST["ape_paterno"] ?? ""),
            "ape_materno" => trim($_POST["ape_materno"] ?? ""),
            "direccion" => trim($_POST["direccion"] ?? ""),
            "especialidad" => trim($_POST["especialidad"] ?? ""),
            "correo" => trim($_POST["correo"] ?? ""),
        ];
    }

    private function validarProfesor($datos)
    {
        $errores = [];

        if (!preg_match("/^[0-9]{8}$/", $datos["dni"])) {
            $errores[] = "El DNI debe tener exactamente 8 digitos.";
        }

        $this->validarNombre($errores, $datos["nombre"], "El nombre", 80);
        $this->validarNombre($errores, $datos["ape_paterno"], "El apellido paterno", 80);
        $this->validarNombre($errores, $datos["ape_materno"], "El apellido materno", 80);

        if ($datos["direccion"] !== "" && strlen($datos["direccion"]) > 150) {
            $errores[] = "La direccion no debe superar 150 caracteres.";
        }

        if (empty(trim($datos["especialidad"]))) {
            $errores[] = "La especialidad es obligatoria.";
        } elseif (strlen($datos["especialidad"]) > 100) {
            $errores[] = "La especialidad no debe superar 100 caracteres.";
        } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/u", $datos["especialidad"])) {
            $errores[] = "La especialidad solo puede contener letras y espacios.";
        }

        if (empty(trim($datos["correo"]))) {
            $errores[] = "El correo es obligatorio.";
        } elseif (strlen($datos["correo"]) > 100) {
            $errores[] = "El correo no debe superar 100 caracteres.";
        } elseif (!filter_var($datos["correo"], FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo no tiene un formato válido.";
        }

        return $errores;
    }

    private function validarNombre(&$errores, $valor, $campo, $maximo)
    {
        // Nombres y apellidos aceptan letras y espacios, pero no numeros.
        if ($valor === "") {
            $errores[] = $campo . " es obligatorio.";
            return;
        }

        if (strlen($valor) > $maximo) {
            $errores[] = $campo . " no debe superar " . $maximo . " caracteres.";
        }

        if (!preg_match("/^[\p{L} ]+$/u", $valor)) {
            $errores[] = $campo . " solo debe contener letras y espacios.";
        }
    }

    private function valorOpcional($valor)
    {
        return $valor === "" ? null : $valor;
    }

    private function mensajeErrorBaseDatos($e)
    {
        if ($e->getCode() === "23000") {
            return "Ya existe un profesor registrado con ese DNI.";
        }

        return "No se pudo guardar la informacion. Intente nuevamente.";
    }
}