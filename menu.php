<?php
session_start();
require_once(__DIR__ . "/db.php");
$error = $_SESSION["error"] ?? null;
$succ = $_SESSION["succ"] ?? null;
$error_modal = $_SESSION["error_modal"] ?? "cartModal";


unset($_SESSION["error_modal"]);
unset($_SESSION["error"]);
unset($_SESSION["succ"]);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KresowaJeden - Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- https://icons.getbootstrap.com/ -->
    
</head>
<body class="bg-dark">
    <header>
        <nav class="navbar navbar-expand-sm border border-secondary bg-dark navbar-dark fixed-top">
            <div class="container-fluid">
                <h3 class="navbar-text  mx-2 my-1">KresowaJeden</h3>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-3 my-1">
                        <a href="index.php" class="btn btn-outline-success">Home</a>
                    </li>
                    <li class="nav-item mx-3 my-1">
                        <a href="menu.php" class="btn btn-outline-success active">Menu</a>
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
                                            <li><a class="dropdown-item" href="modifyMenu.php">Modyfikuj menu</a></li>
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
                                    <a href="cart/cart.php" class="btn btn-outline-light"><i class="bi bi-cart"></i> ' . $count . ' </a>
                                </li>                            
                                <li class="nav-item mx-2 my-1">
                                    <a href="logout.php" class="btn btn-outline-danger">Wyloguj</a>
                                </li>
                            ';
                        }else{
                            echo '
                                <li class="nav-item mx-2 my-1">
                                    <a href="cart/cart.php" class="btn btn-outline-light disabled"><i class="bi bi-cart"></i></a>
                                </li>  
                                <li class="nav-item mx-2 my-1">
                                    <a href="login.php" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">Login.</a>
                                </li>                              
                            ';
                        }                        
                    ?>                    
                </ul>            
            </div>
            
        </nav>
    </header>
    <!-- polaczenie z baza danych -->
    <?php
        $z = "SELECT menu.nazwaPotrawy, menu.opis, menu.cena, menu.id FROM menu";
        $r = mysqli_query($conn, $z);
        ?>


    <main>
        <div class="container-fluid text-light py-5 mx-0 my-5 d-flex align-items-center">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php while($wiersz = mysqli_fetch_row($r)): ?>
                <div class="col">
                    <div class="card h-100 bg-dark text-light border-secondary">
                        <div class="card-body py-4 my-3">   
                            <h5 class="card-title"><?php echo $wiersz[0]; ?></h5>
                            <p class="card-text "><?php echo $wiersz[1]; ?></p>
                            <p class="card-text"><strong>Cena: </strong><?php echo $wiersz[2]; ?> zł</p>
                            <form action='cart/addToCart.php' method='POST'>
                                <input type='hidden' name='id' value='<?php echo $wiersz[3]; ?>'>
                                <button type='submit' class='btn text-light btn-outline-secondary btn-sm'>Dodaj do koszyka</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
    <!-- MODAL LOGOWANIA -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="loginModalLabel">Zaloguj się</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div> 
                
                
    <!-- FORMULARZ LOGOWANIA -->
                <form action="login.php" method="POST">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder=" ">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="pswd" name="pswd" placeholder=" ">
                            <label for="pswd">Hasło</label>
                        </div>                   
                            <a href="#" class="d-block text-center m-1 p-1 border rounded-1 border-primary lead text-decoration-none text-primary" data-bs-toggle="modal" data-bs-target="#registerModal">
                                Zarejestruj się.
                            </a>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Zaloguj</button>
                        <button type="reset" class="btn btn-danger">Resetuj</button>
                    </div>
                </form>
            </div>
        </div>  
    </div>    
                    
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>     
            
                    <!-- MODAL REJESTRACJI -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="registerModalLabel">Zarejestruj się</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>


                <!-- FORMULARZ REJESTRACJI -->
                <form action="register.php" method="POST">
                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <input type="name" class="form-control" id="name" name="name" placeholder=" ">
                            <label for="name">Imie</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder=" ">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="pswd" name="pswd" placeholder=" ">
                            <label for="pswd">Hasło</label>
                        </div>                        
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder=" ">
                            <label for="phone">Numer Telefonu</label>
                        </div>
                        <a href="#" class="d-block text-center m-1 p-1 border rounded-1 border-primary lead text-decoration-none text-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Zaloguj się
                        </a>                  
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Zarejestruj</button>
                        <button type="reset" class="btn btn-danger">Resetuj</button>
                    </div>
                </form>
            </div>
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