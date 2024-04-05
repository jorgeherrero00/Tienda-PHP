<?php

namespace Controllers;

use Lib\Pages;
use Utils\Utils;
use Models\Producto;
use Controllers\CarritoController;

/**
 * Controlador para gestionar los productos.
 */
class ProductoController{

    /** @var Pages */
    private $pages;

    /** @var Producto */
    private $producto;
    private $carrito;


    /**
     * Constructor de la clase ProductoController.
     */
    public function __construct(){
        $this->pages = new Pages();
        $this->producto = new Producto()
        ;$this->carrito = new CarritoController();
    }

    /**
     * Obtiene todos los productos.
     *
     * @return array Lista de productos.
     */
    public static function obtenerProductos(){
        return Producto::getAll();
    }
    /**
     * Muestra la página para gestionar productos.
     */
    public function gestionarProductos() {
        $this->carrito->comprobarLogin();

        $productos = $this->obtenerProductos(); 
        
        
        $this->pages->render('producto/gestionarProductos', ['productos' => $productos]);
    }
     /**
     * Crea un nuevo producto.
     */
    public function crearProducto() {
        $this->carrito->comprobarLogin();

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['precio'], $_POST['stock'], $_POST['oferta'], $_POST['fecha'])) {
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $categoria = $_POST['categoria'];
                $categoria = intval($categoria);
                $precio = $_POST['precio'];
                $stock = $_POST['stock'];
                $oferta = $_POST['oferta'];
                $fecha = $_POST['fecha'];
        
                // Validar que precio y stock sean números
                if (!is_numeric($precio) || !is_numeric($stock)) {
                    echo "Error: El precio y el stock deben ser números.";
                    $this->pages->render('producto/producto');
                    return;
                }
        
        
                // Verifica si se subió correctamente la imagen
                if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                    // Obtiene la información del archivo
                    $imagen = $_FILES['foto'];
        
                    // Genera un nombre único para el archivo
                    $nombreArchivo = uniqid() . '_' . $imagen['name'];
        
                    // Establece la ruta de destino
                    $rutaDestino = __DIR__ . '/../../public/images/' . $nombreArchivo;
        
                    // Mueve el archivo a la carpeta de destino
                    if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                        // El archivo se movió exitosamente
                        $imagen = $nombreArchivo;
                        $this->producto->crearProducto($nombre, $descripcion, $categoria, $precio, $stock, $oferta, $fecha, $imagen);
        
                    } else {
                        // Hubo un error al mover el archivo
                        echo "Error al mover el archivo";
                    }
                } else {
                    // La información del archivo no es válida
                    echo "Error: La información del archivo no es válida";
                }
            } else {
                // Faltan campos obligatorios
                echo "Por favor, complete todos los campos obligatorios.";
            }
        
            $this->pages->render('producto/producto');
    }
    
    /**
     * Muestra la página para modificar un producto.
     *
     * @param int $id ID del producto a modificar.
     */


public function modificarProducto($id) {
    $this->carrito->comprobarLogin();

    $producto = Producto::getProductoById($id);
    
    $this->pages->render('producto/modificar', ['producto' => $producto]);
}

/**
     * Actualiza un producto existente.
     *
     * @param int $id ID del producto a actualizar.
     */
    public function actualizarProducto($id) {
        $this->carrito->comprobarLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre'], $_POST['descripcion'], $_POST['categoria'], $_POST['precio'], $_POST['stock'], $_POST['oferta'], $_POST['fecha'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $categoria = $_POST['categoria'];
            $categoria = intval($categoria);
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $oferta = $_POST['oferta'];
            $fecha = $_POST['fecha'];
    
            // Validar que precio y stock sean números
            if (!is_numeric($precio) || !is_numeric($stock)) {
                echo "Error: El precio y el stock deben ser números.";
                return;
            }
    
            // Verifica si se subió correctamente la nueva imagen
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                // Obtiene la información del archivo
                $imagen = $_FILES['imagen'];
            
                // Genera un nombre único para el archivo
                $nombreArchivo = uniqid() . '_' . $imagen['name'];
    
                // Establece la ruta de destino
                $rutaDestino = __DIR__ . '/../../public/images/' . $nombreArchivo;
    
                // Mueve el archivo a la carpeta de destino
                if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
                    // El archivo se movió exitosamente
                    $imagen = $nombreArchivo;
                } else {
                    // Hubo un error al mover el archivo
                    echo "Error al mover el archivo";
                }
            } else {
                // No se proporcionó una nueva imagen, mantener la imagen existente
                $imagen = $this->producto->getImagenById($id);
            }
    
            $resultado = $this->producto->actualizarProducto($id, $nombre, $descripcion, $categoria, $precio, $stock, $oferta, $fecha, $imagen);
            $productos = $this->obtenerProductos();
            $this->pages->render('producto/gestionarProductos', ['productos' => $productos]);
    
            // Redirige o realiza alguna acción adicional según el resultado
        } else {
            // Faltan campos obligatorios o el formulario no se ha enviado correctamente
            echo "Error: Por favor, complete todos los campos obligatorios y envíe el formulario correctamente.";
        }
    }
    
/**
     * Elimina un producto.
     *
     * @param int $id ID del producto a eliminar.
     */ 


public function eliminarProducto($id) {
    $this->carrito->comprobarLogin();

    $producto = new Producto();
    $resultado = $producto->eliminarProducto($id);
    $resultado = $this->obtenerProductos();
    
    $this->pages->render('producto/gestionarProductos', ['productos' => $resultado]);
}



}