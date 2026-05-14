<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';  
$error = $_SESSION["error"] ?? null;
$succ = $_SESSION["succ"] ?? null;
$error_modal = $_SESSION["error_modal"] ?? "loginModal";

if(!isset($_SESSION["user"])){
    $_SESSION["error"] = "Musisz być zalogowany, aby zobaczyć koszyk!";
    header("Location: ".INDEX);
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
    <title>KresowaJeden — Koszyk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/style.css">  
</head>    
<body>
    <?php include ROOT . '/navbar.php'; ?>

    <main>
        <div class="container py-5" style="padding-top: calc(var(--kj-navbar-h) + 2rem) !important; max-width: 700px;">
            <!-- NAGŁÓWEK -->
            <div class="page-header mb-4">
                <h2 class="page-title"><i class="bi bi-cart3 me-3"></i>Twój koszyk</h2>
                <p class="page-subtitle">Przejrzyj zamówienie przed płatnością</p>
            </div>

            <?php if(!empty($_SESSION['cart'])): ?>
            <div class="card">
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Potrawa</th>
                                <th>Cena</th>
                                <th>Ilość</th>
                                <th style="width:1%">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sumaCen = 0;
                            foreach($_SESSION['cart'] as $mealId=>$amount){
                                $id = (int)$mealId;
                                $ilosc = (int)$amount;
                                $stmt = mysqli_prepare($conn, "SELECT id,nazwaPotrawy,cena FROM menu WHERE id=?");
                                mysqli_stmt_bind_param($stmt, "i", $id);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                $row = mysqli_fetch_assoc($result);                                   
                                if($row){
                                    $sumaCen += number_format($row['cena']*$amount);
                                    echo '<tr>';
                                    echo "<td class='fw-500'>{$row['nazwaPotrawy']}</td>";
                                    echo "<td>{$row['cena']} zł</td>";
                                    echo "<td><span class='badge' style='background:var(--kj-green-light);color:var(--kj-green-text);font-size:.85rem;font-weight:600;'>{$amount}</span></td>";
                                    echo "<td>
                                            <div class='d-flex gap-1'>
                                                <form action='".ADDTOCART."' method='POST'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <input type='hidden' name='redirect' value='cart'>
                                                    <button type='submit' class='btn btn-outline-success btn-sm' title='Dodaj'>
                                                        <i class='bi bi-plus'></i>
                                                    </button>
                                                </form>                                   
                                                <form action='".REMOVEFROMCART."' method='POST'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <input type='hidden' name='akcja' value='zmniejsz'>
                                                    <button type='submit' class='btn btn-outline-warning btn-sm' title='Zmniejsz'><i class='bi bi-dash'></i></button>
                                                </form>
                                                <form action='".REMOVEFROMCART."' method='POST'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <input type='hidden' name='akcja' value='usun'>
                                                    <button type='submit' class='btn btn-outline-danger btn-sm' title='Usuń'><i class='bi bi-trash'></i></button>
                                                </form>
                                            </div>
                                        </td>";
                                    echo '</tr>';
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SUMA I PŁATNOŚĆ -->
            <div class="cart-summary mt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="text-muted">Suma do zapłaty:</span>
                    <span class="cart-total"><?=$sumaCen?> zł</span>
                </div>
                <form action="<?=PAYMENT?>" method="post">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-credit-card me-2"></i>Przejdź do płatności
                    </button>
                </form>
            </div>

            <?php else: ?>
            <!-- PUSTY KOSZYK -->
            <div class="empty-state">
                <div class="empty-state-icon"><i class="bi bi-cart-x"></i></div>
                <h5>Koszyk jest pusty</h5>
                <p>Dodaj dania z naszego menu, aby złożyć zamówienie.</p>
                <a href="<?=VIEWMENU?>" class="btn btn-outline-success mt-2">
                    <i class="bi bi-book me-2"></i>Przejdź do menu
                </a>
            </div>
            <?php endif; ?>
        </div>
    </main>

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