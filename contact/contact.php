<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';

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
    <link rel="stylesheet" href="/style.css">    
</head>
<body>
    <?php include ROOT . '/navbar.php'; ?>

    <main>
        <div class="container py-5" style="padding-top: calc(var(--kj-navbar-h) + 2rem) !important; max-width: 720px;">

            <!-- NAGŁÓWEK -->
            <div class="page-header mb-5">
                <h2 class="page-title"><i class="bi bi-telephone-fill me-3"></i>Kontakt</h2>
                <p class="page-subtitle">Skontaktuj się z nami lub wyślij wiadomość</p>
            </div>

            <!-- DANE KONTAKTOWE -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2 text-success"></i>Dane kontaktowe
                </div>
                <div class="card-body">
                    <div class="contact-row">
                        <div class="contact-icon text-success">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Telefon</div>
                            <div class="fw-500">+48 666 636 887</div>
                        </div>
                    </div>
                    <hr>
                    <div class="contact-row">
                        <div class="contact-icon text-success">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Adres</div>
                            <div class="fw-500">ul. Kresowa 1, 41-200 Sosnowiec</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- GODZINY OTWARCIA -->
            <div class="card border-warning mb-4">
                <div class="card-header">
                    <i class="bi bi-clock-fill me-2 text-warning"></i>Godziny otwarcia
                </div>
                <div class="card-body">
                    <div class="hours-row">
                        <span class="text-muted">Poniedziałek</span>
                        <span class="badge" style="background:var(--kj-danger-light);color:var(--kj-danger-text);">Zamknięte</span>
                    </div>
                    <div class="hours-row mt-2">
                        <span class="text-muted">Wtorek – Niedziela</span>
                        <span class="badge" style="background:var(--kj-green-light);color:var(--kj-green-text);font-weight:600;">12:00 – 17:30</span>
                    </div>
                </div>
            </div>

            <!-- ALERTY -->
            <?php if($succ): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?=htmlspecialchars($succ)?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i><?=htmlspecialchars($error)?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- FORMULARZ -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-chat-dots-fill me-2"></i>Wyślij wiadomość
                </div>
                <div class="card-body">
                    <form action="<?=SENDMESSAGE?>" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="temat" id="temat" placeholder="" class="form-control">
                            <label for="temat">Temat</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="wiadomosc" id="wiadomosc" placeholder="" class="form-control" style="height: 140px;"></textarea>
                            <label for="wiadomosc">Wiadomość</label>
                        </div>
                    <?php if(isset($_SESSION['user'])):?>
                        <button type="submit" class="btn btn-success w-100">
                    <?php else: ?>
                        <button type="submit" class="btn btn-success w-100 disabled">
                    <?php endif;?>                                
                            <i class="bi bi-send-fill me-2"></i>Wyślij
                        </button>
                        <?php if(!isset($_SESSION['user'])): ?>
                            <p class="text-center small text-muted mt-2">Zaloguj się, aby wysłać wiadomość.</p>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

        </div>
    </main>
    <?php include LOGINMODALS; ?> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>