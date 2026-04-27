<?php
require_once 'db.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}

if (!empty($_POST["name"])&&!empty($_POST["email"])&&!empty($_POST["pswd"]) && !empty($_POST["phone"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, password_hash($_POST["pswd"], PASSWORD_DEFAULT));
    $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
    $sql = "SELECT email FROM klienci WHERE email = '$email'";
    $validate = mysqli_query($conn, $sql);
    if ($validate && mysqli_num_rows($validate) > 0) {
        echo "<p>Istnieje już użytkownik o tym loginie!</p>";
    } else {
        $newUser = "INSERT INTO klienci VALUES(null, '$name', '$password','$email', '$phone')";
            $addUser = mysqli_query($conn, $newUser);
        echo "<p>Zostałeś zarejestrowany! Kliknij <a href='login.php'>tutaj</a>, aby się zalogować.";
        header("Location: index.php");
        exit();
    }
} else {
    echo "<p>Musisz wpisać swoje dane!.</p>";
}
?>