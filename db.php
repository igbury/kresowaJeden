<?php
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    die("Błąd: Nie znaleziono folderu 'vendor'. Uruchom polecenie 'composer install', aby zainstalować zależności.");
}

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

if (!file_exists(__DIR__ . '/.env')) {
    die("Błąd: Brak pliku .env. Skopiuj plik .env.example jako .env i uzupełnij dane dostępowe do bazy.");
}

try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'])->notEmpty();
} catch (Exception $e) {
    die("Błąd konfiguracji pliku .env: " . $e->getMessage());
}
$conn = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
mysqli_set_charset($conn, 'utf8mb4');
if (!$conn) {
    die("Błąd połączenia z bazą: " . mysqli_connect_error());
}