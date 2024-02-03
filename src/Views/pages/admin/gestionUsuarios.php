<table class="index__table">
    <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Operaciones</th>
    </tr> 
    <?php foreach ($usuarios as $key => $usuario) : ?>
        <tr>
            <td><?= $usuario->getNombre()?></td>
            <td><?= $usuario->getApellidos()?></td>
            <td><?= $usuario->getEmail()?></td>
            <td><?= $usuario->getRol()?></td>
                <form action="<?=BASE_URL?>opcionesUser" method="POST">
                    <td>
                        <button name="editar" value="<?= $usuario->getId()?>">editar</button>
                    </td>
                </form>

        </tr>
    <?php endforeach;?>
    <form action="<?=BASE_URL?>opcionesUser" method="post">
        <button name="add" value="<?= $usuario->getId()?>">Añadir un profesor</button>
    </form>
    <?php if(isset($usuarioEditar) || isset($addUser)) :?>
        <form action="<?=BASE_URL?><?=isset($usuarioEditar)?"editUser":"addUser"?>" method="post">
            <?php if(isset($usuarioEditar)) :?>
                <input type="text" name="data[id]" value="<?=isset($usuarioEditar)?$usuarioEditar['id']:""?>" hidden>
            <?php elseif(isset($addUser)):?>
                <input type="text" name="isLogin" value="false" hidden>
            <?php endif;?>
            
            <div>
                <label for="nombre">Nombre</label>
                <input type="text" name="data[name]" id="nombre" value="<?=isset($usuarioEditar)?$usuarioEditar['nombre']:""?>">
                <p class="err"><?= isset($errores['name']) ? $errores['name'] : "" ?></p>
            </div>
            <div>
                <label for="apellidos">Apellidos</label>
                <input type="text" name="data[subname]" id="apellidos" value="<?=isset($usuarioEditar)?$usuarioEditar['apellidos']:""?>">
                <p class="err"><?= isset($errores['subname']) ? $errores['subname'] : "" ?></p>
            </div>
            <div>
                <label for="dni">DNI</label>
                <input type="text" name="data[dni]" id="dni" value="<?=isset($usuarioEditar)?$usuarioEditar['dni']:""?>">
                <p class="err"><?= isset($errores['dni']) ? $errores['dni'] : "" ?></p>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="text" name="data[email]" id="email" value="<?=isset($usuarioEditar)?$usuarioEditar['dni']:""?>">
                <p class="err"><?= isset($errores['email']) ? $errores['email'] : "" ?></p>
            </div>
            <div>
                <label for="usuario">Usuario</label>
                <input type="text" name="data[usuario]" id="usuario" value="<?=isset($usuarioEditar)?$usuarioEditar['usuario']:""?>">
                <p class="err"><?= isset($errores['usuario']) ? $errores['usuario'] : "" ?></p>
            </div>
            <div>
                <label for="contrasena">Contraseña</label>
                <input type="password" name="data[password]" id="contrasena">
                <p class="err"><?= isset($errores['password']) ? $errores['password'] : "" ?></p>
            </div>
            <div>
                <label for="contrasena">Contraseña</label>
                <input type="password" name="data[password2]" id="contrasena">
                <p class="err"><?= isset($errores['password2']) ? $errores['password2'] : "" ?></p>
            </div>
            <div>
                <label for="acceder">Acceso</label>
                <select name="data[acceder]" id="acceder">
                    <option value="0" <?=isset($usuarioEditar)?($usuarioEditar['acceder']==0?"selected":""):""?>>Aceptado</option>
                    <option value="1" <?=isset($usuarioEditar)?($usuarioEditar['acceder']==1?"selected":""):""?>>Denegado</option>
                </select>
            </div>
            <div>
            <label for="rol">Rol</label>
                <select name="data[rol]" id="rol">
                    <option value="profesor" <?=isset($usuarioEditar)?($usuarioEditar['rol']=="profesor"?"selected":""):""?>>Profesor</option>
                    <option value="direccion" <?=isset($usuarioEditar)?($usuarioEditar['rol']=="direccion"?"selected":""):""?>>Direccion</option>
                </select>
            </div>
            <button type="submit">Guardar</button>
        </form>
    <?php endif;?>
</table>