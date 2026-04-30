<?php
$host = "localhost";
$user = "root";
$pass = ""; // Default Laragon MySQL password is empty
$db   = "pse_diskominfo";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

