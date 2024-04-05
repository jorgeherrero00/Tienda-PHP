<?php use Utils\Utils;?>
<?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
    <strong>Registro completado correctamente</strong>
<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'):?>
    <strong>No se ha podido registrar</strong>
<?php endif;?>
<?php Utils::deleteSession('register');?>

<form action="<?=BASE_URL?>Usuario/registro" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="data[nombre]" id="nombre" required>

    <label for="apellidos">Apellidos</label>
    <input type="text" name="data[apellidos]" id="apellidos" required>

    <label for="email">Email</label>
    <input type="email" name="data[email]" id="email" required>

    <label for="password">Contraseña</label>
    <input type="password" name="data[password]" id="password" required>
    
    <label for="rol">Rol</label>
    <select name="data[rol]" id="rol" required>
        <option value="user">Usuario</option>
        <?php if ($_SESSION['login']->rol == 'admin'): ?>
            <option value="admin">Administrador</option>
        <?php else: ?>
            <input type="hidden" name="data[rol]" value="user">
        <?php endif; ?>
    </select>
    <input type="submit" value="Registrarse" required>
</form>