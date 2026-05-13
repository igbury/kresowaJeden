<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad(); // safeLoad nie crashuje gdy brak pliku .env

$conn = mysqli_connect(
    $_ENV['DB_HOST'] ?? getenv('DB_HOST'),
    $_ENV['DB_USER'] ?? getenv('DB_USER'),
    $_ENV['DB_PASS'] ?? getenv('DB_PASS'),
    $_ENV['DB_NAME'] ?? getenv('DB_NAME')
);
mysqli_set_charset($conn, 'utf8mb4');
if (!$conn) {
    die("Błąd połączenia z bazą: " . mysqli_connect_error());
}