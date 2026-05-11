<?php
    session_start();
    if(isset($_SESSION['user'])){
        session_destroy();
        session_start();
        $_SESSION["succ"] = "Wylogowano!";
        header("Location: /../index.php");
        exit();        
    }else{
            header("Location: /../index.php");
            exit();           
    }
?>