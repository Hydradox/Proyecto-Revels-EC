<?php
    require_once 'inc/req.inc.php';

    // Comprobar si NO está logueado
    if ($user === null) {
        // Si está logueado, mostrar el header
        header('Location: /index.php');
    }


    // Comprobar comentario nuevo
    if (isset($_POST['newComment']) && !empty(trim($_POST['newComment'])) && isset($_POST['revelID']) && !empty(trim($_POST['revelID']))) {
        $newComment = trim($_POST['newComment']);

        $query = $con->prepare('INSERT INTO comments (revelid, userid, texto, fecha) VALUES (:revelid, :userid, :texto, :fecha);');
        $query->execute([
            'revelid' => $_POST['revelID'],
            'userid' => $user['id'],
            'texto' => $newComment,
            'fecha' => date('Y-m-d H:i:s')
        ]);

        header('Location: /revel.php?revelID=' . $_POST['revelID']);
    } else {
        header('Location: /revel.php?revelID=' . $_POST['revelID'] . '&error');
    }
