<?php
    session_start();
    require_once __DIR__ . '/../db.php'; 
    require_once __DIR__ . '/../paths.php'; 
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        exit();
    }
    if (!isset($_SESSION['id'])) {
        $_SESSION["error"] = "Aby wystawić opinię musisz być zalogowany!";
        header("Location: /index.php");
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
        $stmt = mysqli_prepare($conn, "INSERT INTO oceny VALUES (null, ?, ?, ?, ?, NOW())");
        if(!$stmt){
            $_SESSION["error"] = "Błąd serwera.";
            header("Location: ".INDEX);
            exit();
        }
        mysqli_stmt_bind_param($stmt, "isis", $klient, $danie, $ocena, $recenzja);
        mysqli_stmt_execute($stmt);
        $_SESSION["succ"] = "Wystawiono opinie.";
        header("Location: /index.php");
        exit();
    }else{
        $_SESSION["error"] = "Niepoprawne dane.";
        header("Location: /index.php");
        exit();        
    }   
?>