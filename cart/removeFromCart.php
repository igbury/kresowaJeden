<?php
session_start();
require_once __DIR__ . '/../paths.php';
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['id'])){
    $id = (int)$_POST['id'];
    $akcja = $_POST['akcja'] ?? 'usun';
    
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
header("Location: ".VIEWCART);
exit;
?>