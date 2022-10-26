<?php
    require_once('inc/Red-Objects.php');


    // Verificar login
    if (!isset($_POST)) {
        if($red->login('antonio@mail.com', 'Antonio'))
            header('Location: login.php');
    }


    // Validar campos del registro
    /* if(count($_POST) !== 0 && isset($_POST['registerUsername'])) {
        

        if($password == $password2) {
            $red->registerUser($name, $email, $password);
        } else {
            echo 'Las contraseñas no coinciden';
        }
    } */
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#07b4ff">

    <title>Index | Revels</title>

    <link rel="stylesheet" href="/css/pages/index.css">
    <link rel="shortcut icon" href="/media/icons/logo-icon.png" type="image/x-icon">
</head>
<body>
    <?php require_once('./inc/header.inc.php') ?>

    <div class="col-2 index-page">
        <!-- Log in -->
        <div class="col-item">
            <div class="index-item">
                <div class="title">Inicia sesión</div>

                <form action="#" method="post">
                    <fieldset class="white">
                        <legend>Correo electrónico</legend>
                        <input type="text" name="loginMail" placeholder="ejemplo@ejemplo.com" required>
                    </fieldset>

                    <fieldset class="white">
                        <legend>Contraseña</legend>
                        <input type="password" name="loginPassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required>
                    </fieldset>

                    <div class="input-group">
                        <input class="btn-white" type="submit" value="Iniciar sesión">
                    </div>
                </form>
            </div>
        </div>


        <!-- Sign up -->
        <div class="col-item">
            <div class="index-item">
                <div class="title">Regístrate</div>

                <form action="#" method="post">
                    <fieldset class="error">
                        <legend>Nombre de usuario</legend>
                        <input type="text" name="registerUsername" placeholder="PepeJuan17" required>

                        <img title="ERROR! Te has empanado y has puesto algo mal" class="error" src="/media/icons/exclamation-mark.svg" alt="Exclamation mark">
                    </fieldset>

                    <fieldset>
                        <legend>Correo electrónico</legend>
                        <input type="email" name="registerEmail" placeholder="ejemplo@ejemplo.com" required>
                    </fieldset>

                    <fieldset>
                        <legend>Contraseña</legend>
                        <input type="password" name="registerPassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required>
                    </fieldset>

                    <fieldset>
                        <legend>Repetir contraseña</legend>
                        <input type="password" name="registerCheckPassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required>
                    </fieldset>

                    <div class="input-group">
                        <input class="btn" type="submit" value="Registrarse">
                    </div>

                    <p class="correct">Registro realizado correctamente</p>
                </form>
            </div>
        </div>
    </div>

    <?php include_once './inc/footer.inc.php'; ?>
</body>
</html>