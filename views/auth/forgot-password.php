<div class="contenedor olvide">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu acceso a UpTask</p>

        <form class="formulario" action="/forgot-password" method="POST">
            <div class="campo">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" placeholder="correo@correo.com">
            </div>

            <input type="submit" value="Recuperar cuenta" class="boton">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? ¡Inicia sesión!</a>
            <a href="/create">¿Aún no tienes una cuenta? ¡Crea una!</a>
        </div>
        <!-- Fin de acciones -->

    </div>
    <!-- Fin de contenedor-sm -->

</div>
<!-- Fin de contenedor -->