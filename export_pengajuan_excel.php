<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'super_admin')) {
    http_response_code(403);
    echo "Unauthorized";
    exit();
}

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

$type = isset($_GET['type']) ? $_GET['type'] : 'all';

$where = "1=1";
if ($type === 'pending') {
    $where = "l.status IN ('Menunggu','Dalam Pembaharuan')";
} elseif ($type === 'approved') {
    $where = "l.status IN ('Diterima','Terbit')";
} elseif ($type === 'rejected') {
    $where = "l.status = 'Ditolak'";
}

$query = "SELECT l.id, l.tanggal_pengajuan, l.status, l.nama_se, u.instansi, u.fullname
          FROM layanan_se l
          JOIN users u ON l.user_id = u.id
          WHERE $where
          ORDER BY l.tanggal_pengajuan DESC";
$result = mysqli_query($koneksi, $query);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$titleMap = [
    'all' => 'Total Pengajuan',
    'pending' => 'Pengajuan Menunggu',
    'approved' => 'Pengajuan Diterima / Terbit',
    'rejected' => 'Pengajuan Ditolak'
];
$sheet->setTitle('Detail Pengajuan');
$sheet->setCellValue('A1', $titleMap[$type] ?? 'Detail Pengajuan');
$sheet->mergeCells('A1:E1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$sheet->setCellValue('A3', 'No');
$sheet->setCellValue('B3', 'Tanggal');
$sheet->setCellValue('C3', 'Instansi / Pemohon');
$sheet->setCellValue('D3', 'Nama Sistem Elektronik');
$sheet->setCellValue('E3', 'Status');
$sheet->getStyle('A3:E3')->getFont()->setBold(true);
$sheet->getStyle('A3:E3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
$sheet->getStyle('A3:E3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

$i = 4;
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $i, $no++);
    $sheet->setCellValue('B' . $i, $row['tanggal_pengajuan']);
    $sheet->setCellValue('C' . $i, ($row['instansi'] ?? '-') . ' / ' . ($row['fullname'] ?? '-'));
    $sheet->setCellValue('D' . $i, $row['nama_se'] ?? '-');
    $sheet->setCellValue('E' . $i, $row['status']);
    $sheet->getStyle('A' . $i . ':E' . $i)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $i++;
}

foreach (range('A', 'E') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$filename = 'detail_pengajuan_' . $type . '_' . date('Ymd_Hi') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
