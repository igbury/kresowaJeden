<?php
    session_start();
    require_once __DIR__ . '/../paths.php';
    $_SESSION["error_modal"] = "cartModal";

    if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_SESSION['user'])) {
        $_SESSION['error'] = "Musisz być zalogowany aby wysłać wiadomość.";
        header("Location:".CONTACT);
        exit();
    }
    if (!empty($_POST["wiadomosc"])) {
        $temat = $_POST['temat'];
        if(empty($temat)){
            $temat = "Bez tematu";
        }
        $_SESSION['succ'] = "Wiadomość o tytule ".$temat." została wysłana.";
        header("Location:".CONTACT);
        exit();
    }else{
        $_SESSION['error'] = "Musisz wypełnić treść wiadomości.";
        header("Location:".CONTACT);
        exit();
    }
?>