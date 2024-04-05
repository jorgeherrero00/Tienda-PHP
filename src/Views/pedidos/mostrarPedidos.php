<h1>Listado de Pedidos</h1>
<?php if (!empty($pedidos)): ?>
    <ul>
        <?php foreach ($pedidos as $pedido): ?>
            <li>
                Pedido ID: <?= $pedido['id'] ?><br>
                Provincia: <?= $pedido['provincia'] ?><br>
                Localidad: <?= $pedido['localidad'] ?><br>
                Direccion: <?= $pedido['direccion'] ?><br>
                Coste: <?= $pedido['coste'] ?><br>
                Estado: <?= $pedido['estado'] ?><br>
                Fecha: <?= $pedido['fecha'] ?><br>
                Hora: <?= $pedido['hora'] ?><br>                
                <?php if ($pedido['estado'] != 'Enviado'): ?>
                    <?php if ($_SESSION['login']->rol === "admin"): ?>
                    <a href="<?=BASE_URL?>Pedido/completarPedido?id=<?=$pedido['id']?>">Marcar como Enviado</a>
                    <?php endif; ?>
                                    <?php else: ?>
                    <p>Este pedido ya ha sido enviado.</p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay pedidos disponibles.</p>
<?php endif; ?>
