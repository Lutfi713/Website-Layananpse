<?php
session_start();
include 'koneksi.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user_id = intval($_SESSION['user_id']);
$createTable = "CREATE TABLE IF NOT EXISTS pejabat_profiles (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    fullname VARCHAR(255) NOT NULL,
    nip VARCHAR(20) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    instansi VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pejabat_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($koneksi, $createTable);

$result = mysqli_query($koneksi, "SELECT * FROM pejabat_profiles ORDER BY created_at DESC LIMIT 1");
if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode(['success' => true, 'data' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Profil pejabat belum tersedia']);
}
?>
