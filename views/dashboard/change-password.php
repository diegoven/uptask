<?php include_once __DIR__ . "/header-dashboard.php"; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>

    <a href="/profile" class="enlace">Volver al perfil</a>

    <form action="/change-password" method="post" class="formulario">
        <div class="campo">
            <label for="passwordActual">Contraseña actual:</label>
            <input type="password" name="passwordActual">
        </div>

        <div class="campo">
            <label for="passwordNuevo">Contraseña nueva:</label>
            <input type="password" name="passwordNuevo">
        </div>

        <input type="submit" value="Guardar cambios">
    </form>
</div>

<?php include_once __DIR__ . "/footer-dashboard.php"; ?>