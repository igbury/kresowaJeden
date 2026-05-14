<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php'; 
require_once __DIR__ . '/../adminCheck.php';
requireAdmin($conn);
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}
if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
    header("Location: ".INDEX);
    exit();
}
$id = (int)$_POST['id'];
if($id>=1){
    $stmt = mysqli_prepare($conn, "DELETE FROM menu WHERE id=?;");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $_SESSION["succ"] = "Usunięto danie.";
}else{
    $_SESSION["error"] = "Niepoprawne dane.";
}
header("Location:".MODIFYMENU);
exit();

?>