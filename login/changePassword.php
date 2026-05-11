<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';  
if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (!empty($_POST["oldPass"]) && !empty($_POST["newPass"]) && !empty($_POST["newPass2"])) {
    $newPass = $_POST["newPass"];
    $newPass2 = $_POST["newPass2"];
    $oldPass = $_POST["oldPass"];
    // sprawdza czy hasla nie sa takie same    
    if($oldPass == $newPass){
        $_SESSION["error"] = "Hasła nie mogą być takie same.";
        header("Location:".VIEWACCOUNT);
        exit();
    }
    //sprawdza czy wartosc z drugiego inputa z nowym haslem ma ta sama wartosc
    if($newPass != $newPass2){
        $_SESSION["error"] = "Nowe hasła muszą być takie same.";
        header("Location:".VIEWACCOUNT);
        exit();        
    }
    //sprawdza czy stare haslo sie zgadza
    $stmt = mysqli_prepare($conn, "SELECT haslo FROM klienci WHERE idKlienta=?");
    mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if (!password_verify($oldPass, $user['haslo'])) {
        $_SESSION["error"] = "Stare hasło jest nieprawidłowe.";
        header("Location:".VIEWACCOUNT);
        exit();
    }    
    // zmiana hasla 
    $hash = password_hash($newPass, PASSWORD_DEFAULT);
    $stmt2 = mysqli_prepare($conn, "UPDATE klienci SET haslo=? where idKlienta=?");
    mysqli_stmt_bind_param($stmt2, "si", $hash, $_SESSION['id']);
    mysqli_stmt_execute($stmt2);

    $_SESSION["succ"] = "Zmieniono hasło!";
    header("Location:".VIEWACCOUNT);
    exit();

} else {
    $_SESSION["error"] = "Musisz wypelnic dane.";
    header("Location:".VIEWACCOUNT);
    exit();
}
?>