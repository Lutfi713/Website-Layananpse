<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSE Dashboard - DisKominfo Kota Probolinggo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /*
         * PSE Dashboard - DisKominfo Kota Probolinggo
         * Clean, Modern, Responsive Admin Dashboard
         * Version: 2.3 - Persistent Data Storage
         * Data disimpan di localStorage - TIDAK HILANG saat reload
         */

        /* === RESET & BASE STYLES === */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-color: #667eea;
            --primary-light: rgba(102, 126, 234, 0.1);
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --dark-color: #333;
            --light-color: #666;
            --white: rgba(255, 255, 255, 0.95);
            --shadow-light: 0 8px 32px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
            --border-radius: 24px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--primary-gradient);
            min-height: 100vh;
            color: var(--dark-color);
            line-height: 1.6;
        }

        /* === LAYOUT === */
        .app {
            display: flex;
            min-height: 100vh;
        }

        /* === SIDEBAR === */
        .sidebar {
            width: 280px;
            background: var(--white);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-light);
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            left: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: var(--transition);
        }

        .sidebar:hover {
            box-shadow: var(--shadow-hover);
        }

        .logo {
            text-align: center;
            padding: 1.5rem;
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 2rem;
        }

        .sidebar-nav {
            list-style: none;
        }

        .sidebar-nav li {
            padding: 1rem 2rem;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
            position: relative;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-nav li:hover {
            background: var(--primary-light);
            border-left-color: var(--primary-color);
            transform: translateX(5px);
        }

        .sidebar-nav li.active {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(118, 75, 162, 0.2));
            border-left-color: var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
        }

        /* === MAIN CONTENT === */
        .main {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* === HEADER === */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
            background: var(--white);
            backdrop-filter: blur(20px);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
        }

        .header h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .user-info {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
            padding: 0.8rem 1.5rem;
            background: var(--primary-light);
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-dot {
            font-size: 0.6rem;
            animation: pulse 2s infinite;
        }

        /* === CONTENT === */
        .content {
            display: none;
            animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .content.active {
            display: block;
        }

        /* === STATS GRID === */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--white);
            backdrop-filter: blur(20px);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            text-align: center;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        /* === FORMS === */
        .form-box {
            background: var(--white);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-submitted {
            background: linear-gradient(135deg, var(--success-color), #20c997);
            color: white;
            padding: 3rem;
            border-radius: var(--border-radius);
            text-align: center;
            box-shadow: 0 20px 60px rgba(40, 167, 69, 0.3);
            animation: bounceIn 0.6s ease;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid var(--primary-light);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-input, .form-select, .form-textarea {
            padding: 1rem 1.2rem;
            border: 2px solid var(--primary-light);
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px var(--primary-light);
            transform: translateY(-2px);
            background: white;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .checkbox-section {
            background: linear-gradient(135deg, var(--primary-light), rgba(118, 75, 162, 0.05));
            border: 2px solid var(--primary-light);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 3rem;
        }

        .checkbox-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
            cursor: pointer;
            padding: 1rem;
            border-radius: 12px;
            transition: var(--transition);
        }

        .checkbox-item:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateX(8px);
        }

        .checkbox-item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-top: 0.2rem;
            accent-color: var(--primary-color);
            flex-shrink: 0;
        }

        /* === TABLES === */
        .table-container {
            background: var(--white);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-light);
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1.5rem;
            text-align: left;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        th {
            background: var(--primary-light);
            font-weight: 600;
            color: var(--primary-color);
        }

        tr:hover {
            background: rgba(102, 126, 234, 0.05);
        }

        .status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status.publik, .status.disetujui { background: #d4edda; color: #155724; }
        .status.internal { background: #fff3cd; color: #856404; }
        .status.draft, .status.ditolak { background: #f8d7da; color: #721c24; }
        .status.pending { background: #ffc107; color: #856404; }

        /* === BUTTONS === */
        .btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-family: 'Poppins', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary { 
            background: var(--primary-gradient);
            color: white; 
        }

        .btn-success { 
            background: var(--success-color); 
            color: white; 
        }

        .btn-warning { 
            background: var(--warning-color); 
            color: #333; 
        }

        .btn-danger { 
            background: var(--danger-color); 
            color: white; 
        }

        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .action-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: flex-end;
            padding-top: 2rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        /* === ANIMATIONS === */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }

        /* === LIST CARDS === */
        .list-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }

        .list-card {
            background: var(--white);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-light);
            transition: var(--transition);
        }

        .list-card:hover {
            transform: translateY(-5px);
        }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main {
                margin-left: 0;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* === UTILITIES === */
        .text-center { text-align: center; }
        .mb-1 { margin-bottom: 1rem; }
        .mb-2 { margin-bottom: 2rem; }
    </style>
</head>
<body>
    <div class="app">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="logo">
                <i class="fas fa-shield-alt"></i> PSE
            </div>
            <ul class="sidebar-nav">
                <li data-page="dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
                <li data-page="pendaftaran" class="active"><i class="fas fa-file-signature"></i> Pendaftaran SE</li>
                <li data-page="list-se"><i class="fas fa-list"></i> List SE Terdaftar</li>
                <li data-page="riwayat"><i class="fas fa-history"></i> Riwayat Pengajuan</li>
                <li data-page="profil"><i class="fas fa-user-tie"></i> Profil</li>
                <li data-page="panduan"><i class="fas fa-book"></i> Panduan</li>
            </ul>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main">
            <!-- HEADER -->
            <header class="header">
                <h2 id="page-title">
                    <i class="fas fa-file-contract"></i> Pendaftaran Sistem Elektronik
                </h2>
                <div class="user-info">
                    Amin Juniar S
                    <i class="fas fa-circle status-dot"></i>
                </div>
            </header>

            <!-- DASHBOARD -->
            <div id="dashboard" class="content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number" id="totalSE">127</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: var(--light-color);">SE Terdaftar</div>
                        <div style="color: var(--success-color);">+12 bulan ini</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="pendingSE">45</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: var(--light-color);">Pengajuan Baru</div>
                        <div style="color: var(--warning-color);">Menunggu Verifikasi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">98%</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: var(--light-color);">Tingkat Kepatuhan</div>
                        <div style="color: var(--success-color);">Audit Terakhir</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">3</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: var(--light-color);">Insiden Keamanan</div>
                        <div style="color: var(--danger-color);">Tahun 2026</div>
                    </div>
                </div>
            </div>

            <!-- PENDAFTARAN FORM -->
            <div id="pendaftaran" class="content active">
                <div id="formContainer">
                    <form id="registrationForm" class="form-box">
                        <!-- Section 1 -->
                        <div class="section-title">
                            <i class="fas fa-building-government"></i>
                            Identitas Instansi & Sistem
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-building"></i> Nama Instansi</label>
                                <input type="text" class="form-input" name="instansi" value="Pemerintah Kota Probolinggo" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-sitemap"></i> Unit Kerja</label>
                                <input type="text" class="form-input" name="unitKerja" placeholder="Diskominfo Kota Probolinggo" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-laptop-code"></i> Nama Sistem Elektronik</label>
                                <input type="text" class="form-input" name="namaSE" placeholder="SIPLADOK Probolinggo" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-tag"></i> Versi Sistem</label>
                                <input type="text" class="form-input" name="versi" placeholder="v2.1.0" required>
                            </div>
                        </div>

                        <!-- Section 2 -->
                        <div class="section-title">
                            <i class="fas fa-file-alt"></i>
                            Deskripsi & Klasifikasi
                        </div>
                        <div class="form-grid">
                            <div class="form-group" style="grid-column: 1/-1;">
                                <label class="form-label"><i class="fas fa-align-left"></i> Deskripsi Sistem</label>
                                <textarea class="form-textarea" name="deskripsi" placeholder="Jelaskan fungsi utama sistem..." required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-folder-open"></i> Kategori SE</label>
                                <select class="form-select" name="kategoriSE" required>
                                    <option value="">Pilih Kategori</option>
                                    <option>Publik</option>
                                    <option>Internal</option>
                                    <option>Terbatas</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-lock"></i> Keamanan Data</label>
                                <select class="form-select" name="keamananData" required>
                                    <option value="">Pilih Klasifikasi</option>
                                    <option>Publik</option>
                                    <option>Internal</option>
                                    <option>RAHASIA</option>
                                </select>
                            </div>
                        </div>

                        <!-- Pernyataan -->
                        <div class="checkbox-section">
                            <div class="section-title">
                                <i class="fas fa-check-double"></i> Pernyataan Kesanggupan
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="jaminan" name="jaminan" required>
                                <label for="jaminan">Menjamin keamanan sesuai PP 71/2019</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="sop" name="sop">
                                <label for="sop">SOP penanggulangan insiden tersedia</label>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button type="reset" class="btn" onclick="resetForm()" style="background: rgba(255,107,107,0.1); color: var(--danger-color); border: 2px solid rgba(255,107,107,0.3);">
                                <i class="fas fa-undo"></i> Reset Form
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- LIST SE TERDAFTAR -->
            <div id="list-se" class="content">
                <div class="section-title">
                    <i class="fas fa-list"></i> List SE Terdaftar
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> No</th>
                                <th><i class="fas fa-laptop-code"></i> Nama SE</th>
                                <th><i class="fas fa-building"></i> Instansi</th>
                                <th><i class="fas fa-folder-open"></i> Kategori</th>
                                <th><i class="fas fa-calendar"></i> Tanggal</th>
                                <th><i class="fas fa-cog"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="seTableBody"></tbody>
                    </table>
                </div>
            </div>

            <!-- RIWAYAT PENGJAJUAN -->
            <div id="riwayat" class="content">
                <div class="section-title">
                    <i class="fas fa-history"></i> Riwayat Pengajuan
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama SE</th>
                                <th>Status</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="riwayatTableBody"></tbody>
                    </table>
                </div>
            </div>

            <!-- PROFIL & PANDUAN -->
            <div id="profil" class="content">
                <div class="list-grid">
                    <div class="list-card">
                        <h3 style="color: var(--primary-color); margin-bottom: 1rem;">
                            <i class="fas fa-user-circle"></i> Amin Juniar S
                        </h3>
                        <p><strong>NIP:</strong> 198512302022031004</p>
                        <p><strong>Jabatan:</strong> Kepala Bidang Aplikasi Informatika</p>
                        <button class="btn btn-primary">Edit Profil</button>
                    </div>
                </div>
            </div>

            <div id="panduan" class="content">
                <div class="list-grid">
                    <div class="list-card">
                        <h3 style="color: var(--primary-color);"><i class="fas fa-book"></i> Panduan Penggunaan</h3>
                        <p>1. Isi form pendaftaran lengkap<br>
                           2. Tunggu verifikasi di List SE<br>
                           3. Lihat hasil di Riwayat Pengajuan</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        /**
         * PSE Dashboard JavaScript v2.3
         * Persistent Data Storage dengan localStorage
         * Data TIDAK HILANG saat reload/refresh halaman
         */

        // Load data dari localStorage atau default data
        function loadData() {
            const savedSEData = localStorage.getItem('seData');
            const savedRiwayatData = localStorage.getItem('riwayatData');
            
            seData = savedSEData ? JSON.parse(savedSEData) : [
                { id: 1, namaSE: 'SIPLADOK Probolinggo', instansi: 'Diskominfo', kategori: 'Publik', tanggal: '15 Jan 2026', status: 'Disetujui', noSE: 'PSE/001/2026' },
                { id: 2, namaSE: 'e-Penduduk', instansi: 'Dukcapil', kategori: 'Publik', tanggal: '10 Feb 2026', status: 'pending', noSE: '' }
            ];
            
            riwayatData = savedRiwayatData ? JSON.parse(savedRiwayatData) : [
                { tanggal: '25 Jan 2026', namaSE: 'SI Perizinan Online', status: 'Disetujui', catatan: 'SE No. PSE/025/2026' }
            ];
            
            saveData();
            updateStats();
        }

        // Simpan data ke localStorage
        function saveData() {
            localStorage.setItem('seData', JSON.stringify(seData));
            localStorage.setItem('riwayatData', JSON.stringify(riwayatData));
        }

        // Update statistik dashboard
        function updateStats() {
            document.getElementById('totalSE').textContent = seData.length;
            document.getElementById('pendingSE').textContent = seData.filter(se => se.status === 'pending').length;
        }

        // Data Management
        let seData = [];
        let riwayatData = [];

        // Navigation Handler
        function initNavigation() {
            document.querySelectorAll('.sidebar-nav li').forEach(li => {
                li.addEventListener('click', () => {
                    document.querySelector('.sidebar-nav li.active')?.classList.remove('active');
                    li.classList.add('active');

                    document.querySelectorAll('.content').forEach(content => {
                        content.classList.remove('active');
                    });
                    document.getElementById(li.dataset.page).classList.add('active');

                    const titles = {
                        dashboard: 'Dashboard PSE',
                        pendaftaran: 'Pendaftaran Sistem Elektronik',
                        'list-se': 'List SE Terdaftar',
                        riwayat: 'Riwayat Pengajuan',
                        profil: 'Profil Pejabat',
                        panduan: 'Panduan Penggunaan'
                    };
                    const iconClass = li.querySelector('i').className.split(' ')[1];
                    document.getElementById('page-title').innerHTML = 
                        `<i class="fas fa-${iconClass}"></i> ${titles[li.dataset.page]}`;
                });
            });
        }

        // Table Renderers
        function renderSETable() {
            const tbody = document.getElementById('seTableBody');
            tbody.innerHTML = seData.map((se, index) => `
                <tr>
                    <td>${index + 1}</td>
                    <td>${se.namaSE}</td>
                    <td>${se.instansi}</td>
                    <td><span class="status ${se.kategori.toLowerCase()}">${se.kategori}</span></td>
                    <td>${se.tanggal}</td>
                    <td>
                        ${se.status === 'Disetujui' ? 
                            `<button class="btn btn-success btn-small" disabled><i class="fas fa-check"></i> Disetujui</button>` :
                            `
                            <button class="btn btn-primary btn-small approve-btn" data-id="${se.id}">
                                <i class="fas fa-check"></i> Setujui
                            </button>
                            <button class="btn btn-danger btn-small reject-btn" data-id="${se.id}">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                            `
                        }
                    </td>
                </tr>
            `).join('');

            document.querySelectorAll('.approve-btn').forEach(btn => {
                btn.addEventListener('click', handleApprove);
            });
            document.querySelectorAll('.reject-btn').forEach(btn => {
                btn.addEventListener('click', handleReject);
            });
        }

        function renderRiwayatTable() {
            const tbody = document.getElementById('riwayatTableBody');
            tbody.innerHTML = riwayatData.map(riwayat => `
                <tr>
                    <td>${riwayat.tanggal}</td>
                    <td>${riwayat.namaSE}</td>
                    <td><span class="status ${riwayat.status.toLowerCase()}">${riwayat.status}</span></td>
                    <td>${riwayat.catatan}</td>
                    <td>
                        ${riwayat.status === 'Disetujui' ? 
                            '<button class="btn btn-success btn-small"><i class="fas fa-download"></i> Download</button>' :
                            '<button class="btn btn-warning btn-small"><i class="fas fa-edit"></i> Edit</button>'
                        }
                    </td>
                </tr>
            `).join('');
        }

        // Event Handlers
        function handleApprove(e) {
            const id = parseInt(e.target.closest('.approve-btn').dataset.id);
            const seIndex = seData.findIndex(s => s.id === id);
            const se = seData[seIndex];
            
            if (se && se.status !== 'Disetujui') {
                se.status = 'Disetujui';
                se.noSE = `PSE/${String(se.id).padStart(3, '0')}/2026`;
                
                riwayatData.unshift({
                    tanggal: se.tanggal,
                    namaSE: se.namaSE,
                    status: 'Disetujui',
                    catatan: `SE No. ${se.noSE}`
                });
                
                saveData();
                renderSETable();
                renderRiwayatTable();
                updateStats();
                
                alert(`✅ "${se.namaSE}" \nBerhasil dipindahkan ke Riwayat Pengajuan!\nNo. SE: ${se.noSE}`);
            }
        }

        function handleReject(e) {
            const id = parseInt(e.target.closest('.reject-btn').dataset.id);
            const se = seData.find(s => s.id === id);
            
            if (se && se.status !== 'Disetujui') {
                const alasan = prompt('Masukkan alasan penolakan:');
                if (alasan) {
                    se.status = 'Ditolak';
                    
                    riwayatData.unshift({
                        tanggal: se.tanggal,
                        namaSE: se.namaSE,
                        status: 'Ditolak',
                        catatan: `Ditolak: ${alasan}`
                    });
                    
                    saveData();
                    renderSETable();
                    renderRiwayatTable();
                    updateStats();
                    
                    alert(`❌ "${se.namaSE}" ditolak!\nAlasan: ${alasan}\nTetap ada di List SE`);
                }
            }
        }

        // Form Handler
        function initForm() {
            document.getElementById('registrationForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                const today = new Date().toLocaleDateString('id-ID');
                
                const newSE = {
                    id: Math.max(...seData.map(s => s.id), 0) + 1,
                    namaSE: data.namaSE || 'Sistem Baru',
                    instansi: data.instansi || 'Pemerintah Kota Probolinggo',
                    kategori: data.kategoriSE || 'Pending',
                    tanggal: today,
                    status: 'pending',
                    noSE: ''
                };
                
                seData.unshift(newSE);
                saveData();
                renderSETable();
                updateStats();
                
                // Show success message TANPA menghapus form
                const container = document.getElementById('formContainer');
                const successMsg = `
                    <div class="form-submitted">
                        <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                        <h3>Pengajuan Berhasil!</h3>
                        <p>"${newSE.namaSE}" telah masuk ke <strong>List SE Terdaftar</strong><br>
                        Status: <span style="background: #ffc107; padding: 0.3rem 0.8rem; border-radius: 20px; font-weight: 600;">Menunggu Verifikasi</span></p>
                        <div style="margin-top: 1.5rem;">
                            <button onclick="resetForm()" class="btn btn-primary" style="margin-right: 1rem;">
                                <i class="fas fa-edit"></i> Ajukan Lagi
                            </button>
                            <button onclick="switchToListSE()" class="btn btn-success">
                                <i class="fas fa-list"></i> Lihat List SE
                            </button>
                        </div>
                    </div>
                `;
                container.innerHTML = successMsg;
            });
        }

        // Utility Functions
        function resetForm() {
            document.getElementById('formContainer').innerHTML = `
                <form id="registrationForm" class="form-box">
                    <!-- SEMUA FORM ELEMENTS SAMA SEPERTI AWAL -->
                    <div class="section-title">
                        <i class="fas fa-building-government"></i>
                        Identitas Instansi & Sistem
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-building"></i> Nama Instansi</label>
                            <input type="text" class="form-input" name="instansi" value="Pemerintah Kota Probolinggo" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-sitemap"></i> Unit Kerja</label>
                            <input type="text" class="form-input" name="unitKerja" placeholder="Diskominfo Kota Probolinggo" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-laptop-code"></i> Nama Sistem Elektronik</label>
                            <input type="text" class="form-input" name="namaSE" placeholder="SIPLADOK Probolinggo" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-tag"></i> Versi Sistem</label>
                            <input type="text" class="form-input" name="versi" placeholder="v2.1.0" required>
                        </div>
                    </div>
                    <div class="section-title">
                        <i class="fas fa-file-alt"></i>
                        Deskripsi & Klasifikasi
                    </div>
                    <div class="form-grid">
                        <div class="form-group" style="grid-column: 1/-1;">
                            <label class="form-label"><i class="fas fa-align-left"></i> Deskripsi Sistem</label>
                            <textarea class="form-textarea" name="deskripsi" placeholder="Jelaskan fungsi utama sistem..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-folder-open"></i> Kategori SE</label>
                            <select class="form-select" name="kategoriSE" required>
                                <option value="">Pilih Kategori</option>
                                <option>Publik</option>
                                <option>Internal</option>
                                <option>Terbatas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-lock"></i> Keamanan Data</label>
                            <select class="form-select" name="keamananData" required>
                                <option value="">Pilih Klasifikasi</option>
                                <option>Publik</option>
                                <option>Internal</option>
                                <option>RAHASIA</option>
                            </select>
                        </div>
                    </div>
                    <div class="checkbox-section">
                        <div class="section-title">
                            <i class="fas fa-check-double"></i> Pernyataan Kesanggupan
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="jaminan" name="jaminan" required>
                            <label for="jaminan">Menjamin keamanan sesuai PP 71/2019</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="sop" name="sop">
                            <label for="sop">SOP penanggulangan insiden tersedia</label>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button type="reset" class="btn" onclick="resetForm()" style="background: rgba(255,107,107,0.1); color: var(--danger-color); border: 2px solid rgba(255,107,107,0.3);">
                            <i class="fas fa-undo"></i> Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                        </button>
                    </div>
                </form>
            `;
            initForm(); // Re-attach event listener
        }

        function switchToListSE() {
            document.querySelector('.sidebar-nav li[data-page="list-se"]').click();
        }

        // Initialize App
        document.addEventListener('DOMContentLoaded', () => {
            loadData();
            initNavigation();
            initForm();
            renderSETable();
            renderRiwayatTable();
        });
    </script>
</body>
</html>