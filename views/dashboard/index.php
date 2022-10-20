<?php include_once __DIR__ . "/header-dashboard.php"; ?>

<?php if (count($proyectos) === 0) { ?>
    <p class="no-proyectos">Aún no has creado proyectos... <a href="/create-project">¡Comienza creando uno!</a></p>
<?php } else { ?>
    <ul class="listado-proyectos">
        <?php foreach ($proyectos as $proyecto) : ?>
            <li>
                <a class="proyecto" href="/project?id=<?php echo $proyecto->url; ?>">
                    <?php echo $proyecto->proyecto; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php } ?>

<?php include_once __DIR__ . "/footer-dashboard.php"; ?>