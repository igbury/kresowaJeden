<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';

if(!isset($_SESSION['user'])){
    header("Location:".INDEX);
    exit();
}
$error = $_SESSION["error"] ?? null;
$succ = $_SESSION["succ"] ?? null;
unset($_SESSION["error"], $_SESSION["succ"]);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KresowaJeden | Kontakt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-dark">
    <!-- NAVBAR -->
    <?php include ROOT . '/navbar.php'; ?>

    <!-- MAIN -->
    <main class="bg-dark text-light" style="padding-top: 80px;">
        <div class="container py-4" style="max-width: 700px;">
            <!-- NAGLOWEk -->
            <h4 class="mb-1"><i class="bi bi-telephone-fill me-3"></i>Kontakt</h4>
            <p class="text-secondary mb-2">Skontaktuj się z nami lub napisz wiadomość</p>
            <hr class="border-secondary mb-4">
            <!-- DANE KONTAKTOWE -->
            <div class="card bg-dark border border-success mb-4">
                <div class="card-header border-success text-light">
                    <i class="bi bi-info-circle me-2"></i>Dane kontaktowe
                </div>
                <div class="card-body">
                    <div class="row mb-3 align-items-center">
                        <div class="col-1 text-success fs-5">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div class="col">
                            <div class="text-secondary small">Telefon</div>
                            <div class="text-light">+48 666 636 887</div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-1 text-success fs-5">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div class="col">
                            <div class="text-secondary small">Adres</div>
                            <div class="text-light">ul. Kresowa 1, 41-200 Sosnowiec</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GODZINY OTWARCIA -->
            <div class="card bg-dark border border-warning mb-4">
                <div class="card-header border-warning text-light">
                    <i class="bi bi-clock-fill text-warning me-2"></i>Godziny otwarcia
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-5 text-secondary">Poniedziałek</div>
                        <div class="col text-light">Zamknięte</div>
                    </div>
                    <div class="row">
                        <div class="col-5 text-secondary">Wtorek - Niedziela</div>
                        <div class="col text-light">12:00 – 17:30</div>
                    </div>
                </div>
            </div>
            <?php if($succ): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?=htmlspecialchars($succ)?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?=htmlspecialchars($error)?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <!-- FORMULARAZ DO WIADOMOSCI -->
            <div class="card bg-dark border border-secondary mb-4">
                <div class="card-header border-secondary text-light">
                    <i class="bi bi-chat-dots-fill me-2"></i>Wyślij wiadomość
                </div>
                <div class="card-body">
                    <form action="<?=SENDMESSAGE?>" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="temat" id="temat" placeholder="" class="form-control bg-dark text-light border-secondary">
                            <label for="temat" class="text-secondary">Temat</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="wiadomosc" id="wiadomosc" placeholder="" class="form-control bg-dark text-light border-secondary" style="height: 140px;"></textarea>
                            <label for="wiadomosc" class="text-secondary">Wiadomość</label>
                        </div>
                        <button type="submit" class="btn btn-outline-success w-100">
                            <i class="bi bi-send-fill me-2"></i>Wyślij
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>