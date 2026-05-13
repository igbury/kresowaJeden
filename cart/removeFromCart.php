<?php
session_start();
require_once __DIR__ . '/../paths.php';
if(!isset($_SESSION['user'])){
    header("Location: ".INDEX);
    exit();
}
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['id'])){
    $id = (int)$_POST['id'];
    $akcja = $_POST['akcja'] ?? 'usun';
    if(isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id] >= 1){
        if($akcja === 'zmniejsz'){
            if($_SESSION['cart'][$id] > 1){
                $_SESSION['cart'][$id]--;
            } else {
                unset($_SESSION['cart'][$id]);
            }
        } else {
            unset($_SESSION['cart'][$id]);
        }
    }
}
$_SESSION["succ"] = "Usunięto danie z koszyka!";
header("Location: ".VIEWCART);
exit;
?>