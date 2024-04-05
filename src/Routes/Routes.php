<?php

namespace Routes;
use Controllers\CategoriaController;
use Controllers\UsuarioController;
use Controllers\ProductoController;
use Controllers\DashboardController;
use Lib\Router;
use Controllers\CarritoController;
use Controllers\PedidoController;
class Routes{
    public static function index(){
    
        Router::add('GET','/', function (){
            return (new DashboardController())->index();
        });
        Router::add('GET','/Usuario/registro', function (){
            return (new UsuarioController())->registro();
        });
        Router::add('GET','/Usuario/login', function (){
            return (new UsuarioController())->login();
        });
        Router::add('POST','/Usuario/registro', function (){
            return (new UsuarioController())->registro();
        });
        Router::add('POST','/Usuario/login', function (){
            return (new UsuarioController())->login();
        });
        Router::add('GET','/Usuario/logout', function (){
            return (new UsuarioController())->logout();
        });
        Router::add('GET','/Usuario/logout', function (){
            return (new UsuarioController())->logout();
        });
        Router::add('POST','/Categoria/crearCategoria', function (){
            return (new CategoriaController())->crearCategoria();
        });
        Router::add('GET','/Categoria/crearCategoria', function (){
            return (new CategoriaController())->crearCategoria();
        });
        
        Router::add('GET','/Categoria/mostrarCategorias', function (){
            return (new CategoriaController())->mostrarCategorias();
        });
        Router::add('GET','/Categoria/modificarCategoria?id=:id', function ($id){
            return (new CategoriaController())->modificarCategoria($id);
        });
        Router::add('POST','/Categoria/modificarCategoria?id=:id', function ($id){
            return (new CategoriaController())->modificarCategoria($id);
        });
        Router::add('POST','/Categoria/actualizarCategoria?id=:id', function ($id){
            return (new CategoriaController())->actualizarCategoria($id);
        });
        Router::add('POST','/Categoria/eliminarCategoria?id=:id', function ($id){
            return (new CategoriaController())->eliminarCategoria($id);
        });

        Router::add('GET','Categoria/mostrarProductosCategoria/?id=:id', function ($id){
            return (new CategoriaController())->mostrarProductosCategoria($id);
        });
        Router::add('GET','Producto/eliminarProducto?id=:id', function ($id){
            return (new ProductoController())->eliminarProducto($id);
        });
        Router::add('GET','Producto/modificarProducto?id=:id', function ($id){
            return (new ProductoController())->modificarProducto($id);
        });
        Router::add('POST','Producto/modificarProducto?id=:id', function ($id){
            return (new ProductoController())->modificarProducto($id);
        });
        Router::add('GET','Producto/gestionarProductos', function (){
            return (new ProductoController())->gestionarProductos();
        });
        Router::add('POST','Producto/actualizarProducto?id=:id', function ($id){
            return (new ProductoController())->actualizarProducto($id);
        });
        Router::add('GET','Producto/crearProducto', function (){
            return (new ProductoController())->crearProducto();
        });
        Router::add('POST','Producto/crearProducto', function (){
            return (new ProductoController())->crearProducto();
        });
        Router::add('FILES','Producto/crearProducto', function (){
            return (new ProductoController())->crearProducto();
        });
        Router::add('POST','Carrito/anadirCarrito', function (){
            return (new CarritoController())->anadirCarrito();
        });
        Router::add('GET','Carrito/mostrarCarrito', function (){
            return (new CarritoController())->mostrarCarrito();
        });
        Router::add('GET','Pedido/crearPedido', function (){
            return (new PedidoController())->crearPedido();
        });
        Router::add('POST','Pedido/crearPedido', function (){
            return (new PedidoController())->crearPedido();
        });
        Router::add('GET','Pedido/mostrarPedidos', function (){
            return (new PedidoController())->mostrarPedidos();
        });
        Router::add('POST','Pedido/mostrarPedidos', function (){
            return (new PedidoController())->mostrarPedidos();
        });
        Router::add('GET','Pedido/completarPedido?id=:id', function ($id){
            return (new PedidoController())->completarPedido($id);
        });
        Router::add('POST','Carrito/anadirCantidad', function (){
            return (new CarritoController())->anadirCantidad();
        });
        Router::add('POST','Carrito/eliminarCantidad', function (){
            return (new CarritoController())->eliminarCantidad();
        });
        Router::add('POST','Carrito/eliminarProducto', function (){
            return (new CarritoController())->eliminarProducto();
        });
        Router::add('POST','Carrito/vaciarCarrito', function (){
            return (new CarritoController())->vaciarCarrito();
        });
        
        Router::add('GET','http://localhost/Tienda/', function (){
            return (new DashboardController())->index();
        });

        Router::dispatch();
    }
}
?>