<div class="contenedor crear">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
        <form class="formulario" action="/create" method="POST">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" placeholder="tu nombre" value="<?php echo $usuario->nombre; ?>">
            </div>

            <div class="campo">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" placeholder="correo@correo.com" value="<?php echo $usuario->email; ?>">
            </div>

            <div class="campo">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" placeholder="tu contraseña">
            </div>

            <div class="campo">
                <label for="password2">Repetir contraseña:</label>
                <input type="password" name="password2" id="password2" placeholder="repite tu contraseña">
            </div>

            <input type="submit" value="Crear cuenta" class="boton">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? ¡Inicia sesión!</a>
            <a href="/forgot-password">¿Olvidaste tu password?</a>
        </div>
        <!-- Fin de acciones -->

    </div>
    <!-- Fin de contenedor-sm -->

</div>
<!-- Fin de contenedor -->