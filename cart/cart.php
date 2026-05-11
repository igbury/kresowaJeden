
<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';  
$error = $_SESSION["error"] ?? null;
$succ = $_SESSION["succ"] ?? null;
$error_modal = $_SESSION["error_modal"] ?? "loginModal";

if(!isset($_SESSION["user"])){
    $_SESSION["error"] = "Musisz być zalogowany, aby zobaczyć koszyk!";
    header("Location: /../index.php");
    exit();
}
unset($_SESSION["error_modal"]);
unset($_SESSION["error"]);
unset($_SESSION["succ"]);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KresowaJeden</title>
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
                        <a href="<?=INDEX?>" class="btn btn-outline-success">Home</a>
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
                            echo '
                                <li class="nav-item mx-2 my-1">
                                    <a href="'.VIEWCART.'" class="btn btn-outline-light active"><i class="bi bi-cart"></i></a>
                                </li>                            
                                <li class="nav-item mx-2 my-1">
                                    <a href="'.LOGOUT.'" class="btn btn-outline-danger">Wyloguj</a>
                                </li>
                            ';
                        }else{
                            echo '
                                <li class="nav-item mx-2 my-1">
                                    <a href="'.VIEWCART.'" class="btn btn-outline-light"><i class="bi bi-cart"></i></a>
                                </li>  
                                <li class="nav-item mx-2 my-1">
                                    <a href="'.LOGIN.'" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">Login.</a>
                                </li>                              
                            ';
                        }                        
                    ?>                    
                </ul>            
            </div>
            
        </nav>
    </header>

    <!-- MAIN -->
    <main class="bg-dark">
        <div class="container text-light p-5 my-5 d-flex justify-content-center align-items-center">
            <div class="d-flex flex-column align-items-center">
                <table class="table table-dark w-auto table-bordered table-striped table-hover caption-top">
                    <caption class="text-light text-center">
                        <h4>Twój koszyk</h4>
                    </caption>
                    <thead>
                        <?php
                            if(!empty($_SESSION['cart'])){
                                echo '<th scope="col"style="min-width:150px; max-width: 300px;">Potrawa</th>';
                                echo '<th scope="col"style="min-width:80px; max-width: 120px;">Cena</th>';
                                echo '<th scope="col"style="min-width:80px; max-width: 120px;">Ilosc</th>';
                                echo '<th scope="col" style="width:1%">Akcje</th>';
                            }
                        ?>
                    </thead>
                    <tbody>
                        <?php
                            $sumaCen = 0;
                            if(!empty($_SESSION['cart'])){
                                foreach($_SESSION['cart'] as $mealId=>$amount){
                                    $id = (int)$mealId;
                                    $ilosc = (int)$amount;
                                    $sql = "SELECT id,nazwaPotrawy,cena FROM menu WHERE id=$id";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);                                   
                                    if($row){
                                        $sumaCen += $row['cena']*$amount;
                                        echo '<tr>';
                                        echo "<td>{$row['nazwaPotrawy']}</td>";
                                        echo "<td>{$row['cena']}zł</td>";
                                        echo "<td>" . $amount . "</td>";
                                        echo "<td style='width:1%'>
                                                <div class='d-flex gap-1'>
                                                    <form action='".REMOVEFROMCART."' method='POST'>
                                                        <input type='hidden' name='id' value='{$row['id']}'>
                                                        <input type='hidden' name='akcja' value='zmniejsz'>
                                                        <button type='submit' class='btn btn-outline-warning btn-sm'>-</button>
                                                    </form>
                                                    <form action='".REMOVEFROMCART."' method='POST'>
                                                        <input type='hidden' name='id' value='{$row['id']}'>
                                                        <input type='hidden' name='akcja' value='usun'>
                                                        <button type='submit' class='btn btn-outline-danger btn-sm'><i class='bi bi-trash'></i></button>
                                                    </form>
                                                </div>
                                            </td>";
                                        echo '</tr>';
                                    }
                                }
                            }else{
                                echo '<tr><td colspan="5" class="text-center">Koszyk jest pusty.</td></tr>';
                                echo '<tr><td colspan="5" class="text-center"><a href="'.VIEWMENU.'" class="btn btn-outline-success text-light">Dodaj potrawy do koszyka!</a></td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            <div class="py-3 text-center">
                <?php
                    if(!empty($_SESSION['cart'])){
                        echo '<form action="'.PAYMENT.'" method="post">';
                        echo "<p>Suma do zapłaty: {$sumaCen} zł</p>";
                        echo '<button type="submit" class="btn btn-outline-success text-light">Zapłać</button>';
                        echo '</form>';
                    }
                ?>
            </div>            
        </div>
        <!-- TOAST ERROR -->
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
                    <?php if ($error): ?>
                    <div id="loginToastERR" class="toast align-items-center text-bg-danger border-0" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                <?= htmlspecialchars($error) ?>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- TOAST SUCCESS -->
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
                    <?php if ($succ): ?>
                    <div id="loginToastSUCC" class="toast align-items-center text-bg-success border-0" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                <?= htmlspecialchars($succ) ?>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>                
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


<?php if ($error): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = new bootstrap.Modal(document.getElementById('<?= $error_modal ?>'));
    modal.show();

    var toastEl = document.getElementById('loginToastERR');
    var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
});
</script>
<?php endif; ?>
<?php if ($succ): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var toastEl = document.getElementById('loginToastSUCC');
    var toast = new bootstrap.Toast(toastEl, {
        delay: 3000
    });
    toast.show();
});
</script>
<?php endif; ?>
</body>
</html>