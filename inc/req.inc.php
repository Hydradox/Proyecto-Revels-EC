<?php
    $dsn = 'mysql:host=localhost;dbname=revels';
    $user = 'revel';
    $password = 'lever';
    
    try {
        $con = new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit();
    }

    // Comprobar sesión
    ini_set('session.cookie_lifetime', 60 * 30); // 30m
    session_start();


    // Comprobar login
    if(isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
    } else {
        $user = null;
    }