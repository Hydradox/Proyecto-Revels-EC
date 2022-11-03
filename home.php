<?php
// Comprobar si NO está logueado
if (!isset($_COOKIE['PHPSESSID'])) {
    // Si está logueado, mostrar el header
    header('Location: /index.php');
}

require_once('inc/db.inc.php');
require_once('inc/avatares.inc.php');

// Estamos "conectados" como usuario con ID #6
$follows = $con->query('SELECT id, usuario
    FROM users
    WHERE id IN (
        SELECT userfollowed
        FROM follows
        WHERE userid = 6
    );');


// Obtener revels propios y de los usuarios que seguimos
$revels = $con->query('SELECT id, userid, texto, fecha
    FROM revels
    WHERE userid = 6
    OR userid IN (
        SELECT userfollowed
        FROM follows
        WHERE userid = 6
    )
    ORDER BY fecha DESC;');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | Revels</title>

    <link rel="shortcut icon" href="/media/icons/logo-icon.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/pages/home.css">
</head>

<body>
    <?php require_once('./inc/header.inc.php') ?>

    <main>
        <div class="userlist">
            <span class="list-header">Siguiendo</span>

            <ul>
                <?php
                    while ($follow = $follows->fetch()) {
                        echo '<li class="listed-user"><a href="/user/' . $follow['id'] . '">';

                        echo '<img src="' . getAvatar($follow['id']) . '" alt="Avatar de ' . $follow['usuario'] . '" class="avatar">';
                        echo '<span>' . $follow['usuario'] . '</span>';

                        echo '</a></li>';
                    }
                ?>
            </ul>
        </div> <!-- .userlist -->

        <div class="revels-container">
            <span class="revels-header">Revels de gente que sigues</span>

            <?php while ($revel = $revels->fetch()) {
                $sender = $con->query('SELECT usuario FROM users WHERE id = ' . $revel['userid'] . ';');
            ?>

                <div class="revel">
                    <img class="revel-pp" src=<?= getAvatar($revel['userid']) ?> alt="Avatar del usuario">
                    
                    <div class="revel-data">
                        <a href=<?= '/revel/' . $revel['id'] ?> >
                            <span class="revel-sender">@<?= $sender->fetch()['usuario'] ?></span>
                            <p class="revel-text"><?= $revel['texto'] ?></p>
                        </a>

                        <div class="revel-actions">
                            <a href="#">
                                <img src="/media/icons/comment.svg" alt="Comentarios">
                                <span class="action-label">2</span>
                            </a>

                            <img src="/media/icons/heart.svg" alt="Likes">

                            <img src="/media/icons/share.svg" alt="Compartir">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</body>

</html>