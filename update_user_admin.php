<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include 'koneksi.php';

header('Content-Type: application/json');

try {
    // Cek hak akses admin/super_admin
    if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'super_admin')) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $fullname = isset($_POST['fullname']) ? mysqli_real_escape_string($koneksi, $_POST['fullname']) : '';
        $nip = isset($_POST['nip']) ? mysqli_real_escape_string($koneksi, $_POST['nip']) : '';
        $jabatan = isset($_POST['jabatan']) ? mysqli_real_escape_string($koneksi, $_POST['jabatan']) : '';
        $instansi = isset($_POST['instansi']) ? mysqli_real_escape_string($koneksi, $_POST['instansi']) : '';
        $email = isset($_POST['email']) ? mysqli_real_escape_string($koneksi, $_POST['email']) : '';
        $no_hp = isset($_POST['no_hp']) ? mysqli_real_escape_string($koneksi, $_POST['no_hp']) : '';
        $role = isset($_POST['role']) ? mysqli_real_escape_string($koneksi, $_POST['role']) : 'user';

        // Validasi input minimal
        if ($id <= 0 || empty($fullname) || empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Nama lengkap dan Email wajib diisi!']);
            exit();
        }

        // Query Update
        $query = "UPDATE users SET 
                  fullname = '$fullname', 
                  nip = '$nip', 
                  jabatan = '$jabatan', 
                  instansi = '$instansi', 
                  email = '$email', 
                  no_hp = '$no_hp',
                  role = '$role'
                  WHERE id = $id";

        if (mysqli_query($koneksi, $query)) {
            echo json_encode(['success' => true, 'message' => 'Data pengguna berhasil diperbarui']);
        } else {
            throw new Exception("Database Error: " . mysqli_error($koneksi));
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server Error: ' . $e->getMessage()]);
}
?>