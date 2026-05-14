<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php'; 
require_once __DIR__ . '/../adminCheck.php';
requireAdmin($conn);
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}
$_SESSION["error_modal"] = "newMealModal";

if (!empty($_POST["name"]) && !empty($_POST["price"])) {
    $name = $_POST["name"];
    $available = isset($_POST["available"]) ? 1 : 0;
    if(empty($_POST["desc"])){
        $desc = "Brak opisu.";
    }else{
        $desc = $_POST["desc"];
    }
    if(!is_numeric($_POST['price']) || $_POST['price']<1){
        $_SESSION["error"] = "Niepoprawna cena.";
        header("Location: ".MODIFYMENU);
        exit();
    }
    $price = (float)$_POST["price"];
    $stmt = mysqli_prepare($conn, "INSERT INTO menu (nazwaPotrawy, opis, cena, dostepne) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssdi", $name, $desc, $price, $available);
    mysqli_stmt_execute($stmt);
    $_SESSION["succ"] = "Dodano nowe danie!";
    header("Location: ".MODIFYMENU);
    exit();    
}else{
    $_SESSION["error"] = "Pola nie mogą być puste.";
    header("Location: ".MODIFYMENU);
    exit();      
}
?>