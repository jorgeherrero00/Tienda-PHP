<?php 

namespace Controllers;

use Lib\Pages;
use Utils\Utils;
use Models\Categoria;
use Models\Producto;
use Controllers\CarritoController;
/**
 * Controlador para gestionar las categorías de productos.
 */
class CategoriaController{

    /** @var Pages */
    private $pages;

    /** @var Categoria */
    private $nuevaCategoria;

    private $carrito;

    /**
     * Constructor de la clase CategoriaController.
     */
    public function __construct(){
        $this->pages = new Pages();
        $this->nuevaCategoria = new Categoria(); 
        $this->carrito = new CarritoController();
    }

    /**
     * Obtiene todas las categorías existentes.
     *
     * @return array Retorna un array con las categorías.
     */
    public static function obtenerCategorias(): array {
        return Categoria::getAll();
    }
    /**
     * Crea una nueva categoría.
     */
    public function crearCategoria(){
        $this->carrito->comprobarLogin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['categoria'])) {
            $categoria = $_POST['categoria'];
            
            
            if (ctype_alpha($categoria)) {
                $resultado = $this->nuevaCategoria->crearCategoria($categoria);
                
                if ($resultado) {
                    
                    echo "Categoría creada correctamente.";
                } else {
                    
                    echo "No se pudo crear la categoría.";
                }
            } else {
                
                echo "El nombre de la categoría debe contener solo letras.";
            }
        }
        
        $this->pages->render('categoria/gestionar');
    }
 /**
     * Muestra los productos de una categoría.
     *
     * @param int $id ID de la categoría.
     */
    public function mostrarProductosCategoria($id){

        if (isset($_GET['id'])) {
                        $categoriaId = $_GET['id'];
                        $producto = Producto::getProductosByCategoria($categoriaId);
                
                        
                        $this->pages->render('producto/lista', ['productos' => $producto]);
                    } else {
                        
                        
                        $this->pages->render('error');
                    }
                }
                
                /**
     * Muestra todas las categorías.
     */
    public function mostrarCategorias() {
        $this->carrito->comprobarLogin();

        $categorias = Categoria::listarCategorias();
        $this->pages->render('categoria/listarCategorias', ['categorias' => $categorias]);
    }               
/**
     * Modifica una categoría.
     *
     * @param int $id ID de la categoría a modificar.
     */
    public function modificarCategoria($id) {
        $this->carrito->comprobarLogin();

        $categoria = Categoria::getCategoriaById($id);
        
        $this->pages->render('categoria/modificar', ['categoria' => $categoria]);
    }

     /**
     * Actualiza una categoría existente.
     *
     * @param int $id ID de la categoría a actualizar.
     */
    public function actualizarCategoria($id) {
        $this->carrito->comprobarLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            
            
            if (ctype_alpha($nombre)) {
                $resultado = $this->nuevaCategoria->actualizarCategoria($id, $nombre);
                
                if ($resultado) {
                    
                    echo "Categoría actualizada correctamente.";
                } else {
                    
                    echo "No se pudo actualizar la categoría.";
                }
            } else {
                
                echo "El nombre de la categoría debe contener solo letras.";
            }
    
            
            $categorias = Categoria::listarCategorias();
            
            
            $this->pages->render('categoria/listarCategorias', ['categorias' => $categorias]);
        } else {
            
            
        }
    }
    /**
     * Elimina una categoría.
     *
     * @param int $id ID de la categoría a eliminar.
     */

    public function eliminarCategoria($id) {
        $this->carrito->comprobarLogin();

        $categoria = new Categoria();
        $resultado = $categoria->eliminarcategoria($id);
        $resultado = $this->obtenercategorias();
        
        
        $this->pages->render('categoria/listarCategorias', ['categorias' => $resultado]);
    }



}


?>