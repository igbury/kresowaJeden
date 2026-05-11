<?php
// =============================================
// STARTOWANIE SESJI I ŁADOWANIE PLIKÓW
// =============================================
session_start();
require_once __DIR__ . '/../db.php';    // połączenie z bazą danych ($conn)
require_once __DIR__ . '/../paths.php'; // stałe z adresami URL (LOGIN, LOGOUT itd.)

// Pobierz komunikaty z sesji (ustawiane przez inne strony)
$blad  = $_SESSION["error"] ?? null; // np. "Złe hasło"
$sukces = $_SESSION["succ"]  ?? null; // np. "Dodano do koszyka"
$modal_bledu = $_SESSION["error_modal"] ?? "cartModal"; // który modal otworzyć przy błędzie

// Usuń komunikaty z sesji żeby nie pokazywały się po odświeżeniu
unset($_SESSION["error_modal"]);
unset($_SESSION["error"]);
unset($_SESSION["succ"]);

// =============================================
// DANE KATEGORII
// =============================================
// Każda kategoria ma: klucz (używany w bazie), ikonę Bootstrap i polską nazwę
$kategorie = [
    'all'       => ['ikona' => 'bi-grid-fill',          'nazwa' => 'Wszystkie'],
    'danie_glowne' => ['ikona' => 'bi-egg-fried',       'nazwa' => 'Dania główne'],
    'zupa'      => ['ikona' => 'bi-cup-hot-fill',        'nazwa' => 'Zupy'],
    'salatka'   => ['ikona' => 'bi-tree-fill',           'nazwa' => 'Sałatki'],
    'dodatek'   => ['ikona' => 'bi-basket-fill',         'nazwa' => 'Dodatki'],
    'dziecięce' => ['ikona' => 'bi-balloon-heart-fill',  'nazwa' => 'Dla najmłodszych'],
];

// =============================================
// DANE UŻYTKOWNIKA Z SESJI
// =============================================
$jest_zalogowany = isset($_SESSION['user']);
$jest_adminem    = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true;
$ilosc_w_koszyku = ($jest_zalogowany && isset($_SESSION['cart']))
                    ? array_sum($_SESSION['cart'])
                    : 0;

