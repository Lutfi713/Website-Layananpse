<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include 'koneksi.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit();
    }

    $username = mysqli_real_escape_string($koneksi, $_POST['username'] ?? '');
    $code = mysqli_real_escape_string($koneksi, $_POST['code'] ?? '');

    if (!$username || !$code) {
        echo json_encode(['success' => false, 'message' => 'Lengkapi data']);
        exit();
    }

    $u = mysqli_query($koneksi, "SELECT id FROM users WHERE username='$username' OR email='$username' LIMIT 1");
    if (!$u || mysqli_num_rows($u) === 0) {
        echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
        exit();
    }
    $user = mysqli_fetch_assoc($u);

    $q = mysqli_query($koneksi, "SELECT id, expires_at FROM password_resets WHERE user_id='{$user['id']}' AND code='$code' ORDER BY created_at DESC LIMIT 1");
    if (!$q || mysqli_num_rows($q) === 0) {
        echo json_encode(['success' => false, 'message' => 'Kode verifikasi salah']);
        exit();
    }
    $reset = mysqli_fetch_assoc($q);
    if (strtotime($reset['expires_at']) < time()) {
        echo json_encode(['success' => false, 'message' => 'Kode verifikasi telah kadaluarsa']);
        exit();
    }

    echo json_encode(['success' => true, 'message' => 'Kode verifikasi valid']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server Error']);
}
?>
