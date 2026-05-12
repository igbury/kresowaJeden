<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';  
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}
$_SESSION["error_modal"] = "registerModal";

if (!empty($_POST["name"]) && !empty($_POST["email"]) && !empty($_POST["pswd"]) && !empty($_POST["phone"])) {
    
    // sprawdz czy email juz istnieje
    $stmt = mysqli_prepare($conn, "SELECT email FROM klienci WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $_POST["email"]);
    mysqli_stmt_execute($stmt);
    $validate = mysqli_stmt_get_result($stmt);

    if ($validate && mysqli_num_rows($validate) > 0) {
        $_SESSION["error"] = "Uzytkownik o tym loginie juz istnieje.";
        header("Location: ".INDEX);
        exit();
    }
    if(strlen($_POST['pswd'])<6){
        $_SESSION["error"] = "Hasło musi być dłuższe niż 6 znaków.";
        header("Location: ".INDEX);
        exit();        
    }
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION["error"] = "Niepoprawny email.";
        header("Location: ".INDEX);
        exit();          
    }
    // dodaj nowego uzytkownika
    $hash = password_hash($_POST["pswd"], PASSWORD_DEFAULT);
    $stmt2 = mysqli_prepare($conn, "INSERT INTO klienci VALUES (null, ?, ?, ?, ?, false)");
    mysqli_stmt_bind_param($stmt2, "ssss", $_POST["name"], $hash, $_POST["email"], $_POST["phone"]);
    mysqli_stmt_execute($stmt2);

    $_SESSION["succ"] = "Zarejestrowano!";
    header("Location: ".INDEX);
    exit();

} else {
    $_SESSION["error"] = "Musisz wypelnic dane.";
    header("Location: ".INDEX);
    exit();
}
?>