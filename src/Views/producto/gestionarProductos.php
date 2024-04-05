<h1>Gestionar Productos</h1>
<?php foreach ($productos as $producto): ?>
    <div>
        <h2><?= $producto['nombre'] ?></h2>
        <p><?= $producto['descripcion'] ?></p>
        <?php 
                $imagenPath = BASE_URL . 'public/images/' . $producto['imagen'];
            ?>
            <img src="<?= $imagenPath ?>" alt="<?= $producto['nombre'] ?>" style="max-width: 200px; max-height: 200px;">
            <p><?= $producto['precio']?>€</p>        <a href="<?=BASE_URL?>Producto/modificarProducto?id=<?=$producto['id']?>">Modificar Producto</a>
        <a href="<?=BASE_URL?>Producto/eliminarProducto?id=<?=$producto['id']?>">Eliminar Producto</a>
    </div>
<?php endforeach; ?>
