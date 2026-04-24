<!--<?php
session_start();

$error = null;
$loginSuccess = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if($_POST["action"] === "login"){
    if (!empty($_POST["email"]) && !empty($_POST["pswd"])) {
        $conn = mysqli_connect("localhost", "root", "y", "kresowaJeden");

        if (!$conn) {
            $error = "Błąd połączenia z bazą danych.";
        } else {
            $email    = mysqli_real_escape_string($conn, $_POST["email"]);
            $password = $_POST["pswd"];

            $sql      = "SELECT email, haslo FROM klienci WHERE email = '$email'";
            $result   = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row['haslo'])) {
                    $_SESSION['user'] = $email;
                    header("Location: test.html");
                    exit;
                } else {
                    $error = "Niepoprawne hasło lub login!";
                }
            } else {
                $error = "Niepoprawne hasło lub login!";
            }

            mysqli_close($conn);
        }
    } else {
        $error = "Musisz wpisać swoje dane!";
    }
}else if($_POST["action"]==="register"){
        if (!empty($_POST["name"])&&!empty($_POST["email"])&&!empty($_POST["pswd"]) && !empty($_POST["phone"])) {
            $conn = mysqli_connect("localhost", "root", "y", "kresowaJeden");
            $name = mysqli_real_escape_string($conn, $_POST["name"]);
            $email = mysqli_real_escape_string($conn, $_POST["email"]);
            $password = mysqli_real_escape_string($conn, password_hash($_POST["pswd"], PASSWORD_DEFAULT));
            $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
            $sql = "SELECT email FROM klienci WHERE email = '$email'";
            $validate = mysqli_query($conn, $sql);
            if ($validate && mysqli_num_rows($validate) > 0) {
                echo "<p>Istnieje już użytkownik o tym loginie!</p>";
            } else {
                $newUser = "INSERT INTO klienci VALUES(null, '$name', '$password','$email', '$phone')";
                $addUser = mysqli_query($conn, $newUser);
                echo "<p>Zostałeś zarejestrowany! Kliknij <a href='login.php'>tutaj</a>, aby się zalogować.";
            }
        } else {
            echo "<p>Musisz wpisać swoje dane!.</p>";
        }
    }
}

?>!-->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KresowaJeden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-dark">

    <!-- NAVBAR -->
    <header>
        <nav class="navbar navbar-expand-sm border border-secondary bg-dark navbar-dark fixed-top">
            <div class="container-fluid">
                <h3 class="navbar-text">KresowaJeden</h3>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item border"><a href="#" class="nav-link active">Lorem.</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Lorem.</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Lorem.</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Lorem.</a></li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal">Login.</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- MAIN -->
    <main class="bg-dark">
        <div class="container-fluid text-light py-5 mx-0 my-5 d-flex align-items-center">
            <div class="container bg- mx-5">
                <h2 class="m-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, eius.</h2>
                <button class="btn btn-outline-danger mx-5 my-3 ">Zobacz Menu</button>
                <button class="btn btn-outline-light">Zarezerwuj Stolik</button>
                <hr class="my-5">
                <div class="row text-center border border-secondary">
                    <div class="col border border-secondary p-3">
                        <h1 class="text-warning fw-bold">2</h1>
                        <p class="text-uppercase small text-light mb-0">lat działalności</p>
                    </div>
                    <div class="col border border-secondary p-3">
                        <h1 class="text-warning fw-bold">14</h1>
                        <p class="text-uppercase small text-light mb-0">dań w menu</p>
                    </div>
                    <div class="col border border-secondary p-3">
                        <h1 class="text-warning fw-bold">5.0</h1>
                        <p class="text-uppercase small text-light mb-0">ocen gości</p>
                    </div>
                </div>
            </div>
            <div id="mainImage" class="container mx-5">
                <img src="./img/kotlet.png" alt="kotlet">
            </div>
        </div>

        <!-- Dania dnia -->
        <div class="fixed-bottom w-100 bg-dark bg-opacity-75 py-3 border border-light">
            <div class="container text-center">
                <h3 class="text-danger d-flex align-items-center justify-content-center gap-3">
                    <span class="display-6">V</span>
                    <span>Dania dnia</span>
                    <span class="display-6">V</span>
                </h3>
            </div>
        </div>
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
                <form action="" method="POST">
                    <input type="hidden" name="action" value="login">
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Wpisz email">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="pswd" name="pswd" placeholder="Wpisz hasło">
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
                <form action="" method="POST">
                    <input type="hidden" name="action" value="register">
                    <div class="modal-body">

                        <div class="form-floating mb-3">
                            <input type="name" class="form-control" id="name" name="name" placeholder="Wpisz swoje imie">
                            <label for="name">Imie</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Wpisz email">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="pswd" name="pswd" placeholder="Wpisz hasło">
                            <label for="pswd">Hasło</label>
                        </div>                        
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Wpisz numer telefonu">
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
                <!-- TOAST -->
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
                    <?php if ($error): ?>
                    <div id="loginToast" class="toast align-items-center text-bg-danger border-0" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                <?= htmlspecialchars($error) ?>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                    <?php endif; ?>
            </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


<?php if ($error): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = new bootstrap.Modal(document.getElementById('loginModal'));
    modal.show();

    var toastEl = document.getElementById('loginToast');
    var toast = new bootstrap.Toast(toastEl, {
        delay: 3000
    });
    toast.show();
});
</script>
<?php endif; ?>

</body>
</html>