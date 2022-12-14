<div class="contenedor reestablecer">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu contraseña nueva</p>

        <?php
        include_once __DIR__ . '/../templates/alertas.php';

        if ($mostrar) :
        ?>
            <form class="formulario" method="POST">
                <div class="campo">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" placeholder="tu contraseña">
                </div>

                <input type="submit" value="Guardar contraseña" class="boton">
            </form>


        <?php endif; ?>

        <div class="acciones">
            <a href="/create">¿Aún no tienes una cuenta? ¡Crea una!</a>
            <a href="/forgot-password">¿Olvidaste tu password?</a>
        </div>
        <!-- Fin de acciones -->

    </div>
    <!-- Fin de contenedor-sm -->

</div>
<!-- Fin de contenedor -->