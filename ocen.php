<?php
    require_once 'db.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $danie    = mysqli_real_escape_string($conn, $_POST['danie']);
    $ocena    = (int) $_POST['ocena'];
    $recenzja = mysqli_real_escape_string($conn, $_POST['recenzja']);

    if ($ocena >= 0 && $ocena <= 5 && $danie !== '') {
        $sql = "INSERT INTO oceny (danie, ocena, recenzja) 
                VALUES ('$danie', $ocena, '$recenzja')";
        mysqli_query($conn, $sql);
    }
}
?>