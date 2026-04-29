<?php
session_start();
require_once("db.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit();
}
if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
    header("Location: index.php");
    exit();
}
$id = (int)$_POST['id'];
if($id>=1){
    $sql = "DELETE FROM menu WHERE id = $id";
    mysqli_query($conn, $sql);
    $_SESSION["succ"] = "Usunięto danie.";
}else{
    $_SESSION["error"] = "Niepoprawne dane.";
}
header("Location: modifyMenu.php");
exit();

?>