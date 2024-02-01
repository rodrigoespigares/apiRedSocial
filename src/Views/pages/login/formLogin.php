<section id="main" class="register">
    <?php if($isLogin):?>
        <h2>Login</h2>
        <form action="<?= BASE_URL ?>login" method="POST" class="formLogin">
            <div>
                <label for="email">Email</label>
                <input type="text" name="data[email]" id="email" value="<?=isset($relleno['email'])?$relleno['email']:""?>">
                <p class="err"><?= isset($error['email']) ? $error['email'] : "" ?></p>
            </div>
            <div>
                <label for="contrasena">Contraseña</label>
                <input type="password" name="data[password]" id="contrasena">
                <p class="err"><?= isset($error['password']) ? $error['password'] : "" ?></p>
            </div>
            <p class="err"><?= isset($error['confirmacion']) ? $error['confirmacion'] : "" ?></p>
            <button type="submit">Login</button>
        </form>
    <?php else:?>
        <h2>Register</h2>
        <form action="<?= BASE_URL ?>signup" method="POST" class="formLogin">
            <div>
                <label for="email">Email</label>
                <input type="text" name="data[email]" id="email">
                <p class="err"><?= isset($errores['email']) ? $errores['email'] : "" ?></p>
            </div>
            <div>
                <label for="contrasena">Contraseña</label>
                <input type="password" name="data[password]" id="contrasena">
                <p class="err"><?= isset($errores['password']) ? $errores['password'] : "" ?></p>
            </div>
            <div>
                <label for="contrasena">Repite tu contraseña</label>
                <input type="password" name="data[password2]" id="contrasena">
                <p class="err"><?= isset($errores['password2']) ? $errores['password2'] : "" ?></p>
            </div>
            <p class="err"><?= isset($errores['confirmacion']) ? $errores['confirmacion'] : "" ?></p>
            <button type="submit">Registro</button>
        </form>
    <?php endif;?>
</section>