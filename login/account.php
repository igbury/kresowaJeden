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
unset($_SESSION["error"], $_SESSION["succ"]);

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
                                    <a href="'.CONTACT.'" class="btn btn-outline-success">Kontakt</a>
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
            <div class="card bg-dark border border-success mb-4">
                <div class="card-header border-success d-flex justify-content-between text-light align-items-center">
                    <span><i class="bi bi-info-circle me-2"></i>Twoje dane</span>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="bi bi-pencil-fill me-2"></i>Edytuj
                    </button>
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
            <!--ZMIANA HASLA-->
            <div class="card bg-dark border border-warning mb-4">
                <div class="card-header border-warning text-light">
                    <i class="bi bi-lock-fill text-warning me-2"></i>Zmiana hasła
                </div>
                <div class="card-body">
                    <form action="<?=CHANGEPASSWORD?>" method="post">
                        <div class="form-floating mb-3">
                            <input type="password" placeholder="" name="oldPass" id="oldPass" class="form-control bg-dark text-light border-secondary">
                            <label for="oldPass" class="text-secondary">Obecne hasło</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" placeholder="" name="newPass" id="newPass" class="form-control bg-dark text-light border-secondary">
                            <label for="newPass" class="text-secondary">Nowe hasło</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" placeholder="" name="newPass2" id="newPass2" class="form-control bg-dark text-light border-secondary">
                            <label for="newPass2" class="text-secondary">Powtórz nowe hasło</label>
                        </div>
                        <button type="submit" class="btn btn-outline-warning w-100">Zmień hasło</button>
                    </form>
                </div>
            </div>
            <div class="card bg-dark border border-danger mb-4">
                <div class="card-header border-danger text-light">
                    <i class="bi bi-exclamation-diamond-fill me-2 text-danger"></i>Usuń konto
                </div>
                <div class="card-body">
                    <p class="text-secondary small mb-3">Usunięcie konta jest nieodwracalne. Wszystkie Twoje dane zostaną trawle usunięte.</p>
                    <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash-fill me-2"></i>Usuń konto
                    </button>
                </div>
            </div>            
        </div>
    </main>




<!-- MODAL EDYCJI DANYCH -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content bg-dark text-light border border-secondary">
                <div class="modal-header border-secondary">
                    <h4 class="modal-title">Edytuj swoje dane</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <!-- FORMULARZ OCEN -->
                <form action="<?=UPDATEACCOUNT?>" method="POST">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" name="imie" placeholder="" value="<?=htmlspecialchars($klient['imie'])?>" id="imie" class="form-control bg-dark text-light border-secondary">
                            <label for="imie" class="text-secondary">Imię</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" placeholder="" value="<?=htmlspecialchars($klient['email'])?>" id="email" class="form-control bg-dark text-light border-secondary">
                            <label for="email" class="text-secondary">Email</label>
                        </div>                                        
                        <div class="form-floating mb-3">
                            <input type="tel" name="nr_telefonu" placeholder="" value="<?=htmlspecialchars($klient['nr_telefonu'])?>" id="nr_telefonu" class="form-control bg-dark text-light border-secondary">
                            <label for="nr_telefonu" class="text-secondary">Numer telefonu</label>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="submit" class="btn btn-success">Zapisz</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 

<!-- MODAL POTWIERDZENIA USUNIECIA KONTA -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light border border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-diamond-fill me-2 text-danger"></i>Potwierdź usunięcia konta
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <!-- FORMULARZ OCEN -->
                <form action="<?=REMOVEUSER?>" method="POST">
                    <div class="modal-body">            
                        <div class="form-floating mb-3">
                            <input type="password" name="pass" placeholder="" id="pass" class="form-control bg-dark text-light border-secondary">
                            <label for="pass" class="text-secondary">Obecne hasło</label>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="confirm" id="confirm" class="form-check-input">
                            <label for="confirm" class="form-check-label">Zapoznano się z poniższą wiadomością.</label>
                            <p class="text-secondary small">Usunięcie konta wiąże się z trwałą utratą dostępu do niego, oraz całkowitego usunięcia go z bazy danych.</p>                              
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="submit" id="deleteBtn" class="btn btn-danger" disabled>
                            Usuń konto (3)
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    </div>
                </form>
            </div>
        </div>
    </div>












    <!-- TOAST ERROR -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <?php if ($error): ?>
        <div id="toastERR" class="toast align-items-center text-bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body"><?= htmlspecialchars($error) ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- TOAST SUCCESS -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <?php if ($succ): ?>
        <div id="toastSUCC" class="toast align-items-center text-bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body"><?= htmlspecialchars($succ) ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($error): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        new bootstrap.Toast(document.getElementById('toastERR'), { delay: 3000 }).show();
    });
    </script>
    <?php endif; ?>
    <?php if ($succ): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        new bootstrap.Toast(document.getElementById('toastSUCC'), { delay: 3000 }).show();
    });
    </script>
    <?php endif; ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('deleteModal');
        
        modal.addEventListener('show.bs.modal', function () {
            const btn = document.getElementById('deleteBtn');
            let seconds = 5;
            
            btn.disabled = true;
            btn.textContent = `Usuń konto (${seconds})`;
            
            const interval = setInterval(function () {
                seconds--;
                if (seconds <= 0) {
                    clearInterval(interval);
                    btn.disabled = false;
                    btn.textContent = 'Usuń konto';
                } else {
                    btn.textContent = `Usuń konto (${seconds})`;
                }
            }, 1000);
        });
    });        
    </script>
</body>
</html>