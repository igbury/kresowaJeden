<?php
    session_start();
    require_once 'db.php';
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        exit();
    }
    if (!isset($_SESSION['id'])) {
        header("Location: index.php");
        exit();
    }
    $klient = $_SESSION['id'];
    $danie = mysqli_real_escape_string($conn, $_POST['danie']);
    $ocena = (int) $_POST['ocena'];
    $recenzja = mysqli_real_escape_string($conn, $_POST['recenzja']);
    $_SESSION["error_modal"] = "ocenaModal";
        
    if($recenzja==null){
        $recenzja = "Brak komentarza";
    }
    if ($ocena !=null && $ocena >= 1 && $ocena <= 5 && $danie !== '') {
        $sql = "INSERT INTO oceny
        VALUES (null, '$klient', '$danie', $ocena, '$recenzja', NOW())";
        mysqli_query($conn, $sql);
        $_SESSION["succ"] = "Wystawiono opinie.";
        header("Location: index.php");
        exit();
    }else{
        $_SESSION["error"] = "Niepoprawne dane.";
        header("Location: index.php");
        exit();        
    }   
?>