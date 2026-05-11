<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php'; 

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}
if($_SESSION['isAdmin']==false){
    header("Location: /../index.php");
    exit;
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

    $newMeal = "INSERT INTO menu VALUES(null, '$name', '$desc', '$price', $available)";
    $addMeal = mysqli_query($conn, $newMeal);
    $_SESSION["succ"] = "Dodano nowe danie!";
    header("Location:".MODIFYMENU);
    exit();    
}
?>