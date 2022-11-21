<?php
    require_once 'inc/req.inc.php';
    require_once 'inc/avatares.inc.php';

    if($user === null) {
        header('Location: /index.php');
    }


    // Acciones de seguir / dejar de seguir
    if(isset($_GET['action']) && isset($_GET['userID'])) {
        $action = $_GET['action'];
        $id = $_GET['userID'];

        // Seguir
        if($action === 'follow') {
            $query = $con->prepare('INSERT INTO follows (userid, userfollowed) VALUES (:userid, :userfollowed);');
            $query->execute([
                'userid' => $user['id'],
                'userfollowed' => $id
            ]);

            // Dejar de seguir
        } else if($action === 'unfollow') {
            $query = $con->prepare('DELETE FROM follows WHERE userid = :userid AND userfollowed = :userfollowed;');
            $query->execute([
                'userid' => $user['id'],
                'userfollowed' => $id
            ]);
        }
    }



    // Buscar usuarios
    if(isset($_GET['user'])) {
        $users = $con->prepare('SELECT id, usuario FROM users WHERE usuario LIKE :user');
        $users->execute([':user' => '%' . $_GET['user'] . '%']);

        // Obtener usuarios que seguimos
        $follows = $con->query('SELECT userfollowed FROM follows WHERE userid = ' . $user['id'] . ';');
        $follows = $follows->fetchAll(PDO::FETCH_COLUMN);
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
    <?php print_r($follows); ?>
    <?php include('./inc/header.inc.php') ?>

    <main>
        <?php if(isset($searchError)) { ?>
            <div class="error">
                <p>Debes introducir un nombre de usuario para buscar.</p>
            </div>
        <?php } else { ?>
            <h1>Resultados de la búsqueda: (<?= $_GET['user'] ?>)</h1>

            <div class="user-results">
                <?php while ($followedUser = $users->fetch()) {
                    $isFollowing = !in_array($followedUser['id'], $follows);
                ?>
                    <div class="user">
                        <div class="user__upper">
                            <img src="<?= getAvatar($followedUser['id']) ?>" alt="Avatar de <?= $followedUser['usuario'] ?>" class="user__avatar">
                        </div>

                        <div class="user__lower">
                            <?= $followedUser['usuario'] ?>

                            <a href="result.php?user=<?= $_GET['user'] ?>&action=<?= $isFollowing ? 'follow' : 'unfollow' ?>&userID=<?= $followedUser['id'] ?>" class="follow-btn<?= $isFollowing ? '' : ' follow-btn--following' ?>"></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </main>
</body>
</html>