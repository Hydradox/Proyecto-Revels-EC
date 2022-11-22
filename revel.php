<?php
    require_once 'inc/req.inc.php';
    require_once 'inc/avatares.inc.php';


    // Comprobar si NO está logueado
    if ($user === null) {
        // Si está logueado, mostrar el header
        header('Location: /index.php');
    }


    // Comprobar id
    if (isset($_GET['revelID'])) {
        // Obtener revel
        $query = $con->prepare(
            'SELECT r.id, r.texto, r.fecha, r.userid, u.usuario
            FROM revels r
            LEFT JOIN users u
            ON u.id = r.userid
            WHERE r.id = :revelid
            GROUP BY r.id
            ORDER BY r.fecha DESC;'
        );

        $query->execute([
            'revelid' => $_GET['revelID']
        ]);
        $revel = $query->fetch(PDO::FETCH_ASSOC);


        // Obtener comentarios
        $query = $con->prepare(
            'SELECT c.id, c.revelid, c.texto, c.fecha, c.userid, u.usuario
            FROM comments c
            LEFT JOIN users u ON u.id = c.userid
            WHERE c.revelid = :revelid
            GROUP BY c.id
            ORDER BY c.fecha ASC;'
        );

        $query->execute([
            'revelid' => $_GET['revelID']
        ]);
        $comments = $query->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('inc/meta.inc.php'); ?>

    <title>Revel | Revels</title>
    <link rel="stylesheet" href="/css/pages/revel.css">
</head>
<body>
    <?php require_once('inc/header.inc.php'); ?>

    <?php
        // echo '<pre>' . print_r($revel, true) . '</pre>';
        // echo '<pre>' . print_r($comments, true) . '</pre>';
    ?>

    <main>
        <div class="txt-header">Revel de <?= $revel['usuario'] ?></div>

        <div class="revel bordered">
            <img class="revel-pp" src=<?= getAvatar($revel['userid']) ?> alt="Avatar del usuario">
            
            <div class="revel-data">
                <a class="revel-content" href="revel.php?revelID=<?= $revel['id'] ?>">
                    <span class="revel-sender"><?=$revel['usuario'] ?>
                        <span class="revel-date">• <?= formatTime($revel['fecha']) ?></span>
                    </span>
                    <p class="revel-text"><?= $revel['texto'] ?></p>
                </a>

                <div class="revel-actions">
                    <a href="revel.php?revelID=<?= $revel['id'] ?>">
                        <img src="/media/icons/comment.svg" alt="Comentarios">
                        <span class="action-label"><?= count($comments) > 0
                            ? count($comments) : '' ?></span>
                    </a>

                    <img src="/media/icons/share.svg" alt="Compartir">
                </div>
            </div>
        </div>

        <div class="comments">
            <?php foreach ($comments as $comment) { ?>
                <div class="revel bordered">
                    <img class="revel-pp" src=<?= getAvatar($comment['userid']) ?> alt="Avatar del usuario">
                    
                    <div class="revel-data">
                        <div class="revel-content comment" href="revel.php?revelID=<?= $comment['id'] ?>">
                            <span class="revel-sender"><?=$comment['usuario'] ?>
                                <span class="revel-date">• <?= formatTime($comment['fecha']) ?></span>
                            </span>
                            <p class="revel-text"><?= $comment['texto'] ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <form action="comment.php" method="POST">
                <div class="new-revel-wrapper">
                    <img src="<?= getAvatar($user['id']) ?>" alt="Perfil de <?= $user['usuario'] ?>">
                    <textarea id="new-comment" class="revel-textarea" autofocus
                        name="newComment" cols="30" rows="3" placeholder="Nuevo comentario"></textarea>
                </div>

                <input type="hidden" name="revelID" value="<?= $_GET['revelID'] ?>">

                <div class="revel-publish-wrapper">
                    <div><span id="char-count">0</span> / 640</div>
                    <input class="revel-publish" type="submit" value="Publicar comentario" disabled="true">
                </div>
            </form>

            <?php if (isset($_GET['error'])) { ?>
                <div class="error">Ha habido un problema al publicar el comentario</div>
            <?php } ?>
        </div>
    </main>

    <script>
        let newRevel = document.getElementById('new-comment');
        let charCount = document.getElementById('char-count');
        let publishBtn = document.querySelector('.revel-publish');

        newRevel.addEventListener('keyup', (e) => {
            // Si pulsa enter + shift, pulsar botón de publicar
            if (e.keyCode === 13 && e.shiftKey) {
                publishBtn.click();
            }

            // Ajustar altura del textarea
            newRevel.style.height = 'auto';
            newRevel.style.height = (newRevel.scrollHeight > 300 ? 300 : newRevel.scrollHeight + 5) + 'px';

            // Contar caracteres
            charCount.innerHTML = newRevel.value.trim().length;

            // Deshabilitar botón si no hay texto o si hay más de 640 caracteres
            if (newRevel.value.trim().length === 0 || newRevel.value.trim().length > 640) {
                document.querySelector('.revel-publish').disabled = true;
            } else {
                document.querySelector('.revel-publish').disabled = false;
            }
        });
    </script>
</body>
</html>