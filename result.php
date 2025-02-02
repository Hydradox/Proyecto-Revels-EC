<?php
    require_once 'inc/req.inc.php';
    require_once 'inc/avatares.inc.php';

    if ($user === null) {
        header('Location: /index.php');
    }


    // Buscar usuarios menos el propio
    if (isset($_GET['user'])) {
        $users = $con->prepare('SELECT id, usuario FROM users WHERE usuario LIKE :user AND id != :id;');
        $users->execute([
            ':user' => '%' . $_GET['user'] . '%',
            ':id' => $user['id']
        ]);

        // Obtener usuarios que seguimos
        $followList = $con->query('SELECT userfollowed FROM follows WHERE userid = ' . $user['id'] . ';');
        $followList = $followList->fetchAll(PDO::FETCH_COLUMN);
    } else {
        $searchError = true;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('inc/meta.inc.php'); ?>

    <title>Resultados de la búsqueda | Revels</title>
    <link rel="stylesheet" href="css/pages/result.css">
</head>
<body>
    <?php include_once('./inc/header.inc.php') ?>

    <main>
        <?php include_once('./inc/sidebar.inc.php') ?>

        <div class="opposite-aside">
            <?php if (isset($searchError)) { ?>
                <div class="error">
                    <p>Debes introducir un nombre de usuario para buscar.</p>
                </div>
            <?php } else { ?>
                <div class="txt-header">Resultados de la búsqueda: (<?= $_GET['user'] ?>)</div>
    
                <div class="user-results">
                    <?php
                    while ($followedUser = $users->fetch()) {
                        $isFollowing = !in_array($followedUser['id'], $followList);
                    ?>
                        <div class="user">
                            <div class="user__upper">
                                <img src="<?= getAvatar($followedUser['id']) ?>" alt="Avatar de <?=
                                    $followedUser['usuario'] ?>" class="user__avatar">
                            </div>
    
                            <div class="user__lower">
                                <?= $followedUser['usuario'] ?>
    
                                <a href="result.php?user=<?= $_GET['user'] ?>&action=<?= $isFollowing ?
                                    'follow' : 'unfollow' ?>&userID=<?= $followedUser['id'] ?>"
                                    class="follow-btn<?= $isFollowing ? '' : ' follow-btn--following' ?>"></a>
                            </div>
                        </div>
                    <?php
                    }
                    
                    if ($users->rowCount() === 0) { ?>
                        <div>
                            <?php include 'inc/empty.inc.php' ?>
                            <p class="silent-txt">No se han encontrado resultados.</p>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </main>
</body>
</html>