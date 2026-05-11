<?php
    session_start();
    require_once __DIR__ . '/../db.php'; 
    require_once __DIR__ . '/../paths.php';      
    if(isset($_SESSION['user'])){
        $sql = "DELETE FROM klienci WHERE `klienci`.`idKlienta` = {$_SESSION['id']}";
        mysqli_query($conn, $sql);
        header("Location:".LOGOUT);
        exit();        
    }else{
        header("Location: /index.php");
        exit();           
    }
?>