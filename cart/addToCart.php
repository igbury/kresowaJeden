<?php
    session_start();

    $_SESSION["error_modal"] = "cartModal";

if(!isset($_SESSION['user'])){
    $_SESSION["error"] = "Musisz być zalogowany, aby dodać do koszyka!";
    $_SESSION["error_modal"] = "loginModal";
    header("Location: ../menu.php");
    exit();
}
    if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['id'])){
        $id = (int)$_POST['id'];

        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }
        //to sprawdza, czy uzytkownik nie ma w koszyku juz tego produkut, jezeli ma to dodaje go ponownie. 
        if(isset($_SESSION['cart'][$id])){
            $_SESSION['cart'][$id]++;
        }else{
            $_SESSION['cart'][$id] = 1;
        }
            $_SESSION["succ"] = "Dodano potrawę do koszyka!";
            header("Location: ../menu.php");
            exit();        
    }

    header("Location: ../menu.php");
    exit;
?>