<?php
session_start();
require_once(__DIR__ . '/../db.php');

// 1. Tylko POST, tylko zalogowany, tylko niepusty koszyk
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cart.php');
    exit();
}
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = 'Musisz być zalogowany!';
    header('Location: ../index.php');
    exit();
}
if (empty($_SESSION['cart'])) {
    $_SESSION['error'] = 'Koszyk jest pusty!';
    header('Location: cart.php');
    exit();
}

// 2. Pobieramy id klienta z sesji
$idKlienta = (int)$_SESSION['id'];

// 3. KROK 1 — tworzymy główny rekord zamówienia
//    INSERT do tabeli zamowienia — tylko kto zamawia
//    dataZamowienia wypełni się sama (DEFAULT current_timestamp)
$stmt = mysqli_prepare($conn, "INSERT INTO zamowienia (idKlienta) VALUES (?)");
mysqli_stmt_bind_param($stmt, "i", $idKlienta);
mysqli_stmt_execute($stmt);

// 4. Pobieramy id właśnie utworzonego zamówienia
//    mysqli_insert_id zwraca AUTO_INCREMENT id ostatniego INSERT
$idZamowienia = mysqli_insert_id($conn);

if (!$idZamowienia) {
    $_SESSION['error'] = 'Błąd przy tworzeniu zamówienia.';
    header('Location: cart.php');
    exit();
}

// 5. KROK 2 — dla każdej pozycji z koszyka wpisujemy osobny rekord
//    Przygotowujemy zapytanie raz, wykonujemy wiele razy (dla każdego dania)
$stmt2 = mysqli_prepare($conn, 
    "INSERT INTO pozycje_zamowienia (idZamowienia, idPotrawy, ilosc) VALUES (?, ?, ?)"
);

foreach ($_SESSION['cart'] as $idPotrawy => $ilosc) {
    $idPotrawy = (int)$idPotrawy;
    $ilosc     = (int)$ilosc;
    
    // bind_param podpina zmienne pod ? w zapytaniu
    // "iii" = trzy integery
    mysqli_stmt_bind_param($stmt2, "iii", $idZamowienia, $idPotrawy, $ilosc);
    mysqli_stmt_execute($stmt2);
}

// 6. Czyścimy koszyk z sesji — zamówienie złożone!
unset($_SESSION['cart']);

// 7. Przekierowujemy z komunikatem sukcesu
$_SESSION['succ'] = 'Zamówienie złożone! Dziękujemy 🎉';
header('Location: ../index.php');
exit();
?>