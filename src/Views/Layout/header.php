<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tienda</title>
    <link rel="stylesheet" href="<?=BASE_URL?>/css/style.css" type="text/css">
</head>
<body>
    <header>
        <h1><a href="<?=BASE_URL?>">Tienda</a></h1>
        <?php if (isset($_SESSION['login']) AND $_SESSION['login']!='failed'):?>
            <h2><?=$_SESSION['login']->nombre?> <?=$_SESSION['login']->apellidos?></h2>
        <?php endif;?>
        <nav>
            <?php if (!isset($_SESSION['login']) OR $_SESSION['login']=='failed'):?>
                <a href="<?=BASE_URL?>Usuario/login">Identificarse</a>
                <a href="<?=BASE_URL?>Usuario/registro/">Registrarse</a>
            <?php else:?>
                <?php if ($_SESSION['login']->rol === "admin"): ?>
                    <a href="<?=BASE_URL?>Pedido/mostrarPedidos/">Gestionar pedidos</a>
                    <a href="<?=BASE_URL?>Producto/gestionarProductos/">Gestionar productos</a>
                    <a href="<?=BASE_URL?>Producto/crearProducto/">Añadir Producto</a>
                    <a href="<?=BASE_URL?>Categoria/mostrarCategorias/">Gestionar categorías</a>
                    <a href="<?=BASE_URL?>Categoria/crearCategoria/">Añadir categorías</a>
                    <a href="<?=BASE_URL?>Usuario/registro/">Registrar usuario</a>
                <?php else:?>
                    <a href="<?=BASE_URL?>Pedido/mostrarPedidos/">Mis pedidos</a>
                    <a href="<?=BASE_URL?>Carrito/mostrarCarrito/">Carrito</a>
                <?php endif; ?>
                <a href="<?=BASE_URL?>Usuario/logout/">Cerrar Sesión</a>
            <?php endif;?>
        </nav>
    </header>

    <?php $categorias = \Controllers\CategoriaController::obtenerCategorias(); ?>

    <nav id="menu">
    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li>
            <a href="<?=BASE_URL?>Categoria/mostrarProductosCategoria/?id=<?=$categoria['id']?>"><?=$categoria['nombre']?></a>            </li>
        <?php endforeach; ?>
    </ul>
</nav>
