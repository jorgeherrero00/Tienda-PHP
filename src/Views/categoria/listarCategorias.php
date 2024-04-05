<h1>Listado de Categorías</h1>

<ul>
    <?php foreach ($categorias as $categoria): ?>
        <li>
            <?= $categoria['nombre'] ?>
            <form action="<?=BASE_URL?>Categoria/modificarCategoria?id=<?=$categoria['id']?>" method="POST" style="display: inline;">
                <input type="hidden" name="categoria_id" value="<?= $categoria['id'] ?>">
                <button type="submit">Modificar</button>
            </form>
            <form action="<?=BASE_URL?>Categoria/eliminarCategoria?id=<?=$categoria['id']?>" method="POST" style="display: inline;">
                <input type="hidden" name="categoria_id" value="<?= $categoria['id'] ?>">
                <button type="submit">Eliminar</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>