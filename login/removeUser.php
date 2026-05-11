<?php
    session_start();
    require_once __DIR__ . '/../db.php'; 
    require_once __DIR__ . '/../paths.php';      
    if(isset($_SESSION['user'])){
        $_SESSION["error_modal"] = "deleteModal";        
        $pass = $_POST["pass"];
        $confirmed = isset($_POST["confirm"]) ? 1 : 0; 
        if(isset($pass)){
            //sprawdza czy podano poprawne hasło
            $stmt = mysqli_prepare($conn, "SELECT haslo FROM klienci WHERE idKlienta=?");
            mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            if (!password_verify($pass, $user['haslo'])) {
                $_SESSION["error"] = "Niepoprawne hasło.";
                header("Location:".VIEWACCOUNT);
                exit();
            }
            if($confirmed){
                $stmt = mysqli_prepare($conn, "DELETE FROM klienci WHERE idKlienta = ?");
                mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
                mysqli_stmt_execute($stmt);  
                session_destroy(); 
                session_start();
                $_SESSION["succ"] = "Usunięto konto.";
                header("Location: /index.php");
                exit();                         
            }       
            else{
                $_SESSION["error"] = "Nie zaznaczono potwierdzenia.";
                header("Location:".VIEWACCOUNT);
                exit();           
            }
        }else{
            $_SESSION["error"] = "Nie wpisano hasła.";
            header("Location:".VIEWACCOUNT);
            exit();              
        }
    }
?>