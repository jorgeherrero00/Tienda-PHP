<form action="<?=BASE_URL?>Categoria/actualizarCategoria?id=<?=$categoria['id']?>" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="<?=$categoria['nombre']?>" required>
    <input type="submit" value="Actualizar">
</form>