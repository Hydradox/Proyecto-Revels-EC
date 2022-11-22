<?php
    require_once 'inc/req.inc.php';


    // Comprobar si está logueado
    if ($user !== null) {
        // Si está logueado, mostrar el header
        header('Location: /home.php');
    }

    // Comprobar login
    if (count($_POST) !== 0) {
        $expNotEmpty = '/^.{1,}$/';

        // Comprobar login
        if (isset($_POST['loginMail'])) {
            // Comprobar login nombre o email
            if (!isset($_POST['loginMail']) || !preg_match($expNotEmpty, $_POST['loginMail'])) {
                $errors['loginMail'] = 'El campo email es obligatorio';
            }
    
            // Comprobar login contraseña
            if (!isset($_POST['loginPassword']) || !preg_match($expNotEmpty, $_POST['loginPassword'])) {
                $errors['loginPassword'] = 'El campo contraseña es obligatorio';
            }

            
            // Si no hay errores, comprobar si el usuario existe
            if (!isset($errors)) {
                $stmt = $con->prepare('SELECT * FROM users WHERE email = :email OR usuario = :username');
                $stmt->execute([
                    ':email' => $_POST['loginMail'],
                    ':username' => $_POST['loginMail']
                ]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Si el usuario existe, comprobar la contraseña
                if ($res) {
                    if (password_verify($_POST['loginPassword'], $res['contrasenya'])) {
                        // Si la contraseña es correcta, iniciar sesión
                        $_SESSION['user'] = [
                            'id' => $res['id'],
                            'usuario' => $res['usuario'],
                            'email' => $res['email']
                        ];
                        header('Location: /home.php');
                    } else {
                        $errors['loginPassword'] = 'El usuario o contraseña es incorrecta';
                    }
                } else {
                    $errors['loginPassword'] = 'El usuario o contraseña es incorrecta';
                }
            }
        } // Final login


        // Comprobar registro
        if (isset($_POST['registerUsername'])) {
            $expNombre = '/^\w{3,20}$/';
            $expMail = '/^[\w\.\-]+@[\w\-]+\.[\w\-\.]+$/';
            $expContrasenya = '/^\w{3,20}$/';
    
            // Comprobar registro nombre
            if (!isset($_POST['registerUsername']) || !preg_match($expNombre, $_POST['registerUsername'])) {
                $errors['registerUsername'] = 'El campo nombre debe tener entre 4 y 20 caracteres alfanuméricos';
            }
    
            // Comprobar registro email
            if (!isset($_POST['registerEmail']) || !preg_match($expMail, $_POST['registerEmail'])) {
                $errors['registerEmail'] = 'El campo email no es válido';
            }
    
            // Comprobar registro contraseña
            if (!isset($_POST['registerPassword']) || !preg_match($expContrasenya, $_POST['registerPassword'])) {
                $errors['registerPassword'] = 'El campo contraseña debe tener al menos 8 caracteres alfanuméricos';
            }
    
            // Comprobar registro confirmar contraseña
            if (!isset($_POST['registerConfirmPassword']) || empty($_POST['registerConfirmPassword'])) {
                $errors['registerConfirmPassword'] = 'El campo confirmar contraseña es obligatorio';
            }
    
            // Comprobar registro confirmar contraseña
            if (isset($_POST['registerPassword']) && isset($_POST['registerConfirmPassword']) && $_POST['registerPassword'] !== $_POST['registerConfirmPassword']) {
                $errors['registerPassword'] = 'Las contraseñas no coinciden';
                $errors['registerConfirmPassword'] = 'Las contraseñas no coinciden';
            }
    
            // Si no hay errores, comprobar si el usuario existe
            if (empty($errors)) {
                // TODO: Comprobar si existe y dar error si es así
                $stmt = $con->prepare('SELECT * FROM users WHERE email = :email OR usuario = :username');
                $stmt->execute([
                    ':email' => $_POST['registerEmail'],
                    ':username' => $_POST['registerUsername']
                ]);
                $res = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($res) {
                    // El usuario ya existe
                    // Comprobar si es por email o por nombre
                    if ($res['email'] === $_POST['registerEmail']) {
                        $errors['registerEmail'] = 'El email ya está en uso';
                    } else {
                        $errors['registerUsername'] = 'El nombre de usuario ya está en uso';
                    }
                } else {
                    // El usuario no existe, crearlo
                    $stmt = $con->prepare('INSERT INTO users (usuario, contrasenya, email) VALUES (:username, :password, :email)');
                    $stmt->execute([
                        ':username' => $_POST['registerUsername'],
                        ':password' => password_hash($_POST['registerPassword'], PASSWORD_DEFAULT),
                        ':email' => $_POST['registerEmail']
                    ]);
                    $res = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Redirigir a index con registro exitoso
                    header('Location: index.php?registered');
                }
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('inc/meta.inc.php'); ?>

    <title>Index | Revels</title>
    <link rel="stylesheet" href="/css/pages/index.css">
</head>
<body>
    <?php require_once('./inc/header.inc.php'); ?>

    <div class="col-2 index-page">
        <!-- Log in -->
        <div class="col-item">
            <div class="index-item">
                <div class="title">Inicia sesión</div>

                <form action="index.php" method="post">
                    <!-- Email o usuario -->
                    <fieldset class="white<?= isset($errors['loginMail']) ? ' error' : '' ?>">
                        <legend>Usuario o Correo electrónico</legend>
                        <input type="text" name="loginMail" placeholder="ejemplo@ejemplo.com"
                            value="<?= isset($_POST['loginMail']) ? $_POST['loginMail'] : '' ?>">

                        <?php if (isset($errors['loginMail'])) { ?>
                            <img title="<?= $errors['loginMail'] ?>" class="error" src="/media/icons/exclamation-mark.svg" alt="Error message">
                        <?php } ?>
                    </fieldset>

                    <!-- Contraseña -->
                    <fieldset class="white<?= isset($errors['loginPassword']) ? ' error' : '' ?>">
                        <legend>Contraseña</legend>
                        <input type="password" name="loginPassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">

                        <?php if (isset($errors['loginPassword'])) { ?>
                            <img title="<?= $errors['loginPassword'] ?>" class="error" src="/media/icons/exclamation-mark.svg" alt="Error message">
                        <?php } ?>
                    </fieldset>

                    <div class="input-group">
                        <input class="btn-white" type="submit" value="Iniciar sesión">
                    </div>
                </form>
            </div>
        </div>


        <!-- Register -->
        <div class="col-item">
            <div class="index-item">
                <div class="title">Regístrate</div>

                <form action="index.php" method="post">
                    <!-- Nombre de usuario -->
                    <fieldset <?= isset($errors['registerUsername']) ? 'class="error"' : '' ?>>
                        <legend>Nombre de usuario</legend>
                        <input type="text" name="registerUsername" placeholder="PepeJuan17"
                            value="<?= isset($_POST['registerUsername']) ? $_POST['registerUsername'] : '' ?>">

                        <?php if (isset($errors['registerUsername'])) { ?>
                            <img title="<?= $errors['registerUsername'] ?>" class="error" src="/media/icons/exclamation-mark.svg" alt="Error message">
                        <?php } ?>
                    </fieldset>

                    <!-- Email -->
                    <fieldset <?= isset($errors['registerEmail']) ? 'class="error"' : '' ?>>
                        <legend>Correo eléctronico</legend>
                        <input type="text" name="registerEmail" placeholder="ejemplo@ejemplo.com"
                            value="<?= isset($_POST['registerEmail']) ? $_POST['registerEmail'] : '' ?>">

                        <?php if (isset($errors['registerEmail'])) { ?>
                            <img title="<?= $errors['registerEmail'] ?>" class="error" src="/media/icons/exclamation-mark.svg" alt="Error message">
                        <?php } ?>
                    </fieldset>

                    <!-- Contraseña -->
                    <fieldset <?= isset($errors['registerPassword']) ? 'class="error"' : '' ?>>
                        <legend>Contraseña</legend>
                        <input type="password" name="registerPassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">

                        <?php if (isset($errors['registerPassword'])) { ?>
                            <img title="<?= $errors['registerPassword'] ?>" class="error" src="/media/icons/exclamation-mark.svg" alt="Error message">
                        <?php } ?>
                    </fieldset>

                    <!-- Confirmar contraseña -->
                    <fieldset <?= isset($errors['registerConfirmPassword']) ? 'class="error"' : '' ?>>
                        <legend>Repetir contraseña</legend>
                        <input type="password" name="registerConfirmPassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">

                        <?php if (isset($errors['registerConfirmPassword'])) { ?>
                            <img title="<?= $errors['registerConfirmPassword'] ?>" class="error" src="/media/icons/exclamation-mark.svg" alt="Error message">
                        <?php } ?>
                    </fieldset>

                    <div class="input-group">
                        <input class="btn" type="submit" value="Registrarse">
                    </div>

                    <?php if (isset($_GET['registered'])) { ?>
                        <p class="correct">Registro realizado correctamente</p>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>

    <?php include_once './inc/footer.inc.php'; ?>
</body>
</html>