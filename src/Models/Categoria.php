<?php

namespace Models;
use Lib\BaseDatos;
use PDO;
class Categoria{

    private $id;
    private $nombre;
    private BaseDatos $db;

    public function __construct(){
        $this->db = new BaseDatos();
    }

    


    /**
     * Get the value of id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre($nombre): self {
        $this->nombre = $nombre;
        return $this;
    }


    public static function getAll(){

        $categoria = new Categoria();
        $categoria->db->consulta("SELECT * FROM categorias ORDER BY id DESC");
        $categorias = $categoria->db->extraer_todos();
        $categoria->db->close();
        return $categorias;
    }
    public static function listarCategorias() {
        $categoria = new Categoria();
        $categoria->db->consulta("SELECT * FROM categorias ORDER BY id DESC");
        $categorias = $categoria->db->extraer_todos();
        $categoria->db->close();
        return $categorias;
    }
    public function crearCategoria($nombre){
        $categoria = new Categoria();
        try {
            $stmt=$categoria->db->prepara('SELECT * FROM categorias where nombre=:nombre');
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount()==0){
                $insert=$categoria->db->prepara('INSERT INTO categorias VALUES(null, :nombre)');
                $insert->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $insert->execute();
                $insert->closeCursor();
            }

            $stmt->closeCursor();
            $categoria->db->close();
            $resultado = true;

        } catch (PDOException $err){
            $resultado=false;
        }

        return $resultado;    
    }

    public static function getCategoriaById($id) {
        $categoria = new Categoria();
        try {
            $select = $categoria->db->prepara('SELECT * FROM categorias WHERE id = :id');
            $select->bindValue(':id', $id, PDO::PARAM_INT);
            $select->execute();
            $categoriaDetails = $select->fetch(PDO::FETCH_ASSOC);
            $select->closeCursor();
            $categoria->db->close();
            return $categoriaDetails;
        } catch (PDOException $err) {
            echo "Error en la consulta: " . $err->getMessage();
            return false;
        }
    }

    public function actualizarCategoria($id, $nombre) {
        try {
            $stmt = $this->db->prepara('UPDATE categorias SET nombre = :nombre WHERE id = :id');
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
            $this->db->close();
            $resultado = true;
        } catch (PDOException $err) {
            $resultado = false;
        }
        return $resultado;
    }

    public function eliminarCategoria($id){
        try {
            $producto = new Producto();
            $productos = $producto->getProductosByCategoria($id);

            // Elimina cada producto asociado
            foreach ($productos as $prod) {
                $producto->eliminarProducto($prod['id']);
            }

            $delete = $this->db->prepara('DELETE FROM categorias WHERE id = :id');
            $delete->bindValue(':id', $id, PDO::PARAM_INT);
            $delete->execute();
            $delete->closeCursor();
    
            $resultado = true;
        } catch (PDOException $err) {
            echo "Error en la eliminación: " . $err->getMessage();
            $resultado = false;
        }
        return $resultado;
    }
}