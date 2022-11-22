<?php
    $dsn = 'mysql:host=localhost;dbname=revels';
    $user = 'revel';
    $password = 'lever';
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ];
    
    try {
        $con = new PDO($dsn, $user, $password, $options);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit();
    }

    // Comprobar sesión
    ini_set('session.cookie_lifetime', 60 * 60); // 60m
    session_start();


    // Comprobar login
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else {
        $user = null;
    }



    function formatTime($time) {
        $time = strtotime($time);
        $time = time() - $time;
        $time = ($time < 1) ? 1 : $time;
        $tokens = array (
            31536000 => 'año',
            2592000 => 'mes',
            604800 => 'semana',
            86400 => 'día',
            3600 => 'hora',
            60 => 'minuto',
            1 => 'segundo'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }
    }