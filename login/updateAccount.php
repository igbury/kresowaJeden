<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}

if(isset($_SESSION['user'])){
    $newName = $_POST['imie'];
    $newEmail = $_POST['email'];
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION["error"] = "Niepoprawny email.";
        header("Location: ".VIEWACCOUNT);
        exit();          
    }    
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
    $_SESSION['user'] = $newEmail;    
    header("Location:".VIEWACCOUNT);
    exit();    
}else{
    header("Location: ".INDEX);
    exit();     
}
?>