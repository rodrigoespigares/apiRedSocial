<section id="main" class="register">
    <?php if($isLogin):?>
        <h2>Login</h2>
        <form action="<?= BASE_URL ?>vlogin" method="POST" class="formLogin">
            <div>
                <label for="email">Email</label>
                <input type="text" name="data[email]" id="email">
                <p class="err"><?= isset($error['email']) ? $error['email'] : "" ?></p>
            </div>
            <div>
                <label for="contrasena">Contraseña</label>
                <input type="password" name="data[password]" id="contrasena">
                <p class="err"><?= isset($error['password']) ? $error['password'] : "" ?></p>
            </div>
            <p class="err"><?= isset($error['acceso']) ? $error['acceso'] : "" ?></p>
            <button type="submit">Login</button>
        </form>
    <?php else:?>
        <h2>Register</h2>
        <form action="<?= BASE_URL ?>vlogin" method="POST" class="formLogin">
            <div>
                <label for="email">Email</label>
                <input type="text" name="data[email]" id="email">
                <p class="err"><?= isset($error['email']) ? $error['email'] : "" ?></p>
            </div>
            <div>
                <label for="contrasena">Contraseña</label>
                <input type="password" name="data[password]" id="contrasena">
                <p class="err"><?= isset($error['password']) ? $error['password'] : "" ?></p>
            </div>
            <div>
                <label for="contrasena">Repite tu contraseña</label>
                <input type="password" name="data[password2]" id="contrasena">
                <p class="err"><?= isset($error['password2']) ? $error['password2'] : "" ?></p>
            </div>
            <p class="err"><?= isset($error['acceso']) ? $error['acceso'] : "" ?></p>
            <button type="submit">Registro</button>
        </form>
    <?php endif;?>
</section>