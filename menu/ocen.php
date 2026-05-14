<?php
    session_start();
    require_once __DIR__ . '/../db.php'; 
    require_once __DIR__ . '/../paths.php'; 
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        exit();
    }
    $_SESSION["error_modal"] = "ocenaModal";
    if (!isset($_SESSION['id'])) {
        $_SESSION["error"] = "Aby wystawić opinię musisz być zalogowany!";
        header("Location: ".INDEX);
        exit();
    }
    $klient = $_SESSION['id'];
    $danie = $_POST['danie'];
    // sprawdzenie czy danie wgl istnieje
    $stmt1 = mysqli_prepare($conn, "SELECT * FROM menu WHERE id = ?;");
    mysqli_stmt_bind_param($stmt1, "i", $danie);
    mysqli_stmt_execute($stmt1);
    $result = mysqli_stmt_get_result($stmt1);
    if ($result && mysqli_num_rows($result) == 0) {
        var_dump($result);
        $_SESSION["error"] = "Podane danie nie istnieje.";
        header("Location: ".INDEX);
        exit();
    }    
    //sprawdzenie czy klient nie ocenil juz tego dania
    $stmt2 = mysqli_prepare($conn, "SELECT idKlienta,idPotrawy FROM oceny WHERE idKlienta = ? and idPotrawy = ?;");
    mysqli_stmt_bind_param($stmt2, "ii", $klient, $danie);
    mysqli_stmt_execute($stmt2);
    $result = mysqli_stmt_get_result($stmt2);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION["error"] = "Oceniono już to danie.";
        header("Location: ".INDEX);
        exit();
    }     
    $ocena = (int) $_POST['ocena'];
    $recenzja = $_POST['recenzja'];
    
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