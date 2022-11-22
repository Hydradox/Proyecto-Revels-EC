<?php
    require_once 'inc/req.inc.php';
    require_once 'inc/avatares.inc.php';

    if ($user === null) {
        header('Location: /index.php');
    }


    // Comprobar si hay nuevo Revel y que no esté vacío
    if (isset($_POST['newRevel'])) {
        if (empty(trim($_POST['newRevel']))) {
            header('Location: /new.php?error');
            exit;
        }

        $newRevel = trim($_POST['newRevel']);

        $query = $con->prepare('INSERT INTO revels (userid, texto, fecha) VALUES (:userid, :texto, :fecha);');
        $query->execute([
            'userid' => $user['id'],
            'texto' => $newRevel,
            'fecha' => date('Y-m-d H:i:s')
        ]);

        // Obtener el ID del último revel
        $revelID = $con->query('SELECT id FROM revels ORDER BY id DESC LIMIT 1;')->fetch(PDO::FETCH_ASSOC)['id'];

        header('Location: /revel.php?revelID=' . $revelID);
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once 'inc/meta.inc.php'; ?>

    <title>Nuevo Revel | Revels</title>
    <link rel="stylesheet" href="css/pages/new.css">
</head>
<body>
    <?php require_once 'inc/header.inc.php'; ?>

    <main>
        <div class="txt-header">Añadir un nuevo Revel</div>

        <form action="new.php" method="POST">
            <div class="new-revel-wrapper">
                <img src="<?= getAvatar($user['id']) ?>" alt="Perfil de <?= $user['usuario'] ?>">
                <textarea id="new-revel" class="revel-textarea" autofocus
                    name="newRevel" cols="30" rows="3" placeholder="Nuevo Revel"></textarea>
            </div>

            <div class="revel-publish-wrapper">
                <div><span id="char-count">0</span> / 640</div>
                <input class="revel-publish" type="submit" value="Publicar Revel" disabled="true">
            </div>
        </form>

        <?php if (isset($_GET['error'])) { ?>
            <div class="error">Ha habido un problema al publicar el Revel</div>
        <?php } ?>
    </main>


    <script>
        let newRevel = document.getElementById('new-revel');
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