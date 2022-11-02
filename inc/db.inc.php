<?php
    $dsn = 'mysql:host=localhost;dbname=dungeonsanddragons';
    $user = 'revel';
    $password = 'lever';

    $con;
    $conSuccess = false;
    
    try {
        $con = new PDO($dsn, $user, $password);
        $conSuccess = true;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }