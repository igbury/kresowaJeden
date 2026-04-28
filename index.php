<?php
session_start();
require 'db.php';
$error = $_SESSION["error"] ?? null;
$succ = $_SESSION["succ"] ?? null;

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
                <h3 class="navbar-text">KresowaJeden</h3>
                <ul class="navbar-nav ms-auto border rounded-2 px-2">
                    <li class="nav-item mx-3 my-1"><a href="#" class="nav-link active">Lorem.</a></li>
                    <li class="nav-item mx-3 my-1"><a href="#" class="nav-link">Lorem.</a></li>
                    <li class="nav-item mx-3 my-1"><a href="#" class="nav-link">Lorem.</a></li>
                    <li class="nav-item mx-3 my-1"><a href="#" class="nav-link">Lorem.</a></li>
                </ul>
                <ul class="navbar-nav ms-auto border rounded-2">
                    <?php
                        if(isset($_SESSION['user'])){
                            echo '
                                <li class="nav-item border border-danger mx-3">
                                    <a href="logout.php" class="nav-link text-white">Wyloguj.</a>
                                </li>
                                    <li class="nav-item mx-3">
                                    <a href="#" class="nav-link active"><i class="bi bi-cart"></i></a>
                                </li>
                                
                            ';
                        }else{
                            echo '
    <li class="nav-item mx-3">
        <a href="#" class="nav-link"><i class="bi bi-cart"></i></a>
    </li>  
    <li class="nav-item mx-3">
        <a href="#" class="nav-link text-white" data-bs-toggle="modal" data-bs-target="#loginModal">Login.</a>
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
        <div class="container-fluid text-light py-5 mx-0 my-5 d-flex align-items-center">
            <div class="container bg- mx-5">
                <h2 class="m-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, eius.</h2>
                <?php
                    if(isset($_SESSION['user'])){
                        echo '<h5>Zalogowany: '.$_SESSION['user'].'</h5>';
                    }
                ?>
                <button class="btn btn-outline-danger mx-5 my-3 ">Zobacz Menu</button>
                <button class="btn btn-outline-light">Zarezerwuj Stolik</button>
                <button class="btn btn-outline-danger mx-5" data-bs-toggle="modal" data-bs-target="#ocenaModal">Ocen danie</button>
                <hr class="my-5">
                <div class="row text-center border border-secondary">
                    <div class="col border border-secondary p-3">
                        <h1 class="text-warning fw-bold">2</h1>
                        <p class="text-uppercase small text-light mb-0">lat działalności</p>
                    </div>
                    <div class="col border border-secondary p-3">
                        <h1 class="text-warning fw-bold">14</h1>
                        <p class="text-uppercase small text-light mb-0">dań w menu</p>
                    </div>
                    <div class="col border border-secondary p-3">
                        <h1 class="text-warning fw-bold">5.0</h1>
                        <p class="text-uppercase small text-light mb-0">ocen gości</p>
                    </div>
                </div>
            </div>
            <div id="mainImage" class="container mx-5">
                <img src="./img/kotlet.png" alt="kotlet">
            </div>
        </div>

        <!-- Dania dnia -->
        <div class="fixed-bottom w-100 bg-dark bg-opacity-75 py-3 border border-light">
            <div class="container text-center">
                <h3 class="text-danger d-flex align-items-center justify-content-center gap-3">
                    <span class="display-6">V</span>
                    <span>Dania dnia</span> 
                    <span class="display-6">V</span>
                </h3>
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
                            <input type="email" class="form-control" id="email" name="email" placeholder="Wpisz email">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="pswd" name="pswd" placeholder="Wpisz hasło">
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
                            <input type="name" class="form-control" id="name" name="name" placeholder="Wpisz swoje imie">
                            <label for="name">Imie</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Wpisz email">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="pswd" name="pswd" placeholder="Wpisz hasło">
                            <label for="pswd">Hasło</label>
                        </div>                        
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Wpisz numer telefonu">
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

<!-- MODAL OCENY -->
    <div class="modal fade" id="ocenaModal" tabindex="-1" aria-labelledby="ocenaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ocenaModalLabel">Ocen danie</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- FORMULARZ OCEN -->
                <form action="ocen.php" method="POST">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <select name="danie" id="danie">
                                <?php
                                    $z1 = "SELECT nazwaPotrawy FROM menu;";
                                    $resoult = mysqli_query($conn,$z1);
                                    while($wiersz = mysqli_fetch_row($resoult)){
                                        echo "<option>".$wiersz[0]."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="ocena" name="ocena" placeholder="Podaj liczbe gwiazdek" min="0" max="5">
                            <label for="ocena">Ocena</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="recenzja" name="recenzja" placeholder="Opis">
                            <label for="recenzja">Recenzja</label>
                        </div>                     

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Dodaj ocene</button>
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
    var modal = new bootstrap.Modal(document.getElementById('loginModal'));
    modal.show();

    var toastEl = document.getElementById('loginToastERR');
    var toast = new bootstrap.Toast(toastEl, {
        delay: 3000
    });
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