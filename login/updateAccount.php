<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}
$_SESSION["error_modal"] = "editModal";

if(isset($_SESSION['user'])){
    $newName = $_POST['imie'];
    $newEmail = $_POST['email'];
    $newPhone = $_POST['nr_telefonu'];
    //sprawdza czy pola nie sa puste
    if (empty($newName) || empty($newEmail) || empty($newPhone)) {
        $_SESSION["error"] = "Wypełnij wszystkie pola.";
        header("Location:".VIEWACCOUNT);
        exit();
    }    
    // zapytanie o zaktualizowaniu danych
    $stmt = mysqli_prepare($conn, "UPDATE klienci SET imie = ?, email = ?, nr_telefonu = ? WHERE idKlienta = ?;");
    mysqli_stmt_bind_param($stmt, "sssi", $newName, $newEmail, $newPhone, $_SESSION['id']);
    mysqli_stmt_execute($stmt);
    $_SESSION["succ"] = "Zmieniono dane!";
    header("Location:".VIEWACCOUNT);
    exit();    
}else{
    header("Location: /index.php");
    exit();     
}
?>