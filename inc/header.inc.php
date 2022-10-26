<header>
    <a class="img-link" href="/">
        <img src="/media/icons/rebels_logo.png" alt="Page logo">
    </a>

    <?php if(isset($_COOKIE['PHPSESSID'])) { /* Si está logueado */ ?>
        <div class="header-container">
            <a href="/">Home</a>
            <a href="/new.php">New</a>
            <a href="/account.php">Account</a>
            <a href="/logout.php">Cerrar sesión</a>

            <br>

            <form class="search-form" action="#" method="GET">
                <fieldset class="white">
                    <legend>Buscar Revel</legend>
                    <input type="text" name="searchRevel" id="searchRevel" placeholder="Vacaciones en la playa">
                </fieldset>
                <input class="btn-white" type="submit" value="Buscar">
            </form>
        </div>

    <?php } else { /* Si no está logueado */ ?>
        <div class="header-container">
            <a href="/">Iniciar sesión</a>
        </div>
    <?php } ?>
</header>