<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}
$_SESSION["error_modal"] = "loginModal";
if (!empty($_POST["email"]) && !empty($_POST["pswd"])) {
    if (!$conn) {
            $_SESSION["error"] = "Błąd połączenia z bazą danych.";
            header("Location: index.php");
            exit();
    } else {
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = $_POST["pswd"];
        $sql = "SELECT idKlienta, email, haslo, isAdmin FROM klienci WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['haslo'])) {
                $_SESSION['id'] = $row['idKlienta'];
                $_SESSION['user'] = $email;
                $_SESSION['isAdmin'] = (isset($row['isAdmin']) && $row['isAdmin'] == 1);
                $_SESSION["succ"] = "Zalogowano!";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION["error"] = "Niepoprawny login lub hasło.";
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION["error"] = "Niepoprawny login lub hasło.";
            header("Location: index.php");
            exit();
        }
    }
} else {
    $_SESSION["error"] = "Musisz wpisac swoje dane.";
    header("Location: index.php");
    exit();
}
?>