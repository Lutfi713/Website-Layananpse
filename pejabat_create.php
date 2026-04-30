<?php
session_start();
include 'koneksi.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'super_admin')) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

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

$fullname = mysqli_real_escape_string($koneksi, $_POST['fullname'] ?? '');
$nip = mysqli_real_escape_string($koneksi, $_POST['nip'] ?? '');
$jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan'] ?? '');
$instansi = mysqli_real_escape_string($koneksi, $_POST['instansi'] ?? '');
$email = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
$no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp'] ?? '');
// user_id diabaikan, profil bersifat global

if (empty($fullname) || empty($nip) || empty($jabatan) || empty($instansi) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Lengkapi data wajib (Nama, NIP, Jabatan, Instansi, Email).']);
    exit();
}

$query = "INSERT INTO pejabat_profiles (user_id, fullname, nip, jabatan, instansi, email, no_hp) VALUES (NULL, '$fullname', '$nip', '$jabatan', '$instansi', '$email', '$no_hp')";
if (mysqli_query($koneksi, $query)) {
    echo json_encode(['success' => true, 'message' => 'Profil pejabat berhasil ditambahkan']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menambah profil: ' . mysqli_error($koneksi)]);
}
?>
