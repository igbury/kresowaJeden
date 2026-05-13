<?php
    session_start();
    require_once __DIR__ . '/../paths.php';      
    if(isset($_SESSION['user'])){
        session_destroy();
        setcookie(session_name(), '', time()-3600);
        session_start();
        $_SESSION["succ"] = "Wylogowano!";
        header("Location: ".INDEX);
        exit();        
    }else{
            header("Location: ".INDEX);
            exit();           
    }
?>