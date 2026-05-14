<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . INDEX);
    exit();
}
$_SESSION["error_modal"] = "loginModal";

if (empty($_POST["email"]) || empty($_POST["pswd"])) {
    $_SESSION["error"] = "Musisz wpisać swoje dane.";
    header("Location: ".INDEX);
    exit();
}
    $stmt = mysqli_prepare($conn, "SELECT idKlienta, email, haslo, isAdmin FROM klienci WHERE email = ?");
    if(!$stmt){
        $_SESSION["error"] = "Błąd serwera.";
        header("Location: ".INDEX);
        exit();
    }
    //                             s = string  
    //                             i = integer (int)
    //                             d = decimal (float)
    //                             b = blob
    session_regenerate_id(true);
    mysqli_stmt_bind_param($stmt, "s", $_POST["email"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    if($result &&mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($_POST["pswd"], $row['haslo'])){
            $_SESSION['id'] = $row['idKlienta'];
            $_SESSION['user'] = $_POST['email'];
            $_SESSION['isAdmin'] = (isset($row['isAdmin']) && $row['isAdmin'] == 1);
            $_SESSION["succ"] = "Zalogowano!";
            
            header("Location: ".INDEX);
            exit();
        }
    }
$_SESSION["error"] = "Niepoprawny login lub hasło.";
header("Location: ".INDEX);
exit();
?>