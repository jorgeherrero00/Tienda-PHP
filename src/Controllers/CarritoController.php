<?php

namespace Controllers;

use Lib\Pages;
use Models\Carrito;
use Models\Producto;
use Controllers\UsuarioController;

/**
 * Controlador para gestionar el carrito de compras.
 */
class CarritoController
{
    /** @var Pages */
    private $pages;

    /** @var Carrito */
    private $nuevoCarrito;
    private $usuario;

    /**
     * Constructor de la clase CarritoController.
     */
    public function __construct()
    {
        $this->pages = new Pages();
        $this->nuevoCarrito = new Carrito(); 
        $this->usuario = new UsuarioController();

    }

    public function comprobarLogin()
    {
        if (!isset($_SESSION['login'])) {
            // Si no está autenticado, redirige a la página de inicio de sesión
            header('Location: ' . BASE_URL . 'Usuario/login');
            exit(); // Asegura que el script se detenga después de redirigir
        }
    }
    /**
     * Añade un producto al carrito.
     */
    public function anadirCarrito()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->validarDatosCarrito()) {
                
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = array();
                }

                $productoId = $_POST['producto_id'];
                $cantidad = $_POST['cantidad'];
                $precio = $_POST['precio'];
                $nombre = $_POST['nombre'];

                
                $producto = Producto::getProductoById($productoId);

                
                if ($cantidad <= $producto['stock']) {
                    
                    if ($this->productoEnCarritoIgualPrecio($productoId, $precio)) {
                        
                        if ($_SESSION['carrito'][$productoId]['cantidad'] + $cantidad <= $producto['stock']) {
                            
                            $_SESSION['carrito'][$productoId]['cantidad'] += $cantidad;
                        } else {
                            
                            echo "La cantidad solicitada supera el stock disponible.";
                        }
                    } else {
                        
                        $_SESSION['carrito'][$productoId] = array(
                            'producto_id' => $productoId,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'nombre' => $nombre
                        );
                    }
                } else {
                    
                    echo "La cantidad solicitada supera el stock disponible.";
                }
            }
        }
        $this->mostrarCarrito();
    }

     /**
     * Muestra el contenido del carrito.
     */
    public function mostrarCarrito()
    {
        $totalCarrito = 0;

        $this->pages->render('carrito/mostrarCarrito', ['totalCarrito' => $totalCarrito]);
    }

     /**
     * Valida los datos del formulario de carrito.
     *
     * @return bool Retorna verdadero si los datos son válidos; de lo contrario, falso.
     */
    private function validarDatosCarrito()
    {
        return isset($_POST['producto_id'], $_POST['cantidad'], $_POST['precio'], $_POST['nombre']);
    }


    /**
     * Verifica si un producto con el mismo precio ya está en el carrito.
     *
     * @param int $productoId ID del producto.
     * @param float $precio Precio del producto.
     * @return bool Retorna verdadero si el producto ya está en el carrito con el mismo precio; de lo contrario, falso.
     */
    private function productoEnCarritoIgualPrecio($productoId, $precio)
    {
        return isset($_SESSION['carrito'][$productoId]) && $_SESSION['carrito'][$productoId]['precio'] == $precio;
    }

      /**
     * Añade una cantidad específica de un producto al carrito.
     */
    public function anadirCantidad()
{
    $this->actualizarCantidad(1);
}
/**
     * Reduce una cantidad específica de un producto del carrito.
     */
public function eliminarCantidad()
{
    $this->actualizarCantidad(-1);
}
/**
     * Elimina un producto del carrito.
     */
public function eliminarProducto()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id'])) {
        $productoId = $_POST['producto_id'];

        if (isset($_SESSION['carrito'][$productoId])) {
            unset($_SESSION['carrito'][$productoId]);
        }
    }

    $this->mostrarCarrito();
}
 /**
     * Vacía todo el contenido del carrito.
     */
public function vaciarCarrito()
{
    unset($_SESSION['carrito']);
    $this->mostrarCarrito();
}
 /**
     * Actualiza la cantidad de un producto en el carrito.
     *
     * @param int $cantidad Cantidad a añadir o eliminar.
     */
private function actualizarCantidad($cantidad)
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['producto_id'])) {
        $productoId = $_POST['producto_id'];

        if (isset($_SESSION['carrito'][$productoId])) {
            
            $producto = Producto::getProductoById($productoId);

            
            if ($_SESSION['carrito'][$productoId]['cantidad'] + $cantidad <= $producto['stock']) {
                $_SESSION['carrito'][$productoId]['cantidad'] += $cantidad;

                if ($_SESSION['carrito'][$productoId]['cantidad'] <= 0) {
                    
                    unset($_SESSION['carrito'][$productoId]);
                }
            } else {
                
                echo "La cantidad solicitada supera el stock disponible.";
            }
        }
    }

    $this->mostrarCarrito();
}

}
