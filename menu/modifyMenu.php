<?php
session_start();
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php'; 
$error = $_SESSION["error"] ?? null;
$succ = $_SESSION["succ"] ?? null;
$error_modal = $_SESSION["error_modal"] ?? "loginModal";
if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
    header("Location: /../index.php");
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
                <h3 class="navbar-text text-white mx-2 my-1">KresowaJeden</h3>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-3 my-1">
                        <a href="/index.php" class="btn btn-outline-success text-white">Home</a>
                    </li>
                    <li class="nav-item mx-3 my-1">
                        <a href="<?=VIEWMENU?>" class="btn btn-outline-success text-white">Menu</a>
                    </li>
                    <li class="nav-item mx-3 my-1">
                        <div class="dropend">
                            <a class="btn btn-outline-danger text-white dropdown-toggle" role="button" data-bs-theme="dark" data-bs-toggle="dropdown" aria-expanded="false">
                                Administracja
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="modifyMenu.php">Modyfikuj menu</a></li>
                                <li><a class="dropdown-item disabled" href="#">Zarządzaj pracownikami</a></li>
                                <li><a class="dropdown-item disabled" href="#">Zarządzaj restauracją</a></li>
                            </ul>
                        </div>
                    </li>    
                </ul>
                <ul class="navbar-nav ms-auto">                           
                    <li class="nav-item mx-2 my-1">
                        <a href="<?=LOGOUT?>" class="btn text-white btn-outline-danger">Wyloguj</a>
                    </li>
                </ul>            
            </div>
            
        </nav>
    </header>

    <!-- MAIN -->
    <main class="bg-dark">
        <div class="container-fluid text-light py-5 mx-0 my-5 d-flex align-items-center">
            <div class="container mx-5">
                <table class="table table-sm table-dark table-bordered  table-striped table-hover caption-top">
                    <caption class="text-secondary">
                        Lista obecnych dań w menu.
                        <a class="btn btn-outline-success text-white btn-sm" data-bs-toggle="modal" data-bs-target="#newMealModal">+</a>
                    </caption>
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Cena</th>
                        <th scope="col">Dostępne</th>
                        <th scope="col" style="width:1%">Akcje</th>
                    </thead>
                    <tbody>
                    <?php
                        $sql = "SELECT * FROM menu;";
                        $result = mysqli_query($conn, $sql);
                        while($row = $result ->fetch_assoc()){
                            echo '<tr>';
                            echo "<th scope='row'>{$row['id']}</th>";
                            echo "<td>{$row['nazwaPotrawy']}</td>";
                            echo "<td>{$row['opis']}</td>";
                            echo "<td>{$row['cena']}zł</td>";
                            echo "<td>" . ($row['dostepne'] == 1 ? 'tak' : 'nie') . "</td>";
                            echo "<td style='width:1%'>
                                    <form action='".DELETEMEAL."' method='POST'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' class='btn text-light btn-outline-danger btn-sm'>Usuń</button>
                                    </form>
                                </td>";    
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
<!-- MODAL NOWEJ POTRAWY -->
    <div class="modal fade" id="newMealModal" tabindex="-1" aria-labelledby="newMealModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="newMealModalLabel">Nowe danie do menu</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- FORMULARZ NOWEJ POTRAWY -->
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
                            <label for="price">Cena</label>
                        </div>                        
                        <div class="form-check mb-3">
                            <input type="checkbox" name="available" id="available" class="form-check-input" checked>
                            <label for="available" class="form-check-label">Czy danie jest dostępne?</label>
                        </div>                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Dodaj nowe danie</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>