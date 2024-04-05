<h1>Carrito de Compras</h1>

<?php if (!empty($_SESSION['carrito'])): ?>
    <ul>
        <?php
        $totalCarrito = 0;
        foreach ($_SESSION['carrito'] as $productoId => $producto): ?>
            <li>
                Nombre: <?= $producto['nombre'] ?> 
                Cantidad: <?= $producto['cantidad'] ?>
                Precio: <?= $producto['precio'] * $producto['cantidad'] ?>€
                <form method="POST" action="<?= BASE_URL ?>Carrito/anadirCantidad">
                    <input type="hidden" name="producto_id" value="<?= $productoId ?>">
                    <input type="hidden" name="cantidad" value="1">
                    <button type="submit">Añadir 1</button>
                </form>
                <form method="POST" action="<?= BASE_URL ?>Carrito/eliminarCantidad">
                    <input type="hidden" name="producto_id" value="<?= $productoId ?>">
                    <input type="hidden" name="cantidad" value="1">
                    <button type="submit">Eliminar 1</button>
                </form>
                <form method="POST" action="<?= BASE_URL ?>Carrito/eliminarProducto">
                    <input type="hidden" name="producto_id" value="<?= $productoId ?>">
                    <button type="submit">Eliminar Producto</button>
                </form>
            </li>
            <?php
            $totalCarrito += $producto['precio'] * $producto['cantidad'];
        endforeach; ?>
    </ul>
    
    <p>Total del carrito: <?= $totalCarrito ?>€</p>
    <form method="POST" action="<?= BASE_URL ?>Carrito/vaciarCarrito">
        <button type="submit">Vaciar Carrito</button>
    </form>
    <a href="<?= BASE_URL ?>Pedido/crearPedido">Hacer pedido</a>
<?php else: ?>
    <p>El carrito está vacío.</p>
<?php endif; ?>
