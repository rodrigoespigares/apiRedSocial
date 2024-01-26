<table>
    <tr>
        <th>id</th>
        <th>nombre</th>
        <th>opciones</th>
    </tr>
    <?php foreach ($cats as $key => $cat) : ?>
        <tr>
            <td><?=$cat->getId()?></td>
            <td><?=$cat->getNombre()?></td>
            <td>
                <form action="<?=BASE_URL?>opcionesCat" method="POST">
                    <button name="editar" value="<?=$cat->getId()?>">Editar</button>
                </form>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php if(!isset($categoriaEditar)) :?>
    <form action="<?=BASE_URL?>addC" method="post">
        <label for="name">Nombre nueva categoria:</label>
        <input type="text" name="nombre" id="name">
        <button type="submit">Guardar</button>
    </form>
<?php else:?>
    <form action="<?=BASE_URL?>editC" method="post">
        <label for="name">Editar categoria:</label>
        <input type="text" name="data[id]" value="<?=$categoriaEditar[0]->getId()?>" hidden>
        <input type="text" name="data[nombre]" id="name" value="<?=$categoriaEditar[0]->getNombre()?>">
        <button type="submit">Editar</button>
        <a href="<?=BASE_URL?>gestionCategorias">Cancelar</a>
    </form>
<?php endif;?>