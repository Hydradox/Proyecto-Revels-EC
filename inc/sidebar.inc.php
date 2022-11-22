<?php
// Obtener usuarios que seguimos
$follows = $con->query(
    'SELECT id, usuario
        FROM users
        WHERE id IN (
            SELECT userfollowed
            FROM follows
            WHERE userid = ' . $user['id'] .
        ');'
);
?>

<div class="userlist">
    <span class="txt-header">Siguiendo</span>

    <ul>
        <?php
        while ($follow = $follows->fetch()) { ?>
            <li class="listed-user">
                <div>
                    <img src="<?= getAvatar($follow['id']) ?>" alt="Avatar de <?= $follow['usuario'] ?>" class="avatar">
                    <span><?= $follow['usuario'] ?></span>
                    <a href="<?= $_SERVER['SCRIPT_NAME'] ?>?action=unfollow&userID=<?= $follow['id'] ?>" class="follow-btn follow-btn--following sidebar-btn"></a>
                </div>
            </li>
        <?php }

        if ($follows->rowCount() === 0) {
            include('./inc/empty.inc.php');
            echo '<div class="silent-txt">Esto está muy vacío...<br>¿Por qué no sigues a alguien?</div>';
        }
        ?>
    </ul>
</div>