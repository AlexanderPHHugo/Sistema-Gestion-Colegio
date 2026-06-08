<?php

class Usuario
{
    // Conexion recibida desde Database.php.
    private $conn;

    // Nombre real de la tabla en MySQL.
    private $tabla = "usuario";

    public function __construct($db)
    {
        /*
         * El constructor recibe la conexion a MySQL.
         * Asi el modelo puede reutilizar la misma conexion en todos sus metodos.
         */
        $this->conn = $db;
    }

    public function obtenerPorUsuario($usuario)
    {
        /*
         * Busca un usuario por su nombre de usuario.
         * Se usa en el login para encontrar el hash de la contrasena.
         */
        $sql = "SELECT * FROM " . $this->tabla . " WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->conn->prepare($sql);

        /*
         * El parametro :usuario evita poner el texto directamente en el SQL.
         * Esto ayuda a proteger contra SQL Injection.
         */
        $stmt->execute([":usuario" => $usuario]);

        return $stmt->fetch();
    }

    public function guardar($datos)
    {
        /*
         * Registra un usuario nuevo.
         * La contrasena llega aqui ya encriptada desde AuthController.
         */
        $sql = "INSERT INTO " . $this->tabla . "
                (nombre, ape_pat, ape_mat, dni, usuario, password, rol)
                VALUES
                (:nombre, :ape_pat, :ape_mat, :dni, :usuario, :password, :rol)";

        $stmt = $this->conn->prepare($sql);

        // Ejecuta el INSERT reemplazando cada parametro por su valor.
        return $stmt->execute([
            ":nombre" => $datos["nombre"],
            ":ape_pat" => $datos["ape_pat"],
            ":ape_mat" => $datos["ape_mat"],
            ":dni" => $datos["dni"],
            ":usuario" => $datos["usuario"],
            ":password" => $datos["password"],
            ":rol" => $datos["rol"],
        ]);
    }
}
