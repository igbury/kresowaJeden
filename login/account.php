<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php'; 

if(!isset($_SESSION['user'])){
    header("Location: /index.php");
    exit();
}
$error = $_SESSION["error"] ?? null;
$succ = $_SESSION["succ"] ?? null;
$error_modal = $_SESSION["error_modal"] ?? "loginModal";

unset($_SESSION["error"]);
unset($_SESSION["succ"]);
$stmt = mysqli_prepare($conn, "SELECT idKlienta, imie, email, nr_telefonu FROM klienci WHERE idKlienta = ?");
mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$klient = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KresowaJeden | Konto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- https://icons.getbootstrap.com/ -->
</head>    
<body class="bg-dark">
    <!-- NAVBAR -->
    <header>
        <nav class="navbar navbar-expand-sm border border-secondary bg-dark navbar-dark fixed-top">
            <div class="container-fluid">
                <h3 class="navbar-text  mx-2 my-1">KresowaJeden</h3>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-3 my-1">
                        <a href="index.php" class="btn btn-outline-success">Home</a>
                    </li>
                    <li class="nav-item mx-3 my-1">
                        <a href="<?=VIEWMENU?>" class="btn btn-outline-success">Menu</a>
                    </li>
                    <?php
                        if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']==true){
                            echo '
                                <li class="nav-item mx-3 my-1">
                                    <div class="dropend">
                                        <a class="btn btn-outline-danger dropdown-toggle" role="button" data-bs-theme="dark" data-bs-toggle="dropdown" aria-expanded="false">
                                            Administracja
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li><a class="dropdown-item" href="'.MODIFYMENU.'">Modyfikuj menu</a></li>
                                            <li><a class="dropdown-item disabled" href="#">Zarządzaj pracownikami</a></li>
                                            <li><a class="dropdown-item disabled" href="#">Zarządzaj restauracją</a></li>
                                        </ul>
                                    </div>
                                </li>
                            ';
                        }else{
                            echo '
                                <li class="nav-item mx-3 my-1">
                                    <a href="#" class="btn btn-outline-success">Rezerwacja</a>
                                </li>  
                                <li class="nav-item mx-3 my-1">
                                    <a href="#" class="btn btn-outline-success">Kontakt</a>
                                </li>                                                           
                            ';
                        }                        
                    ?>       


                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php
                        if(isset($_SESSION['user'])){
                            $count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
                            echo '
                                <li class="nav-item mx-2 my-1">
                                    <a href="' . VIEWCART . '" class="btn btn-outline-light"><i class="bi bi-cart"></i> '. $count .' </a>
                                </li>             
                                <li class="nav-item mx-2 my-1">
                                    <a href="' . VIEWACCOUNT . '" class="btn btn-outline-light active"><i class="bi bi-person-fill"></i>   </a>
                                </li>                                            
                                <li class="nav-item mx-2 my-1">
                                    <a href="' . LOGOUT . '" class="btn btn-outline-danger">Wyloguj</a>
                                </li>
                            ';
                        }else{
                            
                            echo '
                                <li class="nav-item mx-2 my-1">
                                    <a href="'. VIEWCART .'" class="btn btn-outline-light disabled" ><i class="bi bi-cart"></i></a>
                                </li>  
                                <li class="nav-item mx-2 my-1">
                                    <a href="'. LOGIN .'" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">Login.</a>
                                </li>                              
                            ';
                        }                        
                    ?>                    
                </ul>            
            </div>
            
        </nav>
    </header>

    <!-- MAIN -->
    <main class="bg-dark text-light" style="padding-top: 80px;">
        <div class="container py-5" style="max-width: 700px;">
            <!-- NAGLOWEk-->
            <h3 class="mb-1"><i class="bi bi-person-square me-3"></i>Konto Klienta</h3>
            <p class="text-secondary mb-4"><?=htmlspecialchars($klient['email'])?></p>
            <hr class="border-secondary mb-4">
            <!--DANE KLIENTA-->
            <div class="card bg-dark border border-secondary mb-4">
                <div class="card-header border-secondary d-flex justify-content-between text-light align-items-center">
                    <span><i class="bi bi-info-circle me-2"></i>Twoje dane</span>
                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal">Edytuj</button>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-2 text-secondary">Imię</div>
                        <div class="col-4 text-light"><?=htmlspecialchars($klient['imie'])?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-2 text-secondary">Email</div>
                        <div class="col-4 text-light"><?=htmlspecialchars($klient['email'])?></div>
                    </div>
                    <div class="row">
                        <div class="col-2 text-secondary">Telefon</div>
                        <div class="col-4 text-light"><?=htmlspecialchars($klient['nr_telefonu'])?></div>
                    </div>
                </div>
            </div>
        </div>
    
    
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>