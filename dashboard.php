<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login dan role-nya admin atau super_admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'super_admin')) {
    header("Location: index.php");
    exit();
}

$admin_fullname = $_SESSION['fullname'];
$role = $_SESSION['role'];
$role_label = ($role === 'super_admin') ? 'Super Admin' : 'Administrator';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi PSE - Admin Panel</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #1e40af;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #1e293b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f1f5f9;
            min-height: 100vh;
            color: #334155;
            padding-top: 80px;
        }

        /* NAVBAR */
        .navbar-top {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 70px;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            z-index: 1000;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
        }
        /* Deleted .navbar-brand img and h3 styles to use inline styles instead */

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-info {
            text-align: right;
            line-height: 1.2;
        }

        .admin-name {
            display: block;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .admin-role {
            font-size: 0.75rem;
            color: var(--secondary);
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* CONTAINER */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* STATS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
            border-left: 4px solid transparent;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .stat-info h4 {
            color: var(--secondary);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .stat-info h2 {
            color: var(--dark);
            font-size: 1.5rem;
            font-weight: 700;
        }

        /* TABLE */
        .table-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            font-size: 1.1rem;
            color: var(--dark);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
        }

        th {
            background: #f8fafc;
            color: var(--secondary);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        td {
            color: var(--dark);
            font-size: 0.95rem;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-pending { background: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
        .badge-success { background: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; }
        .badge-danger { background: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; }
        .badge-info { background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; }

        .btn-action {
            padding: 8px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            transition: 0.2s;
            margin-right: 4px;
        }

        .btn-approve { background: var(--success); color: white; }
        .btn-reject { background: var(--danger); color: white; }
        .btn-view { background: var(--primary); color: white; }
        
        .btn-action:hover { opacity: 0.9; transform: translateY(-1px); }

        .filter-buttons {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            color: var(--secondary);
            cursor: pointer;
            font-weight: 500;
            transition: 0.2s;
        }

        .filter-btn.active, .filter-btn:hover {
            background: #eff6ff;
            color: var(--primary);
            border-color: var(--primary);
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar-top">
        <div class="navbar-brand">
            <img src="Logo Diskominfo Solusi.png" alt="Logo" onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_Kota_Probolinggo_%282010%29.png/387px-Logo_Kota_Probolinggo_%282010%29.png'; this.style.height='45px';" style="height: 50px; width: auto;">
            <div style="display: flex; flex-direction: column; line-height: 1.2; margin-left: 10px;">
                <h3 style="margin: 0; font-size: 1.1rem; color: #1e293b;">PSE Diskominfo</h3>
                <span style="font-size: 0.75rem; color: #64748b; font-weight: 500;">Admin Dashboard</span>
            </div>
        </div>

        <div class="navbar-menu" style="display: flex; gap: 20px;">
            <?php if ($role === 'super_admin') : ?>
                <a href="#" class="nav-item active" onclick="switchTab('verifikasi', this)" style="text-decoration: none; color: #64748b; font-weight: 500; padding: 8px 16px; border-radius: 8px; transition: 0.2s;">Dashboard</a>
            <?php else : ?>
                <a href="#" class="nav-item active" onclick="switchTab('verifikasi', this)" style="text-decoration: none; color: #64748b; font-weight: 500; padding: 8px 16px; border-radius: 8px; transition: 0.2s;">Verifikasi</a>
            <?php endif; ?>
            
            <a href="#" class="nav-item" onclick="switchTab('list-se', this)" style="text-decoration: none; color: #64748b; font-weight: 500; padding: 8px 16px; border-radius: 8px; transition: 0.2s;">List SE Terdaftar</a>
            
            <?php if ($role === 'admin') : ?>
            <a href="#" class="nav-item" onclick="switchTab('profil-pejabat', this)" style="text-decoration: none; color: #64748b; font-weight: 500; padding: 8px 16px; border-radius: 8px; transition: 0.2s;">Profil Pejabat</a>
            <?php endif; ?>
        </div>
        
        <div class="navbar-actions">
            <div class="admin-profile">
                <div class="admin-info">
                    <span class="admin-name"><?php echo htmlspecialchars($admin_fullname); ?></span>
                    <span class="admin-role"><?php echo $role_label; ?></span>
                </div>
                <div class="admin-avatar">
                    <?php echo substr($admin_fullname, 0, 1); ?>
                </div>
            </div>
            <a href="logout.php" style="color: var(--danger); font-size: 1.2rem; margin-left: 20px;" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </nav>

    <div class="container">
        
        <!-- HALAMAN VERIFIKASI -->
        <div id="page-verifikasi" class="dashboard-page active">
            <div style="margin-bottom: 2rem;">
                <?php if ($role === 'super_admin') : ?>
                    <h2 style="font-size: 1.8rem; color: var(--dark); font-weight: 700;">Dashboard Monitoring</h2>
                    <p style="color: var(--secondary);">Pantau seluruh data pengajuan Sistem Elektronik secara real-time.</p>
                <?php else : ?>
                    <h2 style="font-size: 1.8rem; color: var(--dark); font-weight: 700;">Verifikasi Pengajuan</h2>
                    <p style="color: var(--secondary);">Kelola dan verifikasi pengajuan Sistem Elektronik yang masuk.</p>
                <?php endif; ?>
            </div>

        <?php
        // Fetch Statistics
        $q_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM layanan_se");
        $d_total = mysqli_fetch_assoc($q_total);

        $q_pending = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM layanan_se WHERE status = 'Menunggu' OR status = 'Dalam Pembaharuan'");
        $d_pending = mysqli_fetch_assoc($q_pending);

        $q_approved = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM layanan_se WHERE status = 'Diterima' OR status = 'Terbit'");
        $d_approved = mysqli_fetch_assoc($q_approved);

        $q_rejected = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM layanan_se WHERE status = 'Ditolak'");
        $d_rejected = mysqli_fetch_assoc($q_rejected);
        ?>

        <div class="stats-grid">
            <div class="stat-card" style="border-left-color: #3b82f6; cursor: pointer;" onclick="showStatDetail('all')">
                <div class="stat-icon" style="background: #eff6ff; color: #3b82f6;">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stat-info">
                    <h4>Total Pengajuan</h4>
                    <h2><?php echo $d_total['total']; ?></h2>
                </div>
            </div>
            
            <div class="stat-card" style="border-left-color: #f59e0b; cursor: pointer;" onclick="showStatDetail('pending')">
                <div class="stat-icon" style="background: #fff7ed; color: #f59e0b;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h4>Menunggu</h4>
                    <h2><?php echo $d_pending['total']; ?></h2>
                </div>
            </div>

            <div class="stat-card" style="border-left-color: #10b981; cursor: pointer;" onclick="showStatDetail('approved')">
                <div class="stat-icon" style="background: #f0fdf4; color: #10b981;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h4>Diterima / Terbit</h4>
                    <h2><?php echo $d_approved['total']; ?></h2>
                </div>
            </div>

            <div class="stat-card" style="border-left-color: #ef4444; cursor: pointer;" onclick="showStatDetail('rejected')">
                <div class="stat-icon" style="background: #fef2f2; color: #ef4444;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h4>Ditolak</h4>
                    <h2><?php echo $d_rejected['total']; ?></h2>
                </div>
            </div>

            <!-- CARD TOTAL USER LOGIN (HANYA MUNCUL DI ADMIN DASHBOARD) -->
            <?php
            // Hitung user yang sedang login (Session aktif) - Simulasi dengan last_login
            // Asumsi ada kolom 'last_login' di tabel users. Jika belum ada, tampilkan total user saja.
            $q_active_users = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users"); 
            // Note: Untuk mengetahui "siapa saja yang login" secara real-time, perlu manajemen session database atau kolom 'last_activity'
            // Disini kita tampilkan Total User Terdaftar sebagai gantinya, atau Log Login terakhir.
            $d_active_users = mysqli_fetch_assoc($q_active_users);
            ?>
            <div class="stat-card" style="border-left-color: #8b5cf6; cursor: pointer;" onclick="showLoginHistory()">
                <div class="stat-icon" style="background: #f3e8ff; color: #8b5cf6;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h4>Total Pengguna</h4>
                    <h2><?php echo $d_active_users['total']; ?></h2>
                    <span style="font-size: 0.7rem; color: #8b5cf6;">Klik untuk detail</span>
                </div>
            </div>
        </div>

        <!-- MODAL RIWAYAT LOGIN -->
        <div id="loginHistoryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 3000; justify-content: center; align-items: center;">
            <div style="background: white; width: 600px; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                <div style="padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; gap: 10px;">
                    <h3 style="margin: 0; color: #1e293b;">Riwayat Login Pengguna</h3>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button onclick="exportLoginHistoryExcel()" style="padding: 8px 12px; border: 1px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer; color: #334155; font-weight: 500;">Cetak Excel</button>
                        <button onclick="document.getElementById('loginHistoryModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer;">&times;</button>
                    </div>
                </div>
                <div style="padding: 0; max-height: 400px; overflow-y: auto;">
                    <table class="table" style="margin: 0;">
                        <thead>
                            <tr style="background: #f1f5f9; position: sticky; top: 0;">
                                <th>Nama Pengguna</th>
                                <th>Role</th>
                                <th>Waktu Login Terakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query untuk mengambil user yang baru login (diurutkan berdasarkan created_at atau updated_at sebagai proxy)
                            // Idealnya ada tabel 'login_logs' atau kolom 'last_login'
                            $q_users = mysqli_query($koneksi, "SELECT fullname, role, created_at FROM users ORDER BY created_at DESC LIMIT 10");
                            while($u = mysqli_fetch_assoc($q_users)) {
                                echo "<tr>
                                    <td>".htmlspecialchars($u['fullname'])."</td>
                                    <td><span class='badge badge-info'>".htmlspecialchars($u['role'])."</span></td>
                                    <td>".date('d M Y H:i', strtotime($u['created_at']))."</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MODAL DETAIL STATISTIK -->
        <div id="statDetailModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 3000; justify-content: center; align-items: center;">
            <div style="background: white; width: 800px; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
                <div style="padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc; gap: 10px;">
                    <h3 id="statDetailTitle" style="margin: 0; color: #1e293b;">Detail</h3>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button onclick="exportStatExcel()" style="padding: 8px 12px; border: 1px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer; color: #334155; font-weight: 500;">Cetak Excel</button>
                        <button onclick="document.getElementById('statDetailModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer;">&times;</button>
                    </div>
                </div>
                <div style="padding: 0; max-height: 520px; overflow-y: auto;">
                    <table id="statDetailTable" class="table" style="margin: 0;">
                        <thead>
                            <tr style="background: #f1f5f9; position: sticky; top: 0;">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Instansi / Pemohon</th>
                                <th>Nama Sistem Elektronik</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> Daftar Pengajuan</h3>
                <div class="filter-buttons">
                    <button class="filter-btn active" onclick="filterTable('all', this)">Semua</button>
                    <button class="filter-btn" onclick="filterTable('pending', this)">Menunggu</button>
                    <button class="filter-btn" onclick="filterTable('approved', this)">Diterima</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="verifikasiTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Instansi / Pemohon</th>
                            <th>Nama Sistem Elektronik</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // FIX: Menggunakan tanggal_pengajuan alih-alih created_at
                        $query = "SELECT l.*, u.instansi, u.fullname FROM layanan_se l JOIN users u ON l.user_id = u.id ORDER BY l.tanggal_pengajuan DESC";
                        $result = mysqli_query($koneksi, $query);
                        
                        if(mysqli_num_rows($result) > 0) {
                            $no = 1;
                            while($row = mysqli_fetch_assoc($result)) {
                                $badge = 'badge-info';
                                $filterClass = 'all';
                                
                                if($row['status'] == 'Menunggu' || $row['status'] == 'Dalam Pembaharuan') {
                                    $badge = 'badge-pending';
                                    $filterClass .= ' pending';
                                } elseif($row['status'] == 'Diterima' || $row['status'] == 'Terbit') {
                                    $badge = 'badge-success';
                                    $filterClass .= ' approved';
                                } elseif($row['status'] == 'Ditolak') {
                                    $badge = 'badge-danger';
                                    $filterClass .= ' rejected';
                                }

                                // Handle tanggal fallback
                                $tanggal = isset($row['tanggal_pengajuan']) ? $row['tanggal_pengajuan'] : '-';

                                echo "<tr class='table-row $filterClass'>
                                    <td>$no</td>
                                    <td>".htmlspecialchars($tanggal)."</td>
                                    <td>".htmlspecialchars($row['instansi'])."<br><small style='color:#64748b;'>".htmlspecialchars($row['fullname'])."</small></td>
                                    <td><strong>".htmlspecialchars($row['nama_se'])."</strong></td>
                                    <td><span class='badge $badge'>".$row['status']."</span></td>
                                    <td>
                                        <div style='display:flex;'>
                                            <button class='btn-action btn-view' onclick='detailPengajuan(".$row['id'].")' title='Lihat Detail'><i class='fas fa-eye'></i></button>";
                                            
                                            // HANYA TAMPILKAN TOMBOL APPROVE/REJECT UNTUK ADMIN (BUKAN SUPER ADMIN)
                                            if ($role !== 'super_admin') {
                                                echo "<button class='btn-action btn-approve' onclick='updateStatus(".$row['id'].", \"Diterima\")' title='Setujui'><i class='fas fa-check'></i></button>
                                                      <button class='btn-action btn-reject' onclick='updateStatus(".$row['id'].", \"Ditolak\")' title='Tolak'><i class='fas fa-times'></i></button>";
                                            }
                                            
                                echo "  </div>
                                    </td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center; padding: 3rem; color: #94a3b8;'>Belum ada data pengajuan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script>
        <?php
        $allDataRes = mysqli_query($koneksi, "SELECT l.id, l.tanggal_pengajuan, l.status, l.nama_se, u.instansi, u.fullname FROM layanan_se l JOIN users u ON l.user_id = u.id ORDER BY l.tanggal_pengajuan DESC");
        $allData = [];
        while($r = mysqli_fetch_assoc($allDataRes)) { $allData[] = $r; }
        ?>
        window.pengajuanData = <?php echo json_encode($allData); ?>;
        </script>
        </div>

        <!-- HALAMAN PROFIL PEJABAT (MANAJEMEN PENGGUNA) -->
        <div id="page-profil-pejabat" class="dashboard-page" style="display: none;">
            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.8rem; color: var(--dark); font-weight: 700;">Profil Pejabat</h2>
                <p style="color: var(--secondary);">Kelola data pejabat/pengguna yang terdaftar dalam sistem.</p>
            </div>

            <div class="table-card">
                <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3><i class="fas fa-users-cog"></i> Daftar Pejabat</h3>
                    <button onclick="openPejabatModal()" style="padding: 8px 12px; border: 1px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer; color: #334155; font-weight: 500;">Tambah Pejabat</button>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
                                <th>Instansi</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pejabatTableBody">
                            <tr><td colspan="7" style="text-align:center; padding: 2rem; color:#94a3b8;">Memuat data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <!-- EDIT USER MODAL -->
    <div id="editUserModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
        <div style="background: white; width: 90%; max-width: 500px; border-radius: 16px; padding: 25px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="margin: 0; color: #1e293b;">Edit Data Pejabat</h3>
                <button onclick="document.getElementById('editUserModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer;">&times;</button>
            </div>
            
            <form id="editUserForm" onsubmit="submitEditUser(event)">
                <input type="hidden" id="edit_user_id" name="id">
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #334155;">Nama Lengkap</label>
                    <input type="text" id="edit_fullname" name="fullname" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #334155;">NIP</label>
                        <input type="text" id="edit_nip" name="nip" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #334155;">No. HP</label>
                        <input type="text" id="edit_no_hp" name="no_hp" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #334155;">Jabatan</label>
                    <input type="text" id="edit_jabatan" name="jabatan" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #334155;">Instansi</label>
                    <input type="text" id="edit_instansi" name="instansi" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #334155;">Email</label>
                    <input type="email" id="edit_email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; color: #334155;">Role</label>
                    <select id="edit_role" name="role" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>

                <button type="submit" style="width: 100%; background: #3b82f6; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s;">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    <div id="detailModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
        <div style="background: white; width: 90%; max-width: 700px; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); max-height: 90vh; display: flex; flex-direction: column;">
            <div style="padding: 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
                <h3 style="margin: 0; color: #1e293b;">Detail Pengajuan</h3>
                <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer;">&times;</button>
            </div>
            <div style="padding: 24px; overflow-y: auto;">
                <div id="modalContent">
                    <div style="text-align: center; padding: 20px;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #3b82f6;"></i>
                        <p style="margin-top: 10px; color: #64748b;">Memuat data...</p>
                    </div>
                </div>
            </div>
            <div style="padding: 20px; border-top: 1px solid #e2e8f0; background: #f8fafc; display: flex; justify-content: flex-end; gap: 10px;">
                <button onclick="closeModal()" style="padding: 10px 20px; border: 1px solid #e2e8f0; background: white; border-radius: 8px; cursor: pointer;">Tutup</button>
            </div>
        </div>
        </div>

    <!-- MODAL TAMBAH/EDIT PROFIL PEJABAT -->
    <div id="pejabatModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index:2000; justify-content:center; align-items:center;">
        <div style="background:white; width:95%; max-width:560px; border-radius:16px; padding:24px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <h3 id="pejabatModalTitle" style="margin:0; color:#1e293b;">Tambah Pejabat</h3>
                <button onclick="closePejabatModal()" style="background:none; border:none; font-size:1.5rem; color:#64748b; cursor:pointer;">&times;</button>
            </div>
            <form id="pejabatForm" onsubmit="submitPejabat(event)">
                <input type="hidden" name="id" id="pejabat_id">
                
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <label style="display:block; margin-bottom:6px; color:#334155;">Nama Lengkap</label>
                        <input type="text" name="fullname" id="pejabat_fullname" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:6px; color:#334155;">NIP</label>
                        <input type="text" name="nip" id="pejabat_nip" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;">
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:12px;">
                    <div>
                        <label style="display:block; margin-bottom:6px; color:#334155;">Jabatan</label>
                        <input type="text" name="jabatan" id="pejabat_jabatan" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:6px; color:#334155;">Instansi</label>
                        <input type="text" name="instansi" id="pejabat_instansi" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;">
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:12px;">
                    <div>
                        <label style="display:block; margin-bottom:6px; color:#334155;">Email</label>
                        <input type="email" name="email" id="pejabat_email" required style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:6px; color:#334155;">No. HP</label>
                        <input type="text" name="no_hp" id="pejabat_no_hp" style="width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px;">
                    </div>
                </div>
                <div style="margin-top:16px; display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" onclick="closePejabatModal()" style="padding:10px 14px; border:1px solid #e2e8f0; background:white; border-radius:8px; cursor:pointer;">Batal</button>
                    <button type="submit" style="padding:10px 14px; border:none; background:#3b82f6; color:white; border-radius:8px; cursor:pointer;">Simpan</button>
                </div>
            </form>
        </div>
    </div>

        <!-- HALAMAN LIST SE TERDAFTAR (SUPER ADMIN FEATURE) -->
        <div id="page-list-se" class="dashboard-page" style="display: none;">
            <div style="margin-bottom: 2rem;">
                <h2 style="font-size: 1.8rem; color: var(--dark); font-weight: 700;">List SE Terdaftar</h2>
                <p style="color: var(--secondary);">Daftar Sistem Elektronik yang telah terbit Tanda Daftarnya.</p>
            </div>

            <div class="table-card">
                <div class="card-header">
                    <h3><i class="fas fa-certificate"></i> SE Terdaftar</h3>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Instansi</th>
                                <th>Nama Sistem</th>
                                <th>Tanda Daftar</th>
                                <th>Tanggal Terbit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query_list = "SELECT l.*, u.instansi FROM layanan_se l JOIN users u ON l.user_id = u.id WHERE l.status IN ('Diterima', 'Terbit') ORDER BY l.tanggal_terbit DESC";
                            $result_list = mysqli_query($koneksi, $query_list);
                            
                            if(mysqli_num_rows($result_list) > 0) {
                                $no = 1;
                                while($row = mysqli_fetch_assoc($result_list)) {
                                    $tanda_daftar = !empty($row['nomor_tanda_daftar']) ? $row['nomor_tanda_daftar'] : '<span class="badge badge-pending">Belum Terbit</span>';
                                    $tanggal = !empty($row['tanggal_terbit']) ? date('d/m/Y', strtotime($row['tanggal_terbit'])) : '-';

                                    echo "<tr>
                                        <td>$no</td>
                                        <td>".htmlspecialchars($row['instansi'])."</td>
                                        <td><strong>".htmlspecialchars($row['nama_se'])."</strong></td>
                                        <td>$tanda_daftar</td>
                                        <td>$tanggal</td>
                                        <td>
                                            <button class='btn-action btn-view' onclick='detailPengajuan(".$row['id'].")' title='Lihat Detail'><i class='fas fa-eye'></i></button>
                                            ";
                                            
                                    // TOMBOL CETAK SERTIFIKAT (TAMPIL UNTUK SEMUA ROLE)
                                    echo "<button class='btn-action btn-approve' onclick='cetakSertifikat(".$row['id'].")' title='Cetak Sertifikat' style='background: #8b5cf6;'><i class='fas fa-print'></i> Sertifikat</button>";
                                    
                                    echo "</td>
                                    </tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='6' style='text-align:center; padding: 3rem; color: #94a3b8;'>Belum ada data SE terdaftar.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- POPUP NOTIFIKASI -->
    <div id="popupModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 3000; justify-content: center; align-items: center;">
        <div style="background: white; width: 400px; border-radius: 16px; text-align: center; padding: 30px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <div id="popupIcon" style="width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 40px;">
                <!-- Icon will be injected here -->
            </div>
            <h3 id="popupTitle" style="margin: 0 0 10px; color: #1e293b;">Title</h3>
            <p id="popupMessage" style="margin: 0 0 25px; color: #64748b; line-height: 1.5;">Message</p>
            <button onclick="closePopup()" style="background: #3b82f6; color: white; border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s;">OK</button>
        </div>
    </div>

    <!-- KONFIRMASI MODAL -->
    <div id="confirmModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 3000; justify-content: center; align-items: center;">
        <div style="background: white; width: 400px; border-radius: 16px; text-align: center; padding: 30px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <div id="confirmIcon" style="width: 80px; height: 80px; border-radius: 50%; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 40px;">
                <i class="fas fa-question"></i>
            </div>
            <h3 id="confirmTitle" style="margin: 0 0 10px; color: #1e293b;">Konfirmasi</h3>
            <p id="confirmMessage" style="margin: 0 0 25px; color: #64748b; line-height: 1.5;">Apakah Anda yakin?</p>
            <div style="display: flex; justify-content: center; gap: 15px;">
                <button onclick="closeConfirmModal()" style="background: #e2e8f0; color: #475569; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s;">Batal</button>
                <button id="confirmBtn" style="background: #3b82f6; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s;">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>

    <script>
        function showConfirm(title, message, onConfirm, type = 'info') {
            const modal = document.getElementById('confirmModal');
            const icon = document.getElementById('confirmIcon');
            const confirmBtn = document.getElementById('confirmBtn');
            
            document.getElementById('confirmTitle').textContent = title;
            document.getElementById('confirmMessage').textContent = message;
            
            if (type === 'danger') {
                icon.style.background = '#fee2e2';
                icon.style.color = '#ef4444';
                icon.innerHTML = '<i class="fas fa-exclamation-triangle"></i>';
                confirmBtn.style.background = '#ef4444';
            } else if (type === 'success') {
                icon.style.background = '#dcfce7';
                icon.style.color = '#166534';
                icon.innerHTML = '<i class="fas fa-check"></i>';
                confirmBtn.style.background = '#166534';
            } else {
                icon.style.background = '#eff6ff';
                icon.style.color = '#3b82f6';
                icon.innerHTML = '<i class="fas fa-question"></i>';
                confirmBtn.style.background = '#3b82f6';
            }
            
            confirmBtn.onclick = function() {
                closeConfirmModal();
                onConfirm();
            };
            
            modal.style.display = 'flex';
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').style.display = 'none';
        }

        function showPopup(type, title, message) {
            const modal = document.getElementById('popupModal');
            const icon = document.getElementById('popupIcon');
            const titleEl = document.getElementById('popupTitle');
            const msgEl = document.getElementById('popupMessage');
            
            modal.style.display = 'flex';
            titleEl.textContent = title;
            msgEl.textContent = message;
            
            if (type === 'success') {
                icon.style.background = '#dcfce7';
                icon.style.color = '#166534';
                icon.innerHTML = '<i class="fas fa-check"></i>';
            } else {
                icon.style.background = '#fee2e2';
                icon.style.color = '#991b1b';
                icon.innerHTML = '<i class="fas fa-times"></i>';
            }
        }

        function closePopup() {
            document.getElementById('popupModal').style.display = 'none';
            if (window.shouldReload) {
                location.reload();
            }
        }

        function showLoginHistory() {
            document.getElementById('loginHistoryModal').style.display = 'flex';
        }

        // ===== CRUD PROFIL PEJABAT =====
        function openPejabatModal(data) {
            document.getElementById('pejabatModal').style.display = 'flex';
            document.getElementById('pejabatModalTitle').textContent = data ? 'Edit Pejabat' : 'Tambah Pejabat';
            document.getElementById('pejabat_id').value = data?.id || '';
            document.getElementById('pejabat_fullname').value = data?.fullname || '';
            document.getElementById('pejabat_nip').value = data?.nip || '';
            document.getElementById('pejabat_jabatan').value = data?.jabatan || '';
            document.getElementById('pejabat_instansi').value = data?.instansi || '';
            document.getElementById('pejabat_email').value = data?.email || '';
            document.getElementById('pejabat_no_hp').value = data?.no_hp || '';
        }
        function closePejabatModal(){ document.getElementById('pejabatModal').style.display='none'; }
        function loadPejabat() {
            fetch('pejabat_list.php')
                .then(r=>r.json())
                .then(res=>{
                    const tbody = document.getElementById('pejabatTableBody');
                    tbody.innerHTML = '';
                    if (!res.success || !res.data || res.data.length===0) {
                        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding: 2rem; color:#94a3b8;">Belum ada data pejabat.</td></tr>';
                        return;
                    }
                    res.data.forEach(function(p){
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${escapeHtml(p.fullname)}</td>
                            <td>${escapeHtml(p.nip)}</td>
                            <td>${escapeHtml(p.jabatan)}</td>
                            <td>${escapeHtml(p.instansi)}</td>
                            <td>${escapeHtml(p.email)}</td>
                            <td>${escapeHtml(p.no_hp || '')}</td>
                            <td>
                                <button class="btn-action btn-view" title="Edit" onclick='openPejabatModal(${JSON.stringify(p)})'><i class="fas fa-edit"></i></button>
                                <button class="btn-action btn-reject" title="Hapus" onclick='deletePejabat(${p.id})'><i class="fas fa-trash"></i></button>
                            </td>`;
                        tbody.appendChild(tr);
                    });
                });
        }
        function submitPejabat(e){
            e.preventDefault();
            const form = document.getElementById('pejabatForm');
            const fd = new FormData(form);
            const hasId = !!fd.get('id');
            fetch(hasId ? 'pejabat_update.php' : 'pejabat_create.php', { method:'POST', body:fd })
                .then(r=>r.json())
                .then(res=>{
                    if(res.success){
                        closePejabatModal();
                        showPopup('success','Berhasil',res.message||'Data tersimpan');
                        loadPejabat();
                    } else {
                        showPopup('error','Gagal',res.message||'Tidak dapat menyimpan');
                    }
                })
                .catch(()=>showPopup('error','Gagal','Terjadi kesalahan'));
        }
        function deletePejabat(id){
            showConfirm('Hapus Pejabat','Yakin menghapus profil ini?', function(){
                const fd = new FormData(); fd.append('id', id);
                fetch('pejabat_delete.php', { method:'POST', body:fd })
                    .then(r=>r.json())
                    .then(res=>{
                        if(res.success){ showPopup('success','Berhasil',res.message); loadPejabat(); }
                        else { showPopup('error','Gagal',res.message); }
                    })
                    .catch(()=>showPopup('error','Gagal','Terjadi kesalahan'));
            }, 'danger');
        }
        function escapeHtml(s){ return String(s||'').replace(/[&<>"']/g,function(m){return ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[m]);}); }
        document.addEventListener('DOMContentLoaded', loadPejabat);

        function printLoginHistory() {
            const modal = document.getElementById('loginHistoryModal');
            const table = modal ? modal.querySelector('table') : null;
            const w = window.open('', '_blank');
            const html = `
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Riwayat Login Pengguna</title>
  <style>
    body { font-family: Arial, Inter, sans-serif; padding: 24px; color: #0f172a; }
    h2 { margin: 0 0 12px; color: #1e293b; }
    .meta { margin-bottom: 16px; color: #64748b; font-size: 0.9rem; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #e5e7eb; padding: 10px 12px; text-align: left; font-size: 0.95rem; }
    th { background: #f8fafc; color: #334155; }
    .badge { padding: 4px 10px; border-radius: 999px; background: #eef2ff; color: #1e40af; font-weight: 600; font-size: 0.8rem; display: inline-block; }
    @media print {
      @page { size: A4; margin: 16mm; }
    }
  </style>
</head>
<body>
  <h2>Riwayat Login Pengguna</h2>
  <div class="meta">Dicetak: ${new Date().toLocaleString('id-ID')}</div>
  ${table ? table.outerHTML : '<p>Data tidak tersedia.</p>'}
</body>
</html>`;
            w.document.open();
            w.document.write(html);
            w.document.close();
            w.focus();
            w.print();
            w.close();
        }

        function exportLoginHistoryExcel() {
            window.open('export_login_history_excel.php', '_blank');
        }

        function showStatDetail(type) {
            const titleMap = { all: 'Total Pengajuan', pending: 'Pengajuan Menunggu', approved: 'Pengajuan Diterima / Terbit', rejected: 'Pengajuan Ditolak' };
            const modal = document.getElementById('statDetailModal');
            const tbody = document.querySelector('#statDetailTable tbody');
            document.getElementById('statDetailTitle').textContent = titleMap[type] || 'Detail';
            tbody.innerHTML = '';
            window.statCurrentType = type;
            const data = (window.pengajuanData || []).filter(function(item){
                if (type === 'all') return true;
                if (type === 'pending') return item.status === 'Menunggu' || item.status === 'Dalam Pembaharuan';
                if (type === 'approved') return item.status === 'Diterima' || item.status === 'Terbit';
                if (type === 'rejected') return item.status === 'Ditolak';
                return true;
            });
            for (var i=0;i<data.length;i++){
                var d = data[i];
                var row = document.createElement('tr');
                row.innerHTML = '<td>'+(i+1)+'</td>'
                    +'<td>'+(d.tanggal_pengajuan || '-')+'</td>'
                    +'<td>'+(d.instansi || '-')+' / '+(d.fullname || '-')+'</td>'
                    +'<td>'+(d.nama_se || '-')+'</td>'
                    +'<td>'+d.status+'</td>';
                tbody.appendChild(row);
            }
            modal.style.display = 'flex';
        }

        function exportStatExcel() {
            const type = window.statCurrentType || 'all';
            window.open('export_pengajuan_excel.php?type=' + encodeURIComponent(type), '_blank');
        }

        function switchTab(pageId, btn) {
            // Hide all pages
            document.querySelectorAll('.dashboard-page').forEach(page => {
                page.style.display = 'none';
                page.classList.remove('active');
            });
            
            // Show target page
            if (pageId === 'verifikasi') {
                document.getElementById('page-verifikasi').style.display = 'block';
            } else if (pageId === 'list-se') {
                document.getElementById('page-list-se').style.display = 'block';
            } else if (pageId === 'profil-pejabat') {
                document.getElementById('page-profil-pejabat').style.display = 'block';
            }
            
            // Update nav state
            document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(nav => nav.style.color = '#64748b');
            document.querySelectorAll('.nav-item').forEach(nav => nav.style.background = 'none');
            
            btn.classList.add('active');
            btn.style.color = '#3b82f6';
            btn.style.background = '#eff6ff';
        }

        function editUser(id) {
            const modal = document.getElementById('editUserModal');
            modal.style.display = 'flex';
            
            // Fetch user data
            fetch(`get_user_detail.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const u = data.data;
                        document.getElementById('edit_user_id').value = u.id;
                        document.getElementById('edit_fullname').value = u.fullname;
                        document.getElementById('edit_nip').value = u.nip || '';
                        document.getElementById('edit_jabatan').value = u.jabatan || '';
                        document.getElementById('edit_instansi').value = u.instansi || '';
                        document.getElementById('edit_email').value = u.email;
                        document.getElementById('edit_no_hp').value = u.no_hp || '';
                        document.getElementById('edit_role').value = u.role;
                    } else {
                        alert('Gagal mengambil data user: ' + data.message);
                        modal.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data.');
                    modal.style.display = 'none';
                });
        }

        function submitEditUser(e) {
            e.preventDefault();
            const form = document.getElementById('editUserForm');
            const formData = new FormData(form);
            
            fetch('update_user_admin.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showPopup('success', 'Berhasil!', data.message);
                    document.getElementById('editUserModal').style.display = 'none';
                    // Reload page after popup closed
                    window.shouldReload = true;
                } else {
                    showPopup('error', 'Gagal!', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showPopup('error', 'Error!', 'Terjadi kesalahan sistem');
            });
        }

        function cetakSertifikat(id) {
            window.open('cetak_sertifikat.php?id=' + id, '_blank');
        }

        function filterTable(filter, btn) {
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Filter rows
            const rows = document.querySelectorAll('.table-row');
            rows.forEach(row => {
                if (filter === 'all' || row.classList.contains(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function updateStatus(id, status) {
            const title = status === 'Diterima' ? 'Setujui Pengajuan' : 'Tolak Pengajuan';
            const msg = status === 'Diterima' ? 
                'Apakah Anda yakin ingin MENYETUJUI pengajuan ini?\nSistem akan menerbitkan Tanda Daftar PSE secara otomatis.' : 
                'Apakah Anda yakin ingin MENOLAK pengajuan ini?';
            const type = status === 'Diterima' ? 'success' : 'danger';
                
            showConfirm(title, msg, function() {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('status', status);

                fetch('update_status.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(text => {
                    try {
                        const data = JSON.parse(text);
                        if (data.success) {
                            window.shouldReload = true;
                            showPopup('success', 'Berhasil!', data.message);
                        } else {
                            window.shouldReload = false;
                            showPopup('error', 'Gagal!', data.message);
                        }
                    } catch (e) {
                        console.error('Server Error:', text);
                        window.shouldReload = false;
                        showPopup('error', 'Error Sistem!', 'Terjadi kesalahan pada server. Cek console browser untuk detail.');
                    }
                })
                .catch(error => {
                    console.error('Network Error:', error);
                    window.shouldReload = false;
                    showPopup('error', 'Koneksi Gagal!', 'Gagal menghubungi server. Periksa koneksi internet Anda.');
                });
            }, type);
        }

        function detailPengajuan(id) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('modalContent');
            
            modal.style.display = 'flex';
            content.innerHTML = `
                <div style="text-align: center; padding: 20px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #3b82f6;"></i>
                    <p style="margin-top: 10px; color: #64748b;">Memuat data...</p>
                </div>
            `;
            
            fetch(`get_detail_se.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const d = data.data;
                        const statusBadge = d.status === 'Terbit' || d.status === 'Diterima' ? 
                            '<span class="badge badge-success">Terbit</span>' : 
                            (d.status === 'Ditolak' ? '<span class="badge badge-danger">Ditolak</span>' : '<span class="badge badge-pending">Menunggu</span>');
                        
                        content.innerHTML = `
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div style="grid-column: span 2; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dashed #e2e8f0;">
                                    <h4 style="color: #64748b; font-size: 0.85rem; margin-bottom: 5px;">Informasi Dasar</h4>
                                    <div style="display: flex; justify-content: space-between; align-items: start;">
                                        <div>
                                            <h2 style="color: #1e293b; font-size: 1.5rem; margin-bottom: 5px;">${d.nama_se}</h2>
                                            <p style="color: #64748b; font-size: 0.9rem;">${d.instansi}</p>
                                        </div>
                                        ${statusBadge}
                                    </div>
                                </div>

                                <div>
                                    <label style="display: block; color: #64748b; font-size: 0.8rem; margin-bottom: 4px;">Unit Kerja</label>
                                    <div style="font-weight: 500; color: #334155;">${d.unit_kerja || '-'}</div>
                                </div>
                                <div>
                                    <label style="display: block; color: #64748b; font-size: 0.8rem; margin-bottom: 4px;">Versi Aplikasi</label>
                                    <div style="font-weight: 500; color: #334155;">${d.versi_se || '-'}</div>
                                </div>
                                
                                <div style="grid-column: span 2;">
                                    <label style="display: block; color: #64748b; font-size: 0.8rem; margin-bottom: 4px;">URL Sistem</label>
                                    <div style="font-weight: 500; color: #3b82f6;">
                                        <a href="${d.url}" target="_blank" style="text-decoration: none; color: #3b82f6;">${d.url || '-'} <i class="fas fa-external-link-alt" style="font-size: 0.8rem;"></i></a>
                                    </div>
                                </div>

                                <div style="grid-column: span 2;">
                                    <label style="display: block; color: #64748b; font-size: 0.8rem; margin-bottom: 4px;">Deskripsi</label>
                                    <div style="color: #334155; line-height: 1.6; background: #f8fafc; padding: 10px; border-radius: 8px;">${d.deskripsi || '-'}</div>
                                </div>

                                <div>
                                    <label style="display: block; color: #64748b; font-size: 0.8rem; margin-bottom: 4px;">IP Server / DNS</label>
                                    <div style="font-weight: 500; color: #334155;">${d.ip_server || '-'}</div>
                                </div>
                                <div>
                                    <label style="display: block; color: #64748b; font-size: 0.8rem; margin-bottom: 4px;">Lokasi Server</label>
                                    <div style="font-weight: 500; color: #334155;">${d.lokasi_data || '-'}</div>
                                </div>

                                <div style="grid-column: span 2; margin-top: 10px; padding-top: 10px; border-top: 1px dashed #e2e8f0;">
                                    <h4 style="color: #64748b; font-size: 0.85rem; margin-bottom: 15px;">Kontak Penanggung Jawab</h4>
                                </div>

                                <div>
                                    <label style="display: block; color: #64748b; font-size: 0.8rem; margin-bottom: 4px;">Nama Narahubung</label>
                                    <div style="font-weight: 500; color: #334155;">${d.narahubung || '-'}</div>
                                </div>
                                <div>
                                    <label style="display: block; color: #64748b; font-size: 0.8rem; margin-bottom: 4px;">Kontak (HP/WA)</label>
                                    <div style="font-weight: 500; color: #334155;">${d.no_hp_narahubung || '-'}</div>
                                </div>

                                <div style="grid-column: span 2; margin-top: 10px; padding-top: 10px; border-top: 1px dashed #e2e8f0;">
                                    <h4 style="color: #64748b; font-size: 0.85rem; margin-bottom: 15px;">Dokumen Pendukung</h4>
                                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                        ${d.dokumen_pendukung ? `<a href="${d.dokumen_pendukung}" target="_blank" class="btn-action btn-view" style="text-decoration: none; display: inline-flex; align-items: center; gap: 5px;"><i class="fas fa-file-pdf"></i> Dokumen Utama</a>` : '<span style="color: #94a3b8; font-style: italic;">Tidak ada dokumen utama</span>'}
                                        
                                        ${d.file_risiko ? `<a href="${d.file_risiko}" target="_blank" class="btn-action btn-view" style="text-decoration: none; display: inline-flex; align-items: center; gap: 5px; background: #64748b;"><i class="fas fa-shield-alt"></i> Analisis Risiko</a>` : ''}
                                        
                                        ${d.file_klasifikasi ? `<a href="${d.file_klasifikasi}" target="_blank" class="btn-action btn-view" style="text-decoration: none; display: inline-flex; align-items: center; gap: 5px; background: #f59e0b;"><i class="fas fa-file-alt"></i> Klasifikasi Data</a>` : ''}
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        content.innerHTML = `<div style="text-align: center; color: #ef4444; padding: 20px;">${data.message}</div>`;
                    }
                })
                .catch(error => {
                    content.innerHTML = `<div style="text-align: center; color: #ef4444; padding: 20px;">Terjadi kesalahan saat memuat data.</div>`;
                });
        }

        function closeModal() {
            document.getElementById('detailModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('detailModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
