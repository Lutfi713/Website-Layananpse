<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$query = "SELECT l.*, u.instansi, u.fullname, u.jabatan, u.nip 
          FROM layanan_se l 
          JOIN users u ON l.user_id = u.id 
          WHERE l.id = '$id'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan.");
}

// Format Tanggal
$tanggal_terbit = !empty($data['tanggal_terbit']) ? date('d F Y', strtotime($data['tanggal_terbit'])) : date('d F Y');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat PSE - <?php echo htmlspecialchars($data['nama_se']); ?></title>
    <style>
        /* CSS for Certificate */
        body { font-family: 'Times New Roman', serif; background: #f0f0f0; margin: 0; padding: 20px; }
        .certificate-container {
            width: 297mm; /* A4 Landscape */
            height: 210mm;
            background: white;
            margin: 0 auto;
            padding: 10mm 15mm; /* Adjusted padding: top/bottom 10mm, left/right 15mm */
            box-sizing: border-box;
            position: relative;
            border: 10px double #1e40af;
            outline: 2px solid #3b82f6;
            outline-offset: -10px;
            display: flex;
            flex-direction: column;
        }
        .header { text-align: center; margin-bottom: 5px; } /* Further reduced margin */
        .header img { height: 100px; margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 24px; text-transform: uppercase; color: #1e293b; }
        .header h3 { margin: 0; font-size: 18px; font-weight: normal; color: #334155; }
        
        .content { text-align: center; flex: 1; display: flex; flex-direction: column; justify-content: flex-start; padding-top: 5px; } /* Changed justify-content */
        .title { font-size: 28px; font-weight: bold; text-decoration: underline; margin-bottom: 2px; color: #1e40af; letter-spacing: 1px; }
        .subtitle { font-size: 14px; margin-bottom: 10px; color: #64748b; font-weight: bold; }
        
        .details { margin: 5px auto; width: 90%; text-align: left; font-size: 16px; line-height: 1.4; }
        .details table { width: 100%; border-collapse: collapse; }
        .details td { vertical-align: top; padding: 4px 5px; }
        .details td:first-child { width: 200px; font-weight: bold; color: #334155; }
        .details td:nth-child(2) { width: 20px; text-align: center; }
        
        .footer { margin-top: auto; text-align: right; margin-right: 40px; padding-bottom: 5px; }
        .signature-box { display: inline-block; text-align: center; width: 300px; }
        .signature-box p { margin: 2px 0; font-size: 14px; }
        .signature-name { font-weight: bold; text-decoration: underline; margin-top: 60px; font-size: 16px; }
        .signature-nip { font-size: 14px; margin-top: 2px; }
        
        @media print {
            body { background: none; margin: 0; padding: 0; -webkit-print-color-adjust: exact; }
            .certificate-container { 
                margin: 0; 
                border: 10px double #1e40af; 
                width: 100%; 
                height: 100vh; 
                page-break-after: always;
                box-shadow: none;
                padding: 10mm 15mm;
            }
            .footer { margin-bottom: 10px; }
            @page { size: landscape; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="header">
            <!-- Ganti src dengan path logo yang sesuai -->
            <img src="Logo Diskominfo Solusi.png" alt="Logo" onerror="this.style.display='none'">
            <h2>Dinas Komunikasi dan Informatika</h2>
            <h3>Pemerintah Daerah</h3>
        </div>
        
        <div class="content">
            <div class="title">TANDA DAFTAR PENYELENGGARA SISTEM ELEKTRONIK</div>
            <div class="subtitle">Nomor: <?php echo !empty($data['nomor_tanda_daftar']) ? htmlspecialchars($data['nomor_tanda_daftar']) : '.............................................'; ?></div>
            
            <p style="font-size: 18px; margin-bottom: 5px;">Diberikan kepada:</p>
            
            <h1 style="font-size: 32px; margin: 5px 0 10px; font-family: 'Arial', sans-serif; text-transform: uppercase; color: #0f172a;"><?php echo htmlspecialchars($data['fullname']); ?></h1>
            
            <p style="font-size: 18px; margin-bottom: 5px;">Atas pendaftaran sistem elektronik:</p>
            
            <h2 style="font-size: 26px; margin: 5px 0 15px; color: #1e40af; font-style: italic;">"<?php echo htmlspecialchars($data['nama_se']); ?>"</h2>
            
            <div class="details">
                <p style="text-align: center; margin-bottom: 10px;">Telah terdaftar dalam Tanda Daftar Penyelenggara Sistem Elektronik di Lingkungan Dinas Komunikasi dan Informatika.</p>
                <table>
                    <tr>
                        <td>Tanggal Terbit</td>
                        <td>:</td>
                        <td><?php echo $tanggal_terbit; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Instansi</td>
                        <td>:</td>
                        <td><?php echo !empty($data['instansi']) ? htmlspecialchars($data['instansi']) : '-'; ?></td>
                    </tr>
                    <tr>
                        <td>Unit Kerja / Bidang</td>
                        <td>:</td>
                        <td><?php echo !empty($data['unit_kerja']) ? htmlspecialchars($data['unit_kerja']) : '-'; ?></td>
                    </tr>
                    <tr>
                        <td>Website / URL</td>
                        <td>:</td>
                        <td><?php echo !empty($data['url']) ? htmlspecialchars($data['url']) : '-'; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="footer">
            <div class="signature-box">
                <p>Ditetapkan di: [Nama Kota]</p>
                <p>Pada Tanggal: <?php echo $tanggal_terbit; ?></p>
                <p style="margin-top: 15px;">Kepala Dinas Komunikasi dan Informatika</p>
                
                <?php
                // Cek apakah ada data Super Admin untuk tanda tangan
                $super_admin_query = "SELECT fullname, nip FROM users WHERE role = 'super_admin' LIMIT 1";
                $super_admin_result = mysqli_query($koneksi, $super_admin_query);
                $super_admin = mysqli_fetch_assoc($super_admin_result);
                
                $nama_kadis = $super_admin ? strtoupper($super_admin['fullname']) : "NAMA KEPALA DINAS";
                $nip_kadis = $super_admin && !empty($super_admin['nip']) ? $super_admin['nip'] : "...................................";
                ?>
                
                <div class="signature-name"><?php echo $nama_kadis; ?></div>
                <div class="signature-nip">NIP. <?php echo $nip_kadis; ?></div>
            </div>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
