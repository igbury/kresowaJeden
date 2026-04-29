<?php
session_start();

    $id = (int) $_POST['id'];
    $nazwa = $_POST['nazwa'];
    $redirect = $_POST['redirect'];
    $action = $_POST['action'];
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>KresowaJeden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light d-flex justify-content-center align-items-center vh-100">
    <div class="card bg-secondary text-light p-4 text-center">
        <h5>Czy na pewno chcesz usunąć <strong><?= htmlspecialchars($nazwa) ?></strong>?</h5>
        <div class="d-flex gap-2 justify-content-center mt-3">

            <form action="<?= htmlspecialchars($action) ?>" method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" class="btn btn-danger">Usuń</button>
            </form>
            <a href="<?= htmlspecialchars($redirect) ?>" class="btn btn-secondary">Anuluj</a>

        </div>
    </div>
</body>
</html>