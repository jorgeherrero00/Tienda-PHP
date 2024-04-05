<?php

namespace Models;
use Lib\BaseDatos;
use PDO;
class Producto
{
    private int $id;
    private int $categoriaId;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private int $stock;
    private string $oferta;
    private string $fecha;
    private string $imagen;

    private BaseDatos $db;

    public function __construct() {
        // Initialize the $db property here
        $this->db = new BaseDatos();
    }
    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of categoriaId
     *
     * @return int
     */
    public function getCategoriaId(): int {
        return $this->categoriaId;
    }

    /**
     * Set the value of categoriaId
     *
     * @param int $categoriaId
     *
     * @return self
     */
    public function setCategoriaId(int $categoriaId): self {
        $this->categoriaId = $categoriaId;
        return $this;
    }

    /**
     * Get the value of nombre
     *
     * @return string
     */
    public function getNombre(): string {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @param string $nombre
     *
     * @return self
     */
    public function setNombre(string $nombre): self {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Get the value of descripcion
     *
     * @return string
     */
    public function getDescripcion(): string {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @param string $descripcion
     *
     * @return self
     */
    public function setDescripcion(string $descripcion): self {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * Get the value of precio
     *
     * @return float
     */
    public function getPrecio(): float {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @param float $precio
     *
     * @return self
     */
    public function setPrecio(float $precio): self {
        $this->precio = $precio;
        return $this;
    }

    /**
     * Get the value of stock
     *
     * @return int
     */
    public function getStock(): int {
        return $this->stock;
    }

    /**
     * Set the value of stock
     *
     * @param int $stock
     *
     * @return self
     */
    public function setStock(int $stock): self {
        $this->stock = $stock;
        return $this;
    }

    /**
     * Get the value of oferta
     *
     * @return string
     */
    public function getOferta(): string {
        return $this->oferta;
    }

    /**
     * Set the value of oferta
     *
     * @param string $oferta
     *
     * @return self
     */
    public function setOferta(string $oferta): self {
        $this->oferta = $oferta;
        return $this;
    }

    /**
     * Get the value of fecha
     *
     * @return string
     */
    public function getFecha(): string {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @param string $fecha
     *
     * @return self
     */
    public function setFecha(string $fecha): self {
        $this->fecha = $fecha;
        return $this;
    }

    /**
     * Get the value of imagen
     *
     * @return string
     */
    public function getImagen(): string {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     *
     * @param string $imagen
     *
     * @return self
     */
    public function setImagen(string $imagen): self {
        $this->imagen = $imagen;
        return $this;
    }


    public static function getAll() {
        $producto = new Producto();
        $producto->db->consulta("SELECT * FROM productos ORDER BY id DESC");
        $productos = $producto->db->extraer_todos();
        $producto->db->close();
        return $productos;
    }

    public function crearProducto($nombre, $descripcion, $categoria, $precio, $stock, $oferta, $fecha, $imagen) {
        $producto = new Producto();
    try {
            $insert = $this->db->prepara('INSERT INTO productos (categoria_Id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES (:categoria, :nombre, :descripcion, :precio, :stock, :oferta, NOW(), :imagen)');
            $insert->bindValue(':categoria', $categoria, PDO::PARAM_INT);
            $insert->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $insert->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
            $insert->bindValue(':precio', $precio);
            $insert->bindValue(':stock', $stock, PDO::PARAM_INT);
            $insert->bindValue(':oferta', $oferta, PDO::PARAM_STR);
            $insert->bindValue(':imagen', $imagen, PDO::PARAM_STR);


            $insert->execute();
            $insert->closeCursor();
        $producto->db->close();

        $resultado = true;
        header("Location: ".BASE_URL);
    } catch (PDOException $err) {
        echo "Error en la inserción: " . $err->getMessage();
        $resultado = false;
    }
    return $resultado;


}
public static function getProductosByCategoria($categoriaId) {
    $producto = new Producto();
    try {
        $select = $producto->db->prepara('SELECT * FROM productos WHERE categoria_Id = :categoriaId ORDER BY id DESC');
        $select->bindValue(':categoriaId', $categoriaId, PDO::PARAM_INT);
        $select->execute();
        $productos = $select->fetchAll(PDO::FETCH_ASSOC);
        $select->closeCursor();
        $producto->db->close();
        return $productos;
    } catch (PDOException $err) {
        echo "Error en la consulta: " . $err->getMessage();
        return false;
    }

    
}
public function getStockById($id) {
    try {
        $select = $this->db->prepara('SELECT stock FROM productos WHERE id = :id');
        $select->bindValue(':id', $id, PDO::PARAM_INT);
        $select->execute();
        $stock = $select->fetch(PDO::FETCH_ASSOC)['stock'];
        $select->closeCursor();

        return $stock;
    } catch (PDOException $err) {
        echo "Error en la consulta de stock por ID: " . $err->getMessage();
        return false;
    }
}

public function actualizarStock($id, $nuevoStock) {
    try {
        $update = $this->db->prepara('UPDATE productos SET stock = :nuevoStock WHERE id = :id');
        $update->bindValue(':nuevoStock', $nuevoStock, PDO::PARAM_INT);
        $update->bindValue(':id', $id, PDO::PARAM_INT);

        $update->execute();
        $update->closeCursor();

        $resultado = true;
    } catch (PDOException $err) {
        echo "Error en la actualización del stock: " . $err->getMessage();
        $resultado = false;
    }

    return $resultado;
}
public function actualizarProducto($id, $nombre, $descripcion, $categoria, $precio, $stock, $oferta, $fecha, $imagen) {
    try {
        $update = $this->db->prepara('UPDATE productos SET categoria_id = :categoria, nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, oferta = :oferta, fecha = NOW(), imagen = :imagen WHERE id = :id');
        $update->bindValue(':categoria', $categoria, PDO::PARAM_INT);
        $update->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $update->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
        $update->bindValue(':precio', $precio);
        $update->bindValue(':stock', $stock, PDO::PARAM_INT);
        $update->bindValue(':oferta', $oferta, PDO::PARAM_STR);
        $update->bindValue(':imagen', $imagen, PDO::PARAM_STR);
        $update->bindValue(':id', $id, PDO::PARAM_INT);

        $update->execute();
        $update->closeCursor();
        $this->db->close();

        $resultado = true;
    } catch (PDOException $err) {
        echo "Error en la actualización: " . $err->getMessage();
        $resultado = false;
    }
    return $resultado;
}

/**
 * Obtiene la ruta de la imagen de un producto por su ID.
 *
 * @param int $id ID del producto.
 * @return string|false Ruta de la imagen o false si no se encuentra el producto.
 */
public function getImagenById($id) {
    try {
        $select = $this->db->prepara('SELECT imagen FROM productos WHERE id = :id');
        $select->bindValue(':id', $id, PDO::PARAM_INT);
        $select->execute();
        $imagen = $select->fetch(PDO::FETCH_ASSOC)['imagen'];
        $select->closeCursor();

        return $imagen;
    } catch (PDOException $err) {
        echo "Error en la consulta de imagen por ID: " . $err->getMessage();
        return false;
    }
}


public static function getProductoById($id) {
    $producto = new Producto();
    try {
        $select = $producto->db->prepara('SELECT * FROM productos WHERE id = :id');
        $select->bindValue(':id', $id, PDO::PARAM_INT);
        $select->execute();
        $productoDetails = $select->fetch(PDO::FETCH_ASSOC);
        $select->closeCursor();
        $producto->db->close();
        return $productoDetails;
    } catch (PDOException $err) {
        echo "Error en la consulta: " . $err->getMessage();
        return false;
    }
}

public function eliminarProducto($id){
    try {
        $delete = $this->db->prepara('DELETE FROM productos WHERE id = :id');
        $delete->bindValue(':id', $id, PDO::PARAM_INT);
        $delete->execute();
        $delete->closeCursor();
        $this->db->close();

        $resultado = true;
    } catch (PDOException $err) {
        echo "Error en la eliminación: " . $err->getMessage();
        $resultado = false;
    }
    return $resultado;
}



    
}