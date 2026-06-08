<?php
class Estudiante
{
    private $conn;
    private $tabla="estudiante";
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function listar()
    {
        $sql = "SELECT * FROM " . $this->tabla . " ORDER BY id DESC";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function guardar($dni,$nombre,$ape_paterno,$ape_materno,$direccion,$telefono,$semestre)
    {
        $sql = "INSERT INTO " . $this->tabla . "
                (dni,nombre,ape_paterno,ape_materno,direccion,telefono,semestre)
                VALUES
                (:dni,:nombre,:ape_paterno,:ape_materno,:direccion,:telefono,:semestre)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ":dni" => $dni,
            ":nombre" => $nombre,
            ":ape_paterno" => $ape_paterno,
            ":ape_materno" => $ape_materno,
            ":direccion" => $direccion,
            ":telefono" => $telefono,
            ":semestre" => $semestre,
        ]);

    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM " . $this->tabla . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":id" =>$id]);
        return $stmt->fetch();
    }

    public function actualizar($id,$dni,$nombre,$ape_paterno,$ape_materno,$direccion,$telefono,$semestre)
    {
        $sql = "UPDATE " . $this->tabla . "
                SET dni = :dni,
                    nombre = :nombre,
                    ape_paterno = :ape_paterno,
                    ape_materno = :ape_materno,
                    direccion = :direccion,
                    telefono = :telefono,
                    semestre = :semestre
                WHERE id = :id"; 
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ":id" => $id,
            ":dni" => $dni,
            ":nombre" => $nombre,
            ":ape_paterno" => $ape_paterno,
            ":ape_materno" => $ape_materno,
            ":direccion" => $direccion,
            ":telefono" => $telefono,
            ":semestre" => $semestre,
        ]);
    }

    public function eliminar ($id)
    {
        $sql = "DELETE FROM " . $this->tabla . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([":id"=>$id]);
    }

}
?>