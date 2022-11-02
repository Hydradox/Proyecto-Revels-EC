<?php
    require_once('./inc/Red-Objects.php');

    $loginErrors = [];
    $registerErrors = [];


    // Comprobar si está logueado
    if(isset($_COOKIE['PHPSESSID'])) {
        // Si está logueado, mostrar el header
        header('Location: /home.php');
    }

    // Comprobar login
    if (isset($_POST) && !empty($_POST)) {
        // Comprobar login nombre
        if(!isset($_POST['loginEmail']) || empty($_POST['loginEmail'])) {
            $loginErrors[] = ['loginEmail' => 'El campo email es obligatorio'];
        }

        // Comprobar login contraseña
        if(!isset($_POST['loginPassword']) || empty($_POST['loginPassword'])) {
            $loginErrors[] = ['loginPassword' => 'El campo contraseña es obligatorio'];
        }

        // Si no hay errores, comprobar si el usuario existe
        if(empty($loginErrors)) {
            // TODO: Comprobar si el usuario existe en la BBDD y redirigir a home si es correcto
        }
    }


    // Comprobar registro
    if (isset($_POST) && !empty($_POST)) {
        $expNombre = '/^\w{4,20}$/';
        $expMail = '/^[\w\.\-]+@[\w\-]+\.[\w\-\.]+$/';
        $expContrasenya = '/^\w{8,20}$/';

        // Comprobar registro nombre
        if(!isset($_POST['registerName']) || empty($_POST['registerName'])) {
            $registerErrors[] = ['registerName' => 'El campo nombre es obligatorio'];

        } else if(!preg_match($expNombre, $_POST['registerName'])) {
            $registerErrors[] = ['registerName' => 'El campo nombre debe tener entre 4 y 20 caracteres alfanuméricos'];
        }

        // Comprobar registro email
        if(!isset($_POST['registerEmail']) || empty($_POST['registerEmail'])) {
            $registerErrors[] = ['registerEmail' => 'El campo email es obligatorio'];

        } else if(!preg_match($expMail, $_POST['registerEmail'])) {
            $registerErrors[] = ['registerEmail' => 'El campo email no es válido'];
        }

        // Comprobar registro contraseña
        if(!isset($_POST['registerPassword']) || empty($_POST['registerPassword'])) {
            $registerErrors[] = ['registerPassword' => 'El campo contraseña es obligatorio'];

        } else if(!preg_match($expContrasenya, $_POST['registerPassword'])) {
            $registerErrors[] = ['registerPassword' => 'El campo contraseña debe tener entre 8 y 20 caracteres alfanuméricos'];
        }

        // Comprobar registro confirmar contraseña
        if(!isset($_POST['registerConfirmPassword']) || empty($_POST['registerConfirmPassword'])) {
            $registerErrors[] = ['registerConfirmPassword' => 'El campo confirmar contraseña es obligatorio'];
        }

        // Comprobar registro confirmar contraseña
        if(isset($_POST['registerPassword']) && isset($_POST['registerConfirmPassword']) && $_POST['registerPassword'] !== $_POST['registerConfirmPassword']) {
            $registerErrors[] = ['registerConfirmPassword' => 'Las contraseñas no coinciden'];
        }

        // Si no hay errores, comprobar si el usuario existe
        if(empty($registerErrors)) {
            // TODO: Comprobar si existe y dar error si es así
        }
    }
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
                        <input type="text" name="loginMail" placeholder="ejemplo@ejemplo.com">
                    </fieldset>

                    <fieldset class="white">
                        <legend>Contraseña</legend>
                        <input type="password" name="loginPassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
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
                    <fieldset>
                        <legend>Nombre de usuario</legend>
                        <input type="text" name="registerUsername" placeholder="PepeJuan17">

                        <img title="ERROR! Te has empanado y has puesto algo mal" class="error" src="/media/icons/exclamation-mark.svg" alt="Exclamation mark">
                    </fieldset>

                    <fieldset>
                        <legend>Correo electrónico</legend>
                        <input type="email" name="registerEmail" placeholder="ejemplo@ejemplo.com">

                        <img title="" class="error" src="/media/icons/exclamation-mark.svg" alt="Exclamation mark">
                    </fieldset>

                    <fieldset>
                        <legend>Contraseña</legend>
                        <input type="password" name="registerPassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">

                        <img title="" class="error" src="/media/icons/exclamation-mark.svg" alt="Exclamation mark">
                    </fieldset>

                    <fieldset>
                        <legend>Repetir contraseña</legend>
                        <input type="password" name="registerCheckPassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">

                        <img title="" class="error" src="/media/icons/exclamation-mark.svg" alt="Exclamation mark">
                    </fieldset>

                    <div class="input-group">
                        <input class="btn" type="submit" value="Registrarse">
                    </div>

                    <p class="correct invisible">Registro realizado correctamente</p>
                </form>
            </div>
        </div>
    </div>

    <?php include_once './inc/footer.inc.php'; ?>
</body>
</html>