<?php
session_start();
include 'koneksi.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'super_admin')) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$fullname = mysqli_real_escape_string($koneksi, $_POST['fullname'] ?? '');
$nip = mysqli_real_escape_string($koneksi, $_POST['nip'] ?? '');
$jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan'] ?? '');
$instansi = mysqli_real_escape_string($koneksi, $_POST['instansi'] ?? '');
$email = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
$no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp'] ?? '');
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
    exit();
}

$query = "UPDATE pejabat_profiles SET 
    user_id = " . ($user_id ? $user_id : "NULL") . ",
    fullname = '$fullname',
    nip = '$nip',
    jabatan = '$jabatan',
    instansi = '$instansi',
    email = '$email',
    no_hp = '$no_hp'
    WHERE id = $id";

if (mysqli_query($koneksi, $query)) {
    echo json_encode(['success' => true, 'message' => 'Profil pejabat berhasil diperbarui']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui: ' . mysqli_error($koneksi)]);
}
?>
