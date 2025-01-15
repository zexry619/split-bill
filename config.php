<?php
// config.php

$host = 'localhost';
$username = 'username db';
$password = 'Password DB';
$database = 'DB Name';

// Membuat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Cek jika koneksi gagal
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>
