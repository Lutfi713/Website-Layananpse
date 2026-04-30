<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include 'koneksi.php';

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'super_admin')) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit();
    }

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = "SELECT id, fullname, nip, jabatan, instansi, email, no_hp, role FROM users WHERE id = $id";
        $result = mysqli_query($koneksi, $query);
        
        if ($row = mysqli_fetch_assoc($result)) {
            echo json_encode(['success' => true, 'data' => $row]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User tidak ditemukan']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server Error']);
}
?>