// =============================================
// POBIERZ DANIA Z BAZY DANYCH
// =============================================
$zapytanie = "SELECT nazwaPotrawy, opis, cena, id, typ FROM menu";
$wynik     = mysqli_query($conn, $zapytanie);
if (!$wynik) {
    die("Błąd zapytania: " . mysqli_error($conn));
}
// Wczytaj wszystkie wiersze do tablicy żeby nie mieszać PHP z HTML poniżej
$dania = [];
while ($wiersz = mysqli_fetch_row($wynik)) {
    $dania[] = $wiersz;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KresowaJeden - Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-dark">

<!-- =============================================
     NAWIGACJA (GÓRNY PASEK)
============================================= -->
<nav class="navbar navbar-expand-sm border border-secondary bg-dark navbar-dark fixed-top">
    <div class="container-fluid">

        <!-- Nazwa restauracji -->
        <h3 class="navbar-text mx-2 my-1">KresowaJeden</h3>

        <!-- Linki nawigacyjne (lewa strona) -->
        <ul class="navbar-nav ms-auto">
            <li class="nav-item mx-3 my-1">
                <a href="<?= INDEX ?>" class="btn btn-outline-success">Home</a>
            </li>
            <li class="nav-item mx-3 my-1">
                <a href="<?= VIEWMENU ?>" class="btn btn-outline-success active">Menu</a>
            </li>

            <?php if ($jest_adminem): ?>
                <!-- Panel admina z dropdownem -->
                <li class="nav-item mx-3 my-1">
                    <div class="dropend">
                        <a class="btn btn-outline-danger dropdown-toggle"
                           role="button" data-bs-toggle="dropdown">
                            Administracja
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="<?= MODIFYMENU ?>">Modyfikuj menu</a></li>
                            <li><a class="dropdown-item disabled" href="#">Zarządzaj pracownikami</a></li>
                            <li><a class="dropdown-item disabled" href="#">Zarządzaj restauracją</a></li>
                        </ul>
                    </div>
                </li>
            <?php else: ?>
                <!-- Zwykłe linki dla gości -->
                <li class="nav-item mx-3 my-1">
                    <a href="#" class="btn btn-outline-success">Rezerwacja</a>
                </li>
                <li class="nav-item mx-3 my-1">
                    <a href="#" class="btn btn-outline-success">Kontakt</a>
                </li>
            <?php endif; ?>
        </ul>

        <!-- Koszyk i logowanie (prawa strona) -->
        <ul class="navbar-nav ms-auto">
            <?php if ($jest_zalogowany): ?>
                <!-- Zalogowany: koszyk z licznikiem + wyloguj -->
                <li class="nav-item mx-2 my-1">
                    <a href="<?= VIEWCART ?>" class="btn btn-outline-light">
                        <i class="bi bi-cart"></i> <?= $ilosc_w_koszyku ?>
                    </a>
                </li>
                <li class="nav-item mx-2 my-1">
                    <a href="<?= LOGOUT ?>" class="btn btn-outline-danger">Wyloguj</a>
                </li>
            <?php else: ?>
                <!-- Niezalogowany: zablokowany koszyk + przycisk logowania -->
                <li class="nav-item mx-2 my-1">
                    <a href="<?= VIEWCART ?>" class="btn btn-outline-light disabled">
                        <i class="bi bi-cart"></i>
                    </a>
                </li>
                <li class="nav-item mx-2 my-1">
                    <a href="<?= LOGIN ?>" class="btn btn-outline-light"
                       data-bs-toggle="modal" data-bs-target="#loginModal">
                        Login
                    </a>
                </li>
            <?php endif; ?>
        </ul>

    </div>
</nav>

<!-- =============================================
     GŁÓWNA ZAWARTOŚĆ STRONY
============================================= -->
<main>
<div class="container-fluid text-light py-5 mx-0 my-5">

    <!-- KAFELKI KATEGORII -->
    <div class="row justify-content-center mb-2 g-3">
        <?php foreach ($kategorie as $klucz => $kat): ?>
        <div class="col-6 col-sm-4 col-md-2">
            <!-- Kliknięcie wywołuje filterMenu() w JavaScript -->
            <div class="cat-tile text-center p-3 border border-secondary rounded-3 text-secondary bg-dark"
                 style="cursor:pointer; transition: all .2s;"
                 data-cat="<?= $klucz ?>"
                 onclick="filterMenu('<?= $klucz ?>', this)">
                <i class="bi <?= $kat['ikona'] ?>" style="font-size:2rem; display:block; margin-bottom:.4rem;"></i>
                <span style="font-size:.85rem; font-weight:500;"><?= $kat['nazwa'] ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Aktualnie wybrana kategoria (zmieniana przez JS) -->
    <p class="text-secondary text-uppercase" id="cat-label"
       style="font-size:.75rem; letter-spacing:.1em; margin: 1.2rem 0 .5rem 4px;">
        Wszystkie dania
    </p>

    <!-- KARTY DAŃ -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="menu-cards">
        <?php foreach ($dania as $danie): ?>
        <!--
            data-cat musi być identyczny z kluczem w $kategorie
            żeby filtrowanie w JS działało poprawnie
        -->
        <!-- $danie[0]=nazwaPotrawy, [1]=opis, [2]=cena, [3]=id, [4]=typ -->
        <div class="col menu-item" data-cat="<?= htmlspecialchars($danie[4]) ?>">
            <div class="card h-100 bg-dark text-light border-secondary">
                <div class="card-body py-4 my-3">
                    <h5 class="card-title"><?= htmlspecialchars($danie[0]) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($danie[1]) ?></p>
                    <p class="card-text">
                        <strong>Cena: </strong><?= htmlspecialchars($danie[2]) ?> zł
                    </p>
                    <!-- Formularz wysyła id dania do skryptu koszyka -->
                    <form action="<?= ADDTOCART ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $danie[3] ?>">
                        <button type="submit" class="btn text-light btn-outline-secondary btn-sm">
                            Dodaj do koszyka
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>
</main>

<!-- =============================================
     MODAL LOGOWANIA
============================================= -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="loginModalLabel">Zaloguj się</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= LOGIN ?>" method="POST">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="loginEmail" name="email" placeholder=" ">
                        <label for="loginEmail">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="loginPswd" name="pswd" placeholder=" ">
                        <label for="loginPswd">Hasło</label>
                    </div>
                    <!-- Link przełączający na modal rejestracji -->
                    <a href="#" class="d-block text-center m-1 p-1 border rounded-1 border-primary text-decoration-none text-primary"
                       data-bs-toggle="modal" data-bs-target="#registerModal">
                        Zarejestruj się
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Zaloguj</button>
                    <button type="reset"  class="btn btn-danger">Resetuj</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =============================================
     MODAL REJESTRACJI
============================================= -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="registerModalLabel">Zarejestruj się</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= REGISTER ?>" method="POST">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text"     class="form-control" id="regName"  name="name"  placeholder=" ">
                        <label for="regName">Imię</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email"    class="form-control" id="regEmail" name="email" placeholder=" ">
                        <label for="regEmail">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="regPswd"  name="pswd"  placeholder=" ">
                        <label for="regPswd">Hasło</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="tel"      class="form-control" id="regPhone" name="phone" placeholder=" ">
                        <label for="regPhone">Numer telefonu</label>
                    </div>
                    <!-- Link przełączający z powrotem na modal logowania -->
                    <a href="#" class="d-block text-center m-1 p-1 border rounded-1 border-primary text-decoration-none text-primary"
                       data-bs-toggle="modal" data-bs-target="#loginModal">
                        Zaloguj się
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Zarejestruj</button>
                    <button type="reset"  class="btn btn-danger">Resetuj</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =============================================
     POWIADOMIENIA (TOASTY)
============================================= -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">

    <?php if ($blad): ?>
    <!-- Toast błędu (czerwony) -->
    <div id="toastBlad" class="toast align-items-center text-bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body"><?= htmlspecialchars($blad) ?></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($sukces): ?>
    <!-- Toast sukcesu (zielony) -->
    <div id="toastSukces" class="toast align-items-center text-bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body"><?= htmlspecialchars($sukces) ?></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    <?php endif; ?>

</div>

<!-- =============================================
     SKRYPTY JS
============================================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>

// -----------------------------------------------
// SŁOWNIK: klucz kategorii → polska nazwa
// (używane do aktualizacji napisu nad kartami)
// -----------------------------------------------
const nazwyKategorii = {
    all:          'Wszystkie dania',
    danie_glowne: 'Dania główne',
    zupa:         'Zupy',
    salatka:      'Sałatki',
    dodatek:      'Dodatki',
    dziecięce:    'Dla najmłodszych'
};

// -----------------------------------------------
// FILTROWANIE MENU po kliknięciu kafelka
// cat  - klucz kategorii np. 'zupa'
// klik - kliknięty element HTML (kafelek)
// -----------------------------------------------
function filterMenu(cat, klik) {

    // 1. Zresetuj wygląd wszystkich kafelków na szary
    document.querySelectorAll('.cat-tile').forEach(function(kafelek) {
        kafelek.classList.remove('bg-success', 'text-white', 'border-success');
        kafelek.classList.add('text-secondary', 'border-secondary', 'bg-dark');
    });

    // 2. Podświetl kliknięty kafelek na zielono
    klik.classList.remove('text-secondary', 'border-secondary', 'bg-dark');
    klik.classList.add('bg-success', 'text-white', 'border-success');

    // 3. Zaktualizuj napis nad kartami
    document.getElementById('cat-label').textContent = nazwyKategorii[cat] ?? cat;

    // 4. Pokaż lub ukryj karty dań
    document.querySelectorAll('.menu-item').forEach(function(karta) {
        // Pokaż jeśli: wybrano "all" LUB data-cat karty pasuje do kategorii
        var czyPokazac = (cat === 'all' || karta.dataset.cat === cat);
        karta.style.display = czyPokazac ? '' : 'none';
    });
}

// -----------------------------------------------
// PO ZAŁADOWANIU STRONY
// -----------------------------------------------
document.addEventListener('DOMContentLoaded', function() {

    // Podświetl kafelek "Wszystkie" jako domyślny
    var kafelekWszystkie = document.querySelector('[data-cat="all"]');
    kafelekWszystkie.classList.remove('text-secondary', 'border-secondary', 'bg-dark');
    kafelekWszystkie.classList.add('bg-success', 'text-white', 'border-success');

    <?php if ($blad): ?>
    // Otwórz modal przy błędzie (np. loginModal przy złym haśle)
    var modal = new bootstrap.Modal(document.getElementById('<?= $modal_bledu ?>'));
    modal.show();

    // Pokaż czerwony toast z treścią błędu
    var toastBlad = new bootstrap.Toast(document.getElementById('toastBlad'), { delay: 3000 });
    toastBlad.show();
    <?php endif; ?>

    <?php if ($sukces): ?>
    // Pokaż zielony toast z komunikatem sukcesu
    var toastSukces = new bootstrap.Toast(document.getElementById('toastSukces'), { delay: 3000 });
    toastSukces.show();
    <?php endif; ?>

});
</script>

</body>
</html>