<?php
session_start();
include 'koneksi.php';
header('Content-Type: application/json');

try {
    $query = "SELECT fullname, nip FROM users WHERE role = 'super_admin' LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode(['success' => true, 'data' => $row]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Super Admin tidak ditemukan']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server Error']);
}
?>
