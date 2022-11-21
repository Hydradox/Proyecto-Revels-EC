<header>
    <a class="img-link" href="/">
        <img class="header-logo" src="/media/icons/revels-logo.png" alt="Page logo">
    </a>

    <?php if($user !== null) { /* Si está logueado */ ?>
        <div class="header-container">
            <form class="search-form" action="result.php" method="GET" autocomplete="off">
                <fieldset class="white">
                    <legend>Buscar usuario</legend>
                    <input type="text" name="user" id="user" placeholder="PepeJuan17">
                </fieldset>
                <input class="btn-white" type="submit" value="Buscar">
            </form>

            <span>|</span>

            <a class="img-link img-actions" title="Home" href="/"><img src="/media/icons/home.svg" alt="Home"></a>
            <a class="img-link img-actions" title="Nuevo Revel" href="/new.php"><img src="/media/icons/add.svg" alt="Nuevo Revel"></a>
            <a class="img-link img-actions" title="Mi cuenta" href="/account.php"><img src="/media/icons/account.svg" alt="Mi cuenta"></a>
            <a class="img-link img-actions" title="Cerrar sesión" href="/logout.php"><img src="/media/icons/exit.svg" alt="Cerrar sesión"></a>
        </div>

    <?php } else { /* Si no está logueado */ ?>
        <div class="header-container">
            <a href="/">Iniciar sesión</a>
        </div>
    <?php } ?>
</header>