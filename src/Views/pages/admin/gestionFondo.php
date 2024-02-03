<table>
    <tr>
        <th>id</th>
        <th>nombre</th>
        <th>director</th>
    </tr>
    <?php foreach ($fondo as $key => $item) : ?>
        <tr>
            <td><?=$item->getId()?></td>
            <td><?=$item->getTitulo()?></td>
            <td><?=$item->getDirector()?></td>
        </tr>
    <?php endforeach;?>
</table>
<form action="<?=BASE_URL?><?=isset($itemEditar)?"editF":"addF"?>" method="post" enctype="multipart/form-data">
    <h2>Crear Fondo</h2>
    <?php if(isset($itemEditar)):?>
        <input type="text" name="data[id]" value="<?=$itemEditar[0]->getId()?>" hidden>
    <?php endif;?>
    <div>
        <label for="categoria_id">Categoria id</label>
        <select name="data[categoria_id]" id="categoria_id">
            <?php foreach ($categorias as $key => $value) :?>
                    <option value="<?=$value->getId()?>" ><?=$value->getNombre()?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div>
        <label for="isan">Isan</label>
        <input type="text" name="data[isan]" id="isan" >
    </div>
    <div>
        <label for="titulo">Titulo</label>
        <input type="text" name="data[titulo]" id="titulo" >
    </div>
    <div>
        <label for="director">Director</label>
        <input type="text" name="data[director]" id="director" >
    </div>
    <div>
        <label for="genero">Genero</label>
        <input type="text" name="data[genero]" id="genero" >
    </div>
    <div>
        <label for="ano">Año</label>
        <input type="text" name="data[ano]" id="ano" >
    </div>
    <button type="submit">Guardar</button>
</form>