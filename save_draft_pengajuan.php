<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include 'koneksi.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$user_id = intval($_SESSION['user_id']);

function esc($conn, $key) {
    return isset($_POST[$key]) ? mysqli_real_escape_string($conn, $_POST[$key]) : '';
}

$instansi    = substr(esc($koneksi, 'instansi'), 0, 255);
$unit_kerja  = substr(esc($koneksi, 'unit_kerja'), 0, 255);
$nama_se     = substr(esc($koneksi, 'nama_se'), 0, 255);
$versi       = substr(esc($koneksi, 'versi'), 0, 50);
$bidang      = substr(esc($koneksi, 'bidang'), 0, 100);
$narahubung  = substr(esc($koneksi, 'narahubung'), 0, 255);
$telepon     = substr(esc($koneksi, 'telepon'), 0, 20);
$url         = substr(esc($koneksi, 'url'), 0, 255);
$dns         = substr(esc($koneksi, 'dns'), 0, 255);
$deskripsi   = esc($koneksi, 'deskripsi');
$risiko      = esc($koneksi, 'risiko');
$klasifikasi = esc($koneksi, 'klasifikasi');
$data_pribadi= esc($koneksi, 'data_pribadi');
$lokasi      = esc($koneksi, 'lokasi');

$nomor_pengajuan = "DRAFT-" . date('YmdHis') . "-" . rand(100,999);

// Normalisasi enum: jika tidak valid atau kosong, set NULL
$allowed_risiko = ['Strategis','Tinggi','Rendah'];
$allowed_klasifikasi = ['Terbuka','Terbatas','Tertutup'];
$allowed_lokasi = ['Dalam Negeri','Luar Negeri'];
$risikoVal = in_array($risiko, $allowed_risiko) ? "'$risiko'" : 'NULL';
$klasifikasiVal = in_array($klasifikasi, $allowed_klasifikasi) ? "'$klasifikasi'" : 'NULL';
$lokasiVal = in_array($lokasi, $allowed_lokasi) ? "'$lokasi'" : 'NULL';

$query = "INSERT INTO layanan_se 
    (user_id, instansi, unit_kerja, nama_se, versi_se, bidang_se, narahubung, no_hp_narahubung, url, ip_server, deskripsi, risiko, file_risiko, klasifikasi_data, file_klasifikasi, data_pribadi, lokasi_data, dokumen_pendukung, status, tanggal_pengajuan, nomor_pengajuan)
    VALUES
    ('$user_id', '$instansi', '$unit_kerja', '$nama_se', '$versi', '$bidang', '$narahubung', '$telepon', '$url', '$dns', '$deskripsi', $risikoVal, NULL, $klasifikasiVal, NULL, '$data_pribadi', $lokasiVal, NULL, 'Menunggu', NOW(), '$nomor_pengajuan')";

if (mysqli_query($koneksi, $query)) {
    $new_id = mysqli_insert_id($koneksi);
    $res = mysqli_query($koneksi, "SELECT id, status, nama_se, tanggal_pengajuan FROM layanan_se WHERE id = $new_id");
    $data = mysqli_fetch_assoc($res);
    echo json_encode(['success' => true, 'message' => 'Draft pengajuan disimpan ke riwayat', 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan draft: ' . mysqli_error($koneksi)]);
}
?>
