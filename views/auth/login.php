<div class="contenedor login">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php' ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina"><?php echo $titulo; ?></p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>

        <form class="formulario" action="/" method="POST">
            <div class="campo">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" placeholder="correo@correo.com">
            </div>

            <div class="campo">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" placeholder="tu contraseña">
            </div>

            <input type="submit" value="Iniciar sesión" class="boton">
        </form>

        <div class="acciones">
            <a href="/create">¿Aún no tienes una cuenta? ¡Crea una!</a>
            <a href="/forgot-password">¿Olvidaste tu password?</a>
        </div>
        <!-- Fin de acciones -->

    </div>
    <!-- Fin de contenedor-sm -->

</div>
<!-- Fin de contenedor -->