<?php
session_start();
include 'koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$is_admin = ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'super_admin');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // Cek apakah data ada dan milik user (kecuali admin)
    $query_cek = "SELECT * FROM layanan_se WHERE id = $id";
    if (!$is_admin) {
        $query_cek .= " AND user_id = '$user_id'";
    }
    
    $result_cek = mysqli_query($koneksi, $query_cek);
    if (mysqli_num_rows($result_cek) > 0) {
        $row = mysqli_fetch_assoc($result_cek);
        $status = $row['status'];
        $allowed_delete = ($status === 'Menunggu' || $status === 'Dalam Pembaharuan' || $status === 'Ditolak');
        if (!$allowed_delete && !$is_admin) {
            echo json_encode(['success' => false, 'message' => 'Pengajuan dengan status ini tidak boleh dihapus']);
            exit();
        }
        // Hapus data
        $query_hapus = "DELETE FROM layanan_se WHERE id = $id";
        if (mysqli_query($koneksi, $query_hapus)) {
            echo json_encode(['success' => true, 'message' => 'Data berhasil dihapus']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menghapus data: ' . mysqli_error($koneksi)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan atau Anda tidak memiliki akses']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID tidak diberikan']);
}
?>
