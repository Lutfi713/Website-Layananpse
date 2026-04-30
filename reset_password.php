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
    $newPassword = mysqli_real_escape_string($koneksi, $_POST['new_password'] ?? '');

    if (!$username || !$code || !$newPassword) {
        echo json_encode(['success' => false, 'message' => 'Lengkapi data']);
        exit();
    }

    $len = strlen($newPassword);
    $hasLetter = preg_match('/[A-Za-z]/', $newPassword);
    $hasDigit = preg_match('/\d/', $newPassword);
    if ($len < 8 || $len > 16 || !$hasLetter || !$hasDigit) {
        echo json_encode(['success' => false, 'message' => 'Password harus 8-16 karakter dan mengandung huruf dan angka']);
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

    $upd = mysqli_query($koneksi, "UPDATE users SET password='$newPassword' WHERE id='{$user['id']}'");
    if (!$upd) {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui password: ' . mysqli_error($koneksi)]);
        exit();
    }
    mysqli_query($koneksi, "DELETE FROM password_resets WHERE user_id='{$user['id']}'");

    echo json_encode(['success' => true, 'message' => 'Password berhasil diubah']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server Error']);
}
?>
