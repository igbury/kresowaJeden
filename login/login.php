<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//uzywaj tego jak musisz sprawdzic co ci nie dziala w jakims skrypcie php'a

session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}
$_SESSION["error_modal"] = "loginModal";

if (empty($_POST["email"]) || empty($_POST["pswd"])) {
    $_SESSION["error"] = "Musisz wpisać swoje dane.";
    header("Location: /index.php");
    exit();
}
    //to robi zapytanie i podstawia ? jako placeholder na maila
    $stmt = mysqli_prepare($conn, "SELECT idKlienta, email, haslo, isAdmin FROM klienci WHERE email = ?");
    if(!$stmt){
        $_SESSION["error"] = "Błąd serwera.";
        header("Location: /index.php");
        exit();
    }
    //przypisuje z forma dane do placeholdera, 's' oznacza string
    //                             s = string  
    //                             i = integer (int)
    //                             d = decimal (float)
    //                             b = blob
    
    mysqli_stmt_bind_param($stmt, "s", $_POST["email"]);
    //wykonuje zapytanie z podstawionym mailem
    mysqli_stmt_execute($stmt);
    //pobiera wyniki tak jak wcześniej
    $result = mysqli_stmt_get_result($stmt);
    if($result &&mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($_POST["pswd"], $row['haslo'])){
            $_SESSION['id'] = $row['idKlienta'];
            $_SESSION['user'] = $_POST['email'];
            $_SESSION['isAdmin'] = (isset($row['isAdmin']) && $row['isAdmin'] == 1);
            $_SESSION["succ"] = "Zalogowano!";
            header("Location: /index.php");
            exit();
        }
    }
$_SESSION["error"] = "Niepoprawny login lub hasło.";
header("Location: /index.php");
exit();
?>