<?php
require_once 'db.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}
if (!empty($_POST["email"]) && !empty($_POST["pswd"])) {

    if (!$conn) {
        $error = "Błąd połączenia z bazą danych.";
    } else {
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $password = $_POST["pswd"];

        $sql = "SELECT email, haslo FROM klienci WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['haslo'])) {
                $_SESSION['user'] = $email;
                $_SESSION["succ"] = "Zalogowano!";
                header("Location: index.php");
                exit();
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