<?php
session_start();
require_once __DIR__ . '/db.php'; 
require_once __DIR__ . '/paths.php';
date_default_timezone_set('Europe/Warsaw');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: " . INDEX);
    exit();
}
$_SESSION["error_modal"] = "bookModal1";
switch($_POST['bookPage']){
    case 1:
        if($_POST['guestNum']>=1 && $_POST['guestNum']<9){
            $_SESSION['book_guest_number'] = $_POST['guestNum'];
            $_SESSION['open_modal'] = 'bookModal2';
            header("Location: ".INDEX);
            exit();
        }else{
            $_SESSION['error'] = "Liczba gości musi mieścić się w przedziale od 1 do 8.";
            header("Location: ".INDEX);
            exit();
        }
        break;
    case 2:
        if(!empty($_POST['tableNum'])){
            $_SESSION['book_table_number'] = $_POST['tableNum'];
            $_SESSION['open_modal'] = 'bookModal3';
            header("Location: ".INDEX);
            exit();
        }else{
            $_SESSION['error'] = "Niepoprawny numer stolika.";
            header("Location: ".INDEX);
            exit();            
        }
    case 3:
        if(empty($_POST['bookDate'])){
            $_SESSION['error'] = "Musisz wpisać datę.";
            header("Location: ".INDEX);
            exit();              
        }
        $targetDay = new DateTime($_POST['bookDate']);
        $now = new DateTime();
        $currentDay = new DateTime($now->format('Y-m-d'));

        $targetHour = (int)$_POST['bookTime'];
        $currentHour = (int)$now->format('H');

        $timeDiff = $targetHour-$currentHour;
        $targetDay->setTime($targetHour, 0, 0);
        $dateStr = $targetDay->format('Y-m-d H:i:s');        

        if($targetDay>$currentDay){
            $guestNum = (int)$_SESSION['book_guest_number'];
            $tableNum = (int)$_SESSION['book_table_number'];
            $stmt = mysqli_prepare($conn, "INSERT INTO rezerwacje (idKlienta, liczbaGosci, numerStolika, dataRezerwacji) VALUES(?, ?, ?, ?);");
            mysqli_stmt_bind_param($stmt, "iiis", $_SESSION['id'], $guestNum, $tableNum, $dateStr);
            mysqli_stmt_execute($stmt);
            $stmt2 = mysqli_prepare($conn, "UPDATE stoliki SET zarezerwowany = 1 WHERE numerStolika = ?");
            mysqli_stmt_bind_param($stmt2, "i", $tableNum);
            mysqli_stmt_execute($stmt2);    
            $dateStr = $targetDay->format('Y-m-d');     
            $_SESSION['succ'] = "Zarezerwowano stolik #{$tableNum} na dzień {$dateStr} i godzinę {$targetHour}:00.";
            header("Location: ".INDEX);
            exit();             
        }else if($targetDay==$currentDay){
            if($timeDiff>=1){
                $guestNum = (int)$_SESSION['book_guest_number'];
                $tableNum = (int)$_SESSION['book_table_number'];
                $stmt = mysqli_prepare($conn, "INSERT INTO rezerwacje (idKlienta, liczbaGosci, numerStolika, dataRezerwacji) VALUES(?, ?, ?, ?);");
                mysqli_stmt_bind_param($stmt, "iii", $_SESSION['id'], $guestNum, $tableNum);
                mysqli_stmt_execute($stmt);
                $stmt2 = mysqli_prepare($conn, "UPDATE stoliki SET zarezerwowany = 1 WHERE numerStolika = ?");
                mysqli_stmt_bind_param($stmt2, "i", $tableNum);
                mysqli_stmt_execute($stmt2);
                $dateStr = $targetDay->format('Y-m-d');            
                $_SESSION['succ'] = "Zarezerwowano stolik #{$tableNum} na godzinę {$targetHour}:00.";
                header("Location: ".INDEX);
                exit();                   
            }else{
                $_SESSION['error'] = "Rezerwacja musi być złożona wcześniej niż godzinę przed.";
                header("Location: ".INDEX);
                exit(); 
            }
        }else{
            $_SESSION['error'] = "Nie możesz złożyć rezerwacji na tą datę.";
            header("Location: ".INDEX);
            exit(); 
        }
        break;
    default:
        header("Location: ".INDEX);
        exit();     
}

?>