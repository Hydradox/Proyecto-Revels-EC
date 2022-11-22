<?php
    require_once 'inc/req.inc.php';

    session_destroy();
    header('Location: /index.php');