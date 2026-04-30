<?php
// Matikan error reporting agar tidak merusak JSON
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $status = isset($_POST['status']) ? mysqli_real_escape_string($koneksi, $_POST['status']) : '';

        if ($id > 0 && !empty($status)) {
            // Validasi status
            $allowed_status = ['Diterima', 'Ditolak', 'Terbit', 'Menunggu', 'Dalam Pembaharuan'];
            if (!in_array($status, $allowed_status)) {
                echo json_encode(['success' => false, 'message' => 'Status tidak valid']);
                exit();
            }

            // Logic Update Default
            $update_query = "UPDATE layanan_se SET status = '$status' WHERE id = $id";

            // Jika status Diterima/Terbit, set tanggal_terbit dan nomor_tanda_daftar jika belum ada
            if ($status == 'Diterima' || $status == 'Terbit') {
                $status = 'Terbit'; // Force status to Terbit for consistency
                
                // Cek apakah sudah ada nomor tanda daftar
                $check = mysqli_query($koneksi, "SELECT nomor_tanda_daftar FROM layanan_se WHERE id = $id");
                
                if ($check && mysqli_num_rows($check) > 0) {
                    $row = mysqli_fetch_assoc($check);
                    $nomor_tanda_daftar = isset($row['nomor_tanda_daftar']) ? $row['nomor_tanda_daftar'] : '';
                } else {
                    $nomor_tanda_daftar = '';
                }
                
                if (empty($nomor_tanda_daftar)) {
                    $tahun = date('Y');
                    $nomor_baru = "TDPSE-$tahun-" . str_pad($id, 4, '0', STR_PAD_LEFT);
                    $tanggal = date('Y-m-d H:i:s');
                    
                    $update_query = "UPDATE layanan_se SET status = 'Terbit', nomor_tanda_daftar = '$nomor_baru', tanggal_terbit = '$tanggal' WHERE id = $id";
                } else {
                    $update_query = "UPDATE layanan_se SET status = 'Terbit' WHERE id = $id";
                }
            }

            if (mysqli_query($koneksi, $update_query)) {
                echo json_encode(['success' => true, 'message' => 'Status berhasil diperbarui']);
            } else {
                throw new Exception("Database Error: " . mysqli_error($koneksi));
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server Error: ' . $e->getMessage()]);
}
?>