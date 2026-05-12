<?php
$conn = mysqli_connect(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_NAME')
);
mysqli_set_charset($conn, 'utf8mb4');
if (!$conn) {
    die("Błąd połączenia z bazą: " . mysqli_connect_error());
}