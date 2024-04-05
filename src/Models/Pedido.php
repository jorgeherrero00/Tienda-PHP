<?php

namespace Models;
use Lib\BaseDatos;
use PDO;
class Pedido {
    private $id;
    private $usuarioId;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;

    public function __construct() {
        $this->db = new BaseDatos();
    }

    // Getter methods
    public function getId() {
        return $this->id;
    }

    public function getUsuarioId() {
        return $this->usuarioId;
    }

    public function getProvincia() {
        return $this->provincia;
    }

    public function getLocalidad() {
        return $this->localidad;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getCoste() {
        return $this->coste;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getHora() {
        return $this->hora;
    }
    public function crearPedido($usuario_id, $provincia, $localidad, $direccion, $coste, $estado){
        $pedido = new Pedido();
    try {
            $insert = $this->db->prepara('INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES ( :usuario_id, :provincia, :localidad, :direccion, :coste, :estado, NOW(), current_Time)');
            $insert->bindValue(':usuario_id', $usuario_id, PDO::PARAM_STR);
            $insert->bindValue(':provincia', $provincia, PDO::PARAM_STR);
            $insert->bindValue(':localidad', $localidad);
            $insert->bindValue(':direccion', $direccion, PDO::PARAM_STR);
            $insert->bindValue(':coste', $coste, PDO::PARAM_STR);
            $insert->bindValue(':estado', $estado, PDO::PARAM_STR);


            $insert->execute();
            $insert->closeCursor();
        $pedido->db->close();

        $resultado = true;
        header("Location: ".BASE_URL);
    } catch (PDOException $err) {
        echo "Error en la inserción: " . $err->getMessage();
        $resultado = false;
    }
    return $resultado;


}

public function obtenerPedidosPorUsuario($usuarioId)
{
    try {
        $consulta = $this->db->prepara('SELECT * FROM pedidos WHERE usuario_id = :usuarioId ORDER BY id DESC');
        $consulta->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $consulta->execute();

        $pedidos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $consulta->closeCursor();

        return $pedidos;
    } catch (PDOException $err) {
        echo "Error en la consulta de pedidos por usuario: " . $err->getMessage();
        return false;
    }
}

public function actualizarEstadoPedido($pedidoId, $nuevoEstado) {
    try {
        $update = $this->db->prepara('UPDATE pedidos SET estado = :nuevoEstado WHERE id = :pedidoId');
        $update->bindValue(':nuevoEstado', $nuevoEstado, PDO::PARAM_STR);
        $update->bindValue(':pedidoId', $pedidoId, PDO::PARAM_INT);

        $update->execute();
        $update->closeCursor();

        $resultado = true;
    } catch (PDOException $err) {
        echo "Error en la actualización del estado: " . $err->getMessage();
        $resultado = false;
    }

    return $resultado;
}


public function obtenerTodosLosPedidos()
    {

        try {
            $select = $this->db->prepara('SELECT * FROM pedidos ORDER BY id DESC');
            $select->execute();
            $pedidos = $select->fetchAll(PDO::FETCH_ASSOC);
            $select->closeCursor();

            return $pedidos;
        } catch (PDOException $err) {
            echo "Error en la consulta: " . $err->getMessage();
            return false;
        }
    }

    public function getProductosPedidoFromSession()
    {
        // Verifica si existe la clave 'carrito' en la sesión y si no está vacía
        if (isset($_SESSION['carrito2']) && !empty($_SESSION['carrito2'])) {
            // Crea un array para almacenar los productos del pedido
            $productosPedido = array();

            // Itera sobre los productos en el carrito
            foreach ($_SESSION['carrito2'] as $producto) {
                // Agrega información del producto al array
                $productosPedido[] = array(
                    'nombre' => $producto['nombre'],
                    'cantidad' => $producto['cantidad'],
                    'precio' => $producto['precio'],
                    'costo_total' => $producto['precio'] * $producto['cantidad']
                );
            }
    
            // Devuelve el array de productos del pedido
            return $productosPedido;
        }
    
        // Devuelve un array vacío si no hay productos en el carrito
        return array();
    }
    

}
