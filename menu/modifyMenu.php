<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php'; 
require_once __DIR__ . '/../adminCheck.php';
requireAdmin($conn);
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
    <title>KresowaJeden — Administracja</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/style.css">   
</head>    
<body>
    <?php include ROOT . '/navbar.php'; ?>

    <main>
        <div class="container py-5" style="padding-top: calc(var(--kj-navbar-h) + 2rem) !important;">

            <!-- NAGŁÓWEK -->
            <div class="page-header mb-4 d-flex justify-content-between align-items-end">
                <div>
                    <h2 class="page-title"><i class="bi bi-pencil-square me-3"></i>Modyfikuj menu</h2>
                    <p class="page-subtitle mb-0">Zarządzaj listą dostępnych dań</p>
                </div>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newMealModal">
                    <i class="bi bi-plus-lg me-1"></i>Nowe danie
                </button>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 caption-top">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nazwa</th>
                                <th scope="col">Opis</th>
                                <th scope="col">Cena</th>
                                <th scope="col">Dostępne</th>
                                <th scope="col" style="width:1%">Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "SELECT * FROM menu;";
                            $result = mysqli_query($conn, $sql);
                            while($row = $result->fetch_assoc()){
                                $dostepne = $row['dostepne'] == 1;
                                echo '<tr>';
                                echo "<th scope='row' class='text-muted'>{$row['id']}</th>";
                                echo "<td class='fw-500'>".htmlspecialchars($row['nazwaPotrawy'])."</td>";
                                echo "<td class='text-muted'>".htmlspecialchars($row['opis'] ?: "Brak opisu", ENT_QUOTES, 'UTF-8')."</td>";
                                echo "<td>{$row['cena']} zł</td>";
                                $badge = $dostepne
                                    ? "<span class='badge' style='background:var(--kj-green-light);color:var(--kj-green-text);'>tak</span>"
                                    : "<span class='badge' style='background:var(--kj-danger-light);color:var(--kj-danger-text);'>nie</span>";
                                echo "<td>{$badge}</td>";
                                echo "<td style='width:1%'>
                                        <form action='".DELETEMEAL."' method='POST'>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <button type='submit' class='btn btn-outline-danger btn-sm'>
                                                <i class='bi bi-trash'></i>
                                            </button>
                                        </form>
                                    </td>";    
                                echo '</tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

<!-- MODAL NOWEJ POTRAWY -->
    <div class="modal fade" id="newMealModal" tabindex="-1" aria-labelledby="newMealModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="newMealModalLabel"><i class="bi bi-plus-circle me-2"></i>Nowe danie</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?=NEWMEAL?>" method="POST">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="name" name="name" placeholder=" ">
                            <label for="name">Nazwa</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="desc" name="desc" placeholder=" ">
                            <label for="desc">Opis</label>
                        </div>                                             
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="price" name="price" placeholder=" ">
                            <label for="price">Cena (zł)</label>
                        </div>                        
                        <div class="form-check mb-3">
                            <input type="checkbox" name="available" id="available" class="form-check-input" checked>
                            <label for="available" class="form-check-label">Danie dostępne</label>
                        </div>                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Dodaj danie</button>
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