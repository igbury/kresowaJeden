<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';

if(!isset($_SESSION['user'])){
    header("Location: ".INDEX);
    exit();
}
if($_SERVER['REQUEST_METHOD']!=='POST'){
    header("Location: ".VIEWCART);
    exit();
}
if(empty($_SESSION['cart'])){
    $_SESSION['error'] = "Twój koszyk jest pusty.";
    header("Location: ".VIEWCART);
    exit();
}


try{
    $idKlienta = (int)$_SESSION['id'];   
    mysqli_begin_transaction($conn);
    $stmt = mysqli_prepare($conn,"INSERT INTO zamowienia (idKlienta, dataZamowienia) VALUES(?, NOW());");
    mysqli_stmt_bind_param($stmt, 'i', $idKlienta);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $idZamowienia = mysqli_insert_id($conn);

    $stmtPozycja = mysqli_prepare($conn, "INSERT INTO pozycje_zamowienia (idZamowienia, idPotrawy, ilosc) VALUES (?,?,?)");
    foreach($_SESSION['cart'] as $idPotrawy =>$ilosc){
        $idPotrawy = (int) $idPotrawy;
        $ilosc = (int) $ilosc;
        $stmt = mysqli_prepare($conn,"SELECT id FROM menu WHERE id=? AND dostepne = 1;");
        mysqli_stmt_bind_param($stmt,"i", $idPotrawy);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(!$result||mysqli_num_rows($result)==0){
            throw new Exception("Potrawa o id=$idPotrawy nie istnieje, lub jest niedostępna.");
        }

        mysqli_stmt_bind_param($stmtPozycja, 'iii', $idZamowienia, $idPotrawy, $ilosc);
        mysqli_stmt_execute($stmtPozycja);
    }
    mysqli_stmt_close($stmtPozycja);
    mysqli_commit($conn);
    unset($_SESSION['cart']);
    $_SESSION['succ'] = "Zamówienie o numerze #$idZamowienia zostało złożone.";
    header("Location: ".VIEWCART);
    exit();
}catch(Exception $e){
    mysqli_rollback($conn);
    $_SESSION['error'] = 'Błąd podczas składania zamówienia: '.$e->getMessage();
    header("Location: ".VIEWCART);
    exit();
}
?>