<?php 

namespace Controllers;

use Lib\Pages;
use Utils\Utils;
use Models\Pedido;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Controllers\CarritoController;
use Models\Producto;


/**
 * Controlador para gestionar los pedidos de productos.
 */
class PedidoController{
    
    /** @var Pages */
    private $pages;

    /** @var Pedido */
    private $nuevoPedido;
    private $carrito;



    /**
     * Constructor de la clase PedidoController.
     */
    public function __construct(){
        $this->pages = new Pages();
        $this->nuevoPedido = new Pedido(); 
        $this->carrito = new CarritoController();
    }

    /**
     * Crea un nuevo pedido.
     */
    /**
 * Crea un nuevo pedido.
 */
public function crearPedido()
{
    $this->carrito->comprobarLogin();

    if (!empty($_SESSION['carrito'])) {
        $usuario_id = $_SESSION['login']->id; 
        if (!empty($_POST['provincia']) && !empty($_POST['localidad']) && !empty($_POST['direccion'])) {
            $provincia = $_POST['provincia'];
            $localidad = $_POST['localidad'];
            $direccion = $_POST['direccion'];
            $precioTotal = 0;
            $productosPedido = array(); 

            foreach ($_SESSION['carrito'] as $producto) {
                $precioTotal += $producto['precio'] * $producto['cantidad'];
                $idProducto = $producto['producto_id'];

                $cantidadVendida = $producto['cantidad'];
                $productoModel = new Producto();
            
                // Obtener el stock actual del producto
                $stockActual = $productoModel->getStockById($idProducto);
            
                // Verificar si hay suficiente stock
                if ($stockActual >= $cantidadVendida) {
                    // Calcular el nuevo stock
                    $nuevoStock = $stockActual - $cantidadVendida;
            
                    // Actualizar el stock en la base de datos
                    $productoModel->actualizarStock($idProducto, $nuevoStock);
                } else {
                    echo "Stock insuficiente $idProducto.";
                }
                $productosPedido[] = array(
                    'nombre' => $producto['nombre'],
                    'cantidad' => $producto['cantidad'],
                    'precio' => $producto['precio'],
                    'costo_total' => $producto['precio'] * $producto['cantidad']
                );
            }              
            $estado = 'Pendiente'; 
            
            $resultado = $this->nuevoPedido->crearPedido($usuario_id, $provincia, $localidad, $direccion, $precioTotal, $estado);

            $productoModel = new Producto();         
            unset($_SESSION['carrito']);
            header("Location: " . BASE_URL . "Pedido/mostrarPedidos");
        } else {
            echo "Por favor, complete todos los campos requeridos.";
            $this->pages->render('pedidos/formulario');
        }
    } else {
        echo "El carrito está vacío.";
    }
}

    
    
    
/**
     * Completa un pedido y envía un correo de confirmación.
     *
     * @param int $id ID del pedido a completar.
     */
    public function completarPedido($id)
    {
        $this->carrito->comprobarLogin();

        $pedidoId = $_GET['id'];
        $pedido = new Pedido();
        $productosPedido = [];

        
        $nuevoEstado = 'Enviado';
        $actualizacionExitosa = $this->nuevoPedido->actualizarEstadoPedido($pedidoId, $nuevoEstado);
    
        if ($actualizacionExitosa) {
            
            $this->enviarCorreoConfirmacion($pedidoId, $productosPedido);
    
            
            header("Location: " . BASE_URL . "Pedido/mostrarPedidos");
        } else {
            echo "Error al completar el pedido.";
        }
    }
     /**
     * Envía un correo de confirmación de pedido.
     *
     * @param int $pedidoId ID del pedido.
     * @param array $productosPedido Detalles de los productos del pedido.
     */
    private function enviarCorreoConfirmacion($pedidoId, $productosPedido)
    {

        $this->carrito->comprobarLogin();

        $mail = new PHPMailer(true);
    
        try {
            
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'herrerojorge730@gmail.com';
            $mail->Password = 'bauk hhuu nonm jsdi';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
    
            
            $mail->setFrom('herrerojorge730@gmail.com', 'La Tienda de Jorge');
            $mail->addAddress($_SESSION['login']->email, $_SESSION['login']->nombre);
            
            $tablaProductos = '<table border="1">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Costo total</th>
            </tr>';
    
        foreach ($productosPedido as $producto) {
            $tablaProductos .= '<tr>
                <td>' . $producto['nombre'] . '</td>
                <td>' . $producto['cantidad'] . '</td>
                <td>' . $producto['precio'] . '</td>
                <td>' . $producto['costo_total'] . '</td>
            </tr>';
        }
    
        $tablaProductos .= '</table>';
    
        
    
        
        $body = 'Gracias por completar su pedido. Detalles del pedido (ID ' . $pedidoId . '):<br>' .
            $tablaProductos;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Confirmación de Pedido';
        $mail->Body = $body;
        $mail->send();
    
            echo 'Correo electrónico enviado correctamente.';
        } catch (Exception $e) {
            header('Correo electrónico no enviado') . $e->getMessage();
        }
    }
    
     /**
     * Muestra los pedidos realizados.
     */
    

    public function mostrarPedidos()
{
    $this->carrito->comprobarLogin();

    
    if (isset($_SESSION['login'])) {
        
        $usuarioId = $_SESSION['login']->id;
        
        
        $esAdministrador = $_SESSION['login']->rol == 'admin';

        if ($esAdministrador) {
            
            $pedidos = $this->nuevoPedido->obtenerTodosLosPedidos();
        } else {
            
            $pedidos = $this->nuevoPedido->obtenerPedidosPorUsuario($usuarioId);
        }

        
        $this->pages->render('pedidos/mostrarPedidos', ['pedidos' => $pedidos]);
    } else {
        
        echo "Usuario no autenticado.";
    }
}

    
}