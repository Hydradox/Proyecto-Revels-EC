<?php
require_once 'inc/req.inc.php';
require_once 'inc/avatares.inc.php';


// Comprobar si NO está logueado
if ($user === null) {
    // Si está logueado, mostrar el header
    header('Location: /index.php');
}


// Obtener revels propios y de los usuarios que seguimos y número de comentarios
$revels = $con->query('SELECT r.id, r.texto, r.fecha, r.userid, u.usuario, COUNT(c.id) AS numcomentarios
    FROM revels r
    LEFT JOIN users u ON u.id = r.userid
    LEFT JOIN comments c ON c.revelid = r.id
    WHERE r.userid = ' . $user['id'] . ' OR r.userid IN (
        SELECT userfollowed
        FROM follows
        WHERE userid = ' . $user['id'] . '
    )
    GROUP BY r.id
    ORDER BY r.fecha DESC;'
);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('inc/meta.inc.php'); ?>

    <title>Homepage | Revels</title>
    <link rel="stylesheet" href="/css/pages/home.css">
</head>

<body>
    <?php include('./inc/header.inc.php') ?>

    <main>
        <?php include_once('./inc/sidebar.inc.php') ?>

        <div class="opposite-aside revels-container">
            <span class="txt-header">Revels de gente que sigues</span>

            <?php while ($revel = $revels->fetch()) {
                $sender = $con->query('SELECT usuario FROM users WHERE id = ' . $revel['userid'] . ';');
            ?>

                <div class="revel">
                    <img class="revel-pp" src=<?= getAvatar($revel['userid']) ?> alt="Avatar del usuario">
                    
                    <div class="revel-data">
                        <a class="revel-content" href="revel.php?revelID=<?= $revel['id'] ?>">
                            <span class="revel-sender"><?=$sender->fetch()['usuario'] ?>
                                <span class="revel-date">• <?= formatTime($revel['fecha']) ?></span>
                            </span>
                            <p class="revel-text"><?= $revel['texto'] ?></p>
                        </a>

                        <div class="revel-actions">
                            <a href="revel.php?revelID=<?= $revel['id'] ?>">
                                <img src="/media/icons/comment.svg" alt="Comentarios">
                                <span class="action-label"><?= $revel['numcomentarios'] > 0
                                    ? $revel['numcomentarios'] : '' ?></span>
                            </a>

                            <img src="/media/icons/share.svg" alt="Compartir">
                        </div>
                    </div>
                </div>
            <?php }
                if ($revels->rowCount() === 0) {
                    include './inc/empty.inc.php';
                    echo '<div class="silent-txt">Está feed está muy vacía</div>';
                }
            ?>
        </div>
    </main>
</body>

</html>