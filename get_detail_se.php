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

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Query dasar
    $query = "SELECT l.*, u.fullname, u.jabatan, u.no_hp, u.email 
              FROM layanan_se l 
              JOIN users u ON l.user_id = u.id 
              WHERE l.id = $id";
    
    // Jika bukan admin, tambahkan filter user_id agar hanya bisa lihat punya sendiri
    if (!$is_admin) {
        $query .= " AND l.user_id = '$user_id'";
    }
              
    $result = mysqli_query($koneksi, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Format dates if needed
        // Gunakan tanggal_pengajuan karena created_at tidak ada di layanan_se
        $tgl = isset($row['tanggal_pengajuan']) ? $row['tanggal_pengajuan'] : date('Y-m-d');
        $row['tanggal_formatted'] = date('d F Y', strtotime($tgl));
        
        echo json_encode(['success' => true, 'data' => $row]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID tidak diberikan']);
}
?>