
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Modificar Producto</title>
    </head>
    <body>
        <h1>Modificar Producto</h1>
        <?php if (!empty($producto)): ?>
    <form action="<?=BASE_URL?>Producto/actualizarProducto?id=<?= $producto['id'] ?>" method="POST" enctype="multipart/form-data">
       
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $producto['nombre'] ?>">

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" value="<?= $producto['descripcion'] ?>"></textarea>

        <label for="categoria">Categoría:</label>
    <select id="categoria" name="categoria">
        
        <?php
        $categories = \Models\Categoria::getAll();
        foreach ($categories as $category)
        {
            ?><option value="<?=$category['id']?>"><?=$category['nombre']?></option> <?php
        }
        ?>
    </select>
        <label for="precio">Precio:</label>
        <input type="text" id="precio" name="precio" value="<?= $producto['precio'] ?>">

        <label for="stock">Stock:</label>
        <input type="text" id="stock" name="stock" value="<?= $producto['stock'] ?>">

        <label for="oferta">Oferta:</label>
        <input type="text" id="oferta" name="oferta" value="<?= $producto['oferta'] ?>">

        <label for="fecha">Fecha:</label>
        <input type="text" id="fecha" name="fecha" value="<?= $producto['fecha'] ?>">

        <label for="imagen">Imagen URL:</label>
        <input type="file" name="imagen" id="imagen" value="<?= $producto['imagen'] ?>">

        <button type="submit">Modificar Producto</button>
    </form>
        <?php else: ?>
            <p>El producto no fue encontrado.</p>
        <?php endif; ?>

        <a href="<?= BASE_URL ?>Producto/gestion/">Volver a la gestión de productos</a>
    </body>
    </html>
