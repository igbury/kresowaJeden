<?php
    session_start();
    require_once __DIR__ . '/../paths.php';
    $_SESSION["error_modal"] = "cartModal";
    $redirect = VIEWMENU;
    if (isset($_POST['redirect']) && $_POST['redirect'] === 'cart') {
        $redirect = VIEWCART;
    }
if(!isset($_SESSION['user'])){
    $_SESSION["error"] = "Musisz być zalogowany, aby dodać do koszyka!";
    $_SESSION["error_modal"] = "loginModal";
    header("Location:".VIEWMENU);
    exit();
}
    if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['id'])){
        $id = (int)$_POST['id'];
        $stmt = "SELECT id FROM menu WHERE id=?";
        mysqli_bind_param($stmt, 'i', $id);
        $result = mysqli_stmt_execute($stmt);
        if(!$result || mysqli_num_rows($result)==0){
            $_SESSION['error'] = 'Niepoprawne danie.';
            header("Location: ".$redirect);
            exit();
        }
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
            header("Location: ".$redirect);
            exit();        
    }

    header("Location:".$redirect);
    exit();
?>