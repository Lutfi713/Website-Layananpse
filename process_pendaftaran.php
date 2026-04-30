<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // DEBUGGING SEMENTARA
    // echo "<pre>";
    // print_r($_FILES);
    // echo "</pre>";
    // Jika $_FILES kosong, mungkin post_max_size terlampaui
    if (empty($_FILES) && empty($_POST) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
        die("Error: Ukuran data POST melebihi batas post_max_size server.");
    }

    $user_id = $_SESSION['user_id'];
    $instansi = substr(mysqli_real_escape_string($koneksi, $_POST['instansi']), 0, 255);
    $unit_kerja = substr(mysqli_real_escape_string($koneksi, $_POST['unit_kerja']), 0, 255);
    $nama_se = substr(mysqli_real_escape_string($koneksi, $_POST['nama_se']), 0, 255);
    $versi = substr(mysqli_real_escape_string($koneksi, $_POST['versi']), 0, 50);
    $bidang = substr(mysqli_real_escape_string($koneksi, $_POST['bidang']), 0, 100);
    $narahubung = substr(mysqli_real_escape_string($koneksi, $_POST['narahubung']), 0, 100);
    $telepon = substr(mysqli_real_escape_string($koneksi, $_POST['telepon']), 0, 20);
    // Potong URL max 255 karakter untuk menghindari error Data too long
    $url = substr(mysqli_real_escape_string($koneksi, $_POST['url']), 0, 255);
    $dns = substr(mysqli_real_escape_string($koneksi, $_POST['dns']), 0, 255);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']); // Deskripsi biasanya TEXT, jadi aman
    $risiko = substr(mysqli_real_escape_string($koneksi, $_POST['risiko']), 0, 50);
    $klasifikasi = substr(mysqli_real_escape_string($koneksi, $_POST['klasifikasi']), 0, 50);
    $data_pribadi = mysqli_real_escape_string($koneksi, $_POST['data_pribadi']); // Ini mungkin TEXT
    $lokasi = substr(mysqli_real_escape_string($koneksi, $_POST['lokasi']), 0, 100);
    
    $errors = [];

    // Function to handle file upload with error handling
     function uploadFile($fileInputName, &$errors, $targetDir = "uploads/") {
         $targetDir = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR;
         
         if (!file_exists($targetDir)) {
             if (!mkdir($targetDir, 0777, true)) {
                 $errors[] = "Gagal membuat folder uploads ($targetDir)";
                 return "";
             }
         }
 
         // Logging debug
         file_put_contents("debug_upload.log", date("Y-m-d H:i:s") . " - Processing $fileInputName\n", FILE_APPEND);
         if (isset($_FILES[$fileInputName])) {
             file_put_contents("debug_upload.log", print_r($_FILES[$fileInputName], true), FILE_APPEND);
         } else {
             file_put_contents("debug_upload.log", "$fileInputName not found in FILES\n", FILE_APPEND);
         }
 
         if (isset($_FILES[$fileInputName])) {
             $file = $_FILES[$fileInputName];
             
             // Check for upload errors
             if ($file['error'] !== UPLOAD_ERR_OK) {
                 if ($file['error'] === UPLOAD_ERR_NO_FILE) {
                     return ""; // No file uploaded, optional
                 }
                 
                 $uploadErrors = [
                     UPLOAD_ERR_INI_SIZE => "Ukuran file melebihi batas upload server (upload_max_filesize)",
                     UPLOAD_ERR_FORM_SIZE => "Ukuran file melebihi batas MAX_FILE_SIZE form",
                     UPLOAD_ERR_PARTIAL => "File hanya terupload sebagian",
                     UPLOAD_ERR_NO_TMP_DIR => "Missing temporary folder",
                     UPLOAD_ERR_CANT_WRITE => "Gagal menulis file ke disk",
                     UPLOAD_ERR_EXTENSION => "Upload dihentikan oleh ekstensi PHP"
                 ];
                 
                 $msg = isset($uploadErrors[$file['error']]) ? $uploadErrors[$file['error']] : "Unknown error code: " . $file['error'];
                 $errors[] = "Gagal upload $fileInputName: $msg";
                 return "";
             }
 
            // Validasi ukuran maksimal 10MB
            $maxSize = 10 * 1024 * 1024;
            if ($file['size'] > $maxSize) {
                $errors[] = "Ukuran file melebihi 10MB untuk $fileInputName";
                return "";
            }

            $fileName = basename($file['name']);
             // Sanitasi nama file untuk keamanan
             $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName);
             $targetFilePath = $targetDir . time() . "_" . $fileName;
             
             // Path relatif untuk disimpan di database (agar bisa diakses via web)
             $dbPath = "uploads/" . time() . "_" . $fileName;
             
             $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
             
            // Allow only PDF
            $allowTypes = array('pdf');
             if(in_array($fileType, $allowTypes)){
                 // Upload file to server
                 if(move_uploaded_file($file['tmp_name'], $targetFilePath)){
                     return $dbPath; // Return path relatif untuk DB
                 } else {
                     $errors[] = "Gagal memindahkan file $fileName ke $targetFilePath. Cek permission folder.";
                     return "";
                 }
            } else {
                $errors[] = "Tipe file $fileName tidak diizinkan. Hanya PDF.";
                 return "";
             }
         }
         return "";
     }

    $file_risiko = uploadFile('file_risiko', $errors);
    $file_klasifikasi = uploadFile('file_klasifikasi', $errors);
    $dokumen_pendukung = uploadFile('dokumen_pendukung', $errors);

    if (!empty($errors)) {
        $errorMsg = implode("\\n", $errors);
        echo "<script>alert('❌ Gagal Upload File:\\n$errorMsg'); window.history.back();</script>";
        exit;
    }

    // Jika sebelumnya user sudah menyimpan draft untuk nama SE yang sama,
    // lakukan UPDATE pada draft tersebut agar tidak muncul duplikasi entri.
    $cekDraft = mysqli_query($koneksi, "SELECT id, nomor_pengajuan FROM layanan_se WHERE user_id = '$user_id' AND nama_se = '$nama_se' AND status = 'Menunggu' ORDER BY id DESC LIMIT 1");
    if ($cekDraft && mysqli_num_rows($cekDraft) > 0) {
        $rowDraft = mysqli_fetch_assoc($cekDraft);
        $draftId = intval($rowDraft['id']);
        $nomor_pengajuan = $rowDraft['nomor_pengajuan'];
        if (empty($nomor_pengajuan) || strpos($nomor_pengajuan, 'DRAFT-') === 0) {
            $nomor_pengajuan = "P-" . date('YmdHis');
        }
        $update = "UPDATE layanan_se SET 
                    instansi='$instansi',
                    unit_kerja='$unit_kerja',
                    nama_se='$nama_se',
                    versi_se='$versi',
                    bidang_se='$bidang',
                    narahubung='$narahubung',
                    no_hp_narahubung='$telepon',
                    url='$url',
                    ip_server='$dns',
                    deskripsi='$deskripsi',
                    risiko='$risiko',
                    file_risiko='$file_risiko',
                    klasifikasi_data='$klasifikasi',
                    file_klasifikasi='$file_klasifikasi',
                    data_pribadi='$data_pribadi',
                    lokasi_data='$lokasi',
                    dokumen_pendukung='$dokumen_pendukung',
                    status='Menunggu',
                    tanggal_pengajuan=NOW(),
                    nomor_pengajuan='$nomor_pengajuan'
                  WHERE id = $draftId";
        if (mysqli_query($koneksi, $update)) {
            echo "<script>alert('✅ Pengajuan Berhasil Diperbarui!'); window.location.href='user_dashboard.php';</script>";
        } else {
            echo "<script>alert('❌ Gagal memperbarui pengajuan: " . mysqli_error($koneksi) . "'); window.location.href='user_dashboard.php';</script>";
        }
    } else {
        $nomor_pengajuan = "P-" . date('YmdHis');
        $query = "INSERT INTO layanan_se (user_id, instansi, unit_kerja, nama_se, versi_se, bidang_se, narahubung, no_hp_narahubung, url, ip_server, deskripsi, risiko, file_risiko, klasifikasi_data, file_klasifikasi, data_pribadi, lokasi_data, dokumen_pendukung, status, tanggal_pengajuan, nomor_pengajuan) 
                  VALUES ('$user_id', '$instansi', '$unit_kerja', '$nama_se', '$versi', '$bidang', '$narahubung', '$telepon', '$url', '$dns', '$deskripsi', '$risiko', '$file_risiko', '$klasifikasi', '$file_klasifikasi', '$data_pribadi', '$lokasi', '$dokumen_pendukung', 'Menunggu', NOW(), '$nomor_pengajuan')";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('✅ Pengajuan Berhasil Disimpan!'); window.location.href='user_dashboard.php';</script>";
        } else {
            echo "<script>alert('❌ Gagal menyimpan pengajuan: " . mysqli_error($koneksi) . "'); window.location.href='user_dashboard.php';</script>";
        }
    }
} else {
    header("Location: user_dashboard.php");
    exit();
}
?>
