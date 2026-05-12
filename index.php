<?php
session_start();
require_once(__DIR__ . "/db.php");
require_once __DIR__ . '/paths.php';
$error = $_SESSION["error"] ?? null;
$succ = $_SESSION["succ"] ?? null;
$error_modal = $_SESSION["error_modal"] ?? "loginModal";


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
    <?php include ROOT . '/navbar.php'; ?>
    <!-- MAIN -->
    <main class="bg-dark">
        <div class="container-fluid text-light py-5 mx-0 my-5 d-flex align-items-center">
            <div class="container bg- mx-5">
                <h2 class="m-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, eius.</h2>
                <a href="<?=VIEWMENU?>" class="btn btn-outline-danger mx-5 my-3">Zobacz Menu</a>
                <a href="<?=BOOK?>" class="btn btn-outline-light">Zarezerwuj Stolik</a>
                <a href="<?=RATE?>" class="btn btn-outline-danger mx-5 my-3" data-bs-toggle="modal" data-bs-target="#ocenaModal">Ocen danie</a>
                <hr class="my-5">
                <div class="row text-center border border-secondary">
                    <div class="col border border-secondary p-3">
                        <h1 class="text-warning fw-bold">2</h1>
                        <p class="text-uppercase small text-light mb-0">lata działalności</p>
                    </div>
                    <div class="col border border-secondary p-3">
                        <h1 class="text-warning fw-bold">
                            <?php
                                $sql = "SELECT COUNT(id) FROM menu;";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_row($result);
                                echo $row[0];
                            ?>
                        </h1>
                        <p class="text-uppercase small text-light mb-0">dań w menu</p>
                    </div>
                    <div class="col border border-secondary p-3">
                        <h1 class="text-warning fw-bold">
                            <?php
                                $sql = "SELECT AVG(ocena) FROM oceny;";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_row($result);
                                echo round($row[0], 1);
                            ?>                            
                        </h1>
                        <p class="text-uppercase small text-light mb-0">ocen gości</p>
                    </div>
                </div>
            </div>
            <div id="mainImage" class="container mx-5">
                <img src="./img/kotlet.png" alt="kotlet">
            </div>
        </div>

        <!-- Dania dnia 
        <div class="fixed-bottom w-100 bg-dark bg-opacity-75 py-3 border border-light">
            <div class="container text-center">
                <h3 class="text-danger d-flex align-items-center justify-content-center gap-3">
                    <span class="display-6">V</span>
                    <span>Dania dnia</span> 
                    <span class="display-6">V</span>
                </h3>
            </div>
        </div>-->
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
                <form action="<?= LOGIN ?>" method="POST">
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


<!-- MODAL REJESTRACJI -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="registerModalLabel">Zarejestruj się</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>


                <!-- FORMULARZ REJESTRACJI -->
                <form action="<?=REGISTER?>" method="POST">
                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder=" ">
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

<!-- MODAL OCENY -->
    <div class="modal fade" id="ocenaModal" tabindex="-1" aria-labelledby="ocenaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ocenaModalLabel">Ocen danie</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- FORMULARZ OCEN -->
                <form action="<?=RATE?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="danie">
                                <p>Wybierz danie.</p>
                                <select class="form-select" name="danie" id="danie">
                                    <?php
                                        $z1 = "SELECT id,nazwaPotrawy FROM menu;";
                                        $result = mysqli_query($conn,$z1);
                                        while($row = mysqli_fetch_assoc($result)){
                                            echo "<option value='{$row['id']}'>{$row['nazwaPotrawy']}</option>";
                                        }
                                    ?>
                                </select>
                            </label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" required class="form-control" id="ocena" name="ocena" placeholder=" " min="1" max="5">
                            <label for="ocena">Ocena (1-5)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="recenzja" name="recenzja" placeholder=" ">
                            <label for="recenzja">Komentarz</label>
                        </div>                     

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Dodaj ocene</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
    
    <?php include ROOT . '/toast.php'; ?>         
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


<?php if ($error): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = new bootstrap.Modal(document.getElementById('<?= $error_modal ?>'));
    modal.show();

    var toastEl = document.getElementById('toastERR');
    var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
});
</script>
<?php endif; ?>

<?php if ($succ): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var toastEl = document.getElementById('toastSUCC');
    var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
});
</script>
<?php endif; ?>
</body>
</html>



