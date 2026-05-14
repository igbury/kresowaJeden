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
    $pass = $_POST['password'];
    
    $stmt1 = mysqli_prepare($conn, "SELECT haslo FROM klienci WHERE idKlienta = ?");
    mysqli_stmt_bind_param($stmt1, "i", $_SESSION['id']);
    mysqli_stmt_execute($stmt1);
    $result = mysqli_stmt_get_result($stmt1);
    $row = mysqli_fetch_assoc($result);    
    if(!password_verify($pass, $row['haslo'])){
        $_SESSION["error"] = "Niepoprawne hasło.";
        header("Location: ".VIEWACCOUNT);
        exit();        
    }
    $stmt = mysqli_prepare($conn, "SELECT email FROM klienci WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $newEmail);
    mysqli_stmt_execute($stmt);
    $validate = mysqli_stmt_get_result($stmt);    
    $row = mysqli_fetch_assoc($validate);
    if($row['email']==$newEmail){
        if ($validate && mysqli_num_rows($validate) > 0) {
            $_SESSION["error"] = "Ten email jest już zajęty.";
            header("Location: ".VIEWACCOUNT);
            exit();
        }    
    }

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
    if(!validatePolishPhone($newPhone)){
        $_SESSION["error"] = "Niepoprawny numer telefonu.";
        header("Location: ".VIEWACCOUNT);
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
function validatePolishPhone(string $phone): bool {
    $cleaned = preg_replace('/[\s\-\(\)]/', '', $phone);
    $pattern = '/^(?:\+48|0048)?[1-9]\d{8}$/';
    return (bool) preg_match($pattern, $cleaned);
}
?>