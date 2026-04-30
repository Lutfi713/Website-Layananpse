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

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Riwayat Login');

$sheet->setCellValue('A1', 'Riwayat Login Pengguna');
$sheet->mergeCells('A1:C1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$sheet->setCellValue('A3', 'Nama Pengguna');
$sheet->setCellValue('B3', 'Role');
$sheet->setCellValue('C3', 'Waktu Login Terakhir');
$sheet->getStyle('A3:C3')->getFont()->setBold(true);
$sheet->getStyle('A3:C3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
$sheet->getStyle('A3:C3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

$query = "SELECT fullname, role, created_at FROM users ORDER BY created_at DESC";
$result = mysqli_query($koneksi, $query);

$rowIndex = 4;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $rowIndex, $row['fullname']);
    $sheet->setCellValue('B' . $rowIndex, $row['role']);
    $sheet->setCellValue('C' . $rowIndex, isset($row['created_at']) ? date('d M Y H:i', strtotime($row['created_at'])) : '-');
    $sheet->getStyle('A' . $rowIndex . ':C' . $rowIndex)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $rowIndex++;
}

foreach (range('A', 'C') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$filename = 'riwayat_login_' . date('Ymd_Hi') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
