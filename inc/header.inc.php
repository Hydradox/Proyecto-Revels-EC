<header>
    <a class="img-link" href="/">
        <img src="/media/icons/rebels_logo.png" alt="Page logo">
    </a>

    <?php
        if(isset($_COOKIE['PHPSESSIDD'])) {
            // Si está logueado
            echo '<a href="/logout.php">Cerrar sesión</a>';

        } else {
            // Si no está logueado
            echo '<a href="/">Iniciar sesión</a>';
        }
    ?>
</header>