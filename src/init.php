<?php
    session_start();
    require_once '../config/config.php';
    require_once '../vendor/autoload.php';
    use Routes\Routes;
    require_once '../src/Views/Layout/header.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
    Routes::index();
?>

    
<?php

