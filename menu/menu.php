<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';
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
    <title>KresowaJeden — Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/style.css">  
</head>
<body>
<?php include ROOT . '/navbar.php'; ?>

    <?php
        $z = "SELECT menu.nazwaPotrawy, menu.opis, menu.cena, menu.id FROM menu where dostepne=1";
        $r = mysqli_query($conn, $z);
    ?>

    <main>
        <div class="container py-5" style="padding-top: calc(var(--kj-navbar-h) + 2rem) !important;">
            <!-- NAGŁÓWEK -->
            <div class="page-header mb-5">
                <h2 class="page-title"><i class="bi bi-book me-3"></i>Nasze Menu</h2>
                <p class="page-subtitle">Wybierz danie i&nbsp;dodaj je do koszyka</p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php while($wiersz = mysqli_fetch_row($r)): ?>
                <div class="col">
                    <div class="card h-100 menu-card">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="menu-card-icon">
                                <i class="bi bi-egg-fried"></i>
                            </div>
                            <h5 class="card-title mt-3"><?php echo htmlspecialchars($wiersz[0]); ?></h5>
                            <p class="card-text flex-grow-1"><?php echo htmlspecialchars($wiersz[1]); ?></p>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <span class="menu-price"><?php echo htmlspecialchars($wiersz[2]); ?> zł</span>
                                <form action='<?=ADDTOCART?>' method='POST'>
                                    <input type='hidden' name='id' value='<?php echo htmlspecialchars($wiersz[3]); ?>'>
                                    <button type='submit' class='btn btn-outline-success btn-sm'>
                                        <i class='bi bi-cart-plus me-1'></i>Dodaj
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
    
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
</body>
</html>