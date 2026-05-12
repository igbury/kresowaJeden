<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php'; 

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}
if(!isset($_SESSION['isAdmin'])){
    header("Location: ".INDEX);
    exit();
}
$_SESSION["error_modal"] = "newMealModal";

if (!empty($_POST["name"]) && !empty($_POST["price"])) {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $price = floatval($_POST["price"]);
    $available = isset($_POST["available"]) ? 1 : 0;
    if(empty($_POST["desc"])){
        $desc = "Brak opisu.";
    }else{
        $desc = mysqli_real_escape_string($conn,$_POST["desc"]);
    }
    if($price<1){
        $_SESSION["error"] = "Cena musi być większa niż 0";
        header("Location: ".MODIFYMENU);
        exit();
    }
    $stmt = mysqli_prepare($conn, "INSERT INTO menu (nazwaPotrawy, opis, cena, dostepne) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssdi", $name, $desc, $price, $available);
    mysqli_stmt_execute($stmt);
    $_SESSION["succ"] = "Dodano nowe danie!";
    header("Location: ".MODIFYMENU);
    exit();    
}
?>