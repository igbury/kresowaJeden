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
$result = mysqli_query($conn, "SELECT COUNT(id) FROM menu;");
$row = mysqli_fetch_row($result);
$liczbaDan = $row[0];

$result = mysqli_query($conn, "SELECT AVG(ocena) FROM oceny;");
$row = mysqli_fetch_row($result);
$ocena = round($row[0], 1);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KresowaJeden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">     
</head>    
<body>
    <?php include ROOT . '/navbar.php'; ?>
    <main>
        <!-- HERO SECTION -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center g-5">
                    <!-- LEWA KOLUMNA: tekst -->
                    <div class="col-lg-6">
                        <span class="hero-badge">
                            <i class="bi bi-geo-alt-fill me-1"></i>Sosnowiec, ul. Kresowa 1
                        </span>
                        <h1 class="hero-title">
                            Smaki z krańców<br>
                            <span class="hero-title-accent">dawnej Polski</span>
                        </h1>
                        <p class="hero-desc">
                            Tradycyjne potrawy kresowe w nowoczesnym wydaniu — przygotowywane z lokalnych składników, serwowane z&nbsp;sercem.
                        </p>
                        <div class="d-flex flex-wrap gap-3 mt-4">
                            <a href="<?=VIEWMENU?>" class="btn btn-hero-primary">
                                <i class="bi bi-book me-2"></i>Zobacz Menu
                            </a>
                            <a href="#" class="btn btn-hero-secondary" data-bs-toggle="modal" data-bs-target="#ocenaModal">
                                <i class="bi bi-star me-2"></i>Oceń danie
                            </a>
                        </div>

                        <!-- STATYSTYKI -->
                        <div class="row text-center border border-secondary my-3">
                            <div class="col border border-secondary p-3">
                                <h1 class="text-warning fw-bold">2</h1>
                                <p class="text-uppercase small text-light mb-0">lata działalności</p>
                            </div>
                            <div class="col border border-secondary p-3">
                                <h1 class="text-warning fw-bold">
                                    <?=$liczbaDan?>
                                </h1>
                                <p class="text-uppercase small text-light mb-0">dań w menu</p>
                            </div>
                            <div class="col border border-secondary p-3">
                                <h1 class="text-warning fw-bold">
                                    <?=$ocena?>                            
                                </h1>
                                <p class="text-uppercase small text-light mb-0">ocen gości</p>
                            </div>
                        </div>
                        
                    </div>

                    <!-- PRAWA KOLUMNA: obraz -->
                    <div class="col-lg-6 text-center" id="mainImage">
                        <div class="hero-image-wrap">
                            <img src="./img/kotlet.png" alt="Danie kresowe" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

<!-- MODAL OCENY -->
    <div class="modal fade" id="ocenaModal" tabindex="-1" aria-labelledby="ocenaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ocenaModalLabel"><i class="bi bi-star-fill me-2 text-warning"></i>Oceń danie</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?=RATE?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Wybierz danie</label>
                            <select class="form-select" name="danie" id="danie">
                                <?php
                                    $z1 = "SELECT id,nazwaPotrawy FROM menu;";
                                    $result = mysqli_query($conn,$z1);
                                    while($row = mysqli_fetch_assoc($result)){
                                        echo "<option value='{$row['id']}'>".htmlspecialchars($row['nazwaPotrawy'])."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" required class="form-control" id="ocena" name="ocena" placeholder=" " min="1" max="5">
                            <label for="ocena">Ocena (1–5)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="recenzja" name="recenzja" placeholder=" ">
                            <label for="recenzja">Komentarz (opcjonalnie)</label>
                        </div>                     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Dodaj ocenę</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include LOGINMODALS; ?> 
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
<?php if(isset($_SESSION['open_modal'])): ?>
<script>
    const modal = new bootstrap.Modal(document.getElementById('<?= htmlspecialchars($_SESSION['open_modal'] ?? '', ENT_QUOTES) ?>'));
    modal.show();
</script>
<?php 
    unset($_SESSION['open_modal']); 
endif; ?>
</body>
</html>