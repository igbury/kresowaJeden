<?php
function requireAdmin($conn) {
    if (!isset($_SESSION['id'])) {
        header("Location: " . INDEX);
        exit();
    }
    $stmt = mysqli_prepare($conn, "SELECT isAdmin FROM klienci WHERE idKlienta = ?");
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if (!$row || $row['isAdmin'] != 1) {
        unset($_SESSION['isAdmin']);
        header("Location: " . INDEX);
        exit();
    }

    $_SESSION['isAdmin'] = true;
}