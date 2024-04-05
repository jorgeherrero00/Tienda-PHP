<h2>Crear Nuevo Producto</h2>
<form action="<?= BASE_URL ?>Producto/crearProducto/" method="POST" enctype="multipart/form-data">
       
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre">

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion"></textarea>

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
        <input type="text" id="precio" name="precio">

        <label for="stock">Stock:</label>
        <input type="text" id="stock" name="stock">

        <label for="oferta">Oferta:</label>
        <input type="text" id="oferta" name="oferta">

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha">

        <label for="foto">Imagen:</label>
        <input type="file" name="foto" id="foto" accept="image/*">



        <button type="submit">Crear Producto</button>
    </form>