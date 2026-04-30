<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pendaftaran Sistem Elektronik PSE</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, Helvetica, sans-serif;
    background: #f4f6f9;
    color: #333;
    min-height: 100vh;
}

.wrapper {
    display: flex;
    min-height: 100vh;
}

/* SIDEBAR MULTI-FUNGSI */
.sidebar {
    width: 240px;
    background: #fff;
    border-right: 1px solid #e5e5e5;
    padding: 20px 15px;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
    z-index: 1000;
    transition: all 0.3s ease;
}

.sidebar h3 {
    margin: 0 0 30px;
    color: #0d6efd;
    font-size: 18px;
    font-weight: bold;
}

.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar li {
    padding: 12px 15px;
    font-size: 14px;
    color: #555;
    cursor: pointer;
    border-radius: 6px;
    margin-bottom: 5px;
    transition: all 0.3s ease;
    position: relative;
}

.sidebar li.active,
.sidebar li:hover {
    background: #e9f2ff;
    color: #0d6efd;
    transform: translateX(5px);
}

/* ICONS MULTI-FUNGSI */
.sidebar li::before {
    content: '';
    width: 4px;
    height: 4px;
    background: #0d6efd;
    border-radius: 50%;
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0;
    transition: all 0.3s ease;
}

.sidebar li.active::before,
.sidebar li:hover::before {
    opacity: 1;
}

/* MAIN CONTENT */
.main {
    margin-left: 240px;
    flex: 1;
    padding: 25px;
    transition: all 0.3s ease;
}

/* CONTENT CONTAINER */
.content-container {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    padding: 25px;
    max-width: 1400px;
    margin: 0 auto;
}

/* HEADER */
.topbar {
    background: #fff;
    padding: 15px 25px;
    border-radius: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.topbar h2 {
    margin: 0;
    font-size: 20px;
    color: #333;
}

.user {
    font-size: 14px;
    color: #666;
}

/* FORM GRID */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #555;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px 12px;
    font-size: 13px;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 90px;
}

.upload-group {
    display: flex;
    gap: 10px;
}

.upload-group select {
    flex: 1;
}

.upload-btn {
    background: #0d6efd;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.3s ease;
}

.upload-btn:hover {
    background: #0b5ed7;
    transform: translateY(-1px);
}

/* SECTION */
.section {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e5e5e5;
}

.section-title {
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 15px;
    color: #333;
}

.checkbox-list label {
    display: flex;
    align-items: flex-start;
    font-size: 13px;
    margin-bottom: 12px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.checkbox-list label:hover {
    background: #e9f2ff;
}

.checkbox-list input[type="checkbox"] {
    width: 16px;
    height: 16px;
    margin-right: 10px;
    margin-top: 2px;
    accent-color: #0d6efd;
}

/* BUTTONS */
.actions {
    margin-top: 30px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.btn-save,
.btn-reset {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-save {
    background: #0d6efd;
    color: #fff;
}

.btn-save:hover {
    background: #0b5ed7;
    transform: translateY(-1px);
}

.btn-reset {
    background: #fd7e14;
    color: #fff;
}

.btn-reset:hover {
    background: #e9730b;
    transform: translateY(-1px);
}

/* TABLE STYLES */
.filter-box {
    background: #fff;
    padding: 20px;
    border-radius: 6px;
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
    margin-bottom: 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.filter-box input,
.filter-box select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 13px;
    min-width: 200px;
    flex: 1;
}

.btn-search,
.btn-add {
    background: #0d6efd;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
}

.btn-add {
    background: #28a745;
    margin-left: auto;
}

.btn-search:hover,
.btn-add:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.table-box {
    background: #fff;
    border-radius: 6px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    overflow: hidden;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

thead {
    background: #f8f9fa;
}

th, td {
    padding: 12px 15px;
    border-bottom: 1px solid #e5e5e5;
    text-align: left;
}

th {
    font-weight: 600;
    color: #555;
}

tr:hover {
    background: #f9fbff;
}

.badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-green { background: #d4edda; color: #155724; }
.badge-red { background: #f8d7da; color: #721c24; }
.badge-blue { background: #d1ecf1; color: #0c5460; }
.badge-orange { background: #fff3cd; color: #856404; }

.icon-btn {
    background: #0d6efd;
    color: #fff;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.3s ease;
}

.icon-btn:hover {
    background: #0b5ed7;
    transform: translateY(-1px);
}

.table-footer {
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    color: #666;
    background: #fafbfc;
    border-top: 1px solid #e5e5e5;
}

.pagination button {
    padding: 6px 12px;
    border: 1px solid #ddd;
    background: #fff;
    cursor: pointer;
    border-radius: 4px;
    margin: 0 2px;
    transition: all 0.3s ease;
}

.pagination button:hover,
.pagination button.active {
    background: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
}

/* PAGE SECTIONS */
.page-section {
    display: none;
}

.page-section.active {
    display: block;
}

/* MOBILE RESPONSIVE */
.mobile-menu-btn {
    display: none;
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 2000;
    background: #fff;
    border: none;
    padding: 12px;
    border-radius: 6px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 999;
}

@media (max-width: 992px) {
    .sidebar {
        transform: translateX(-100%);
        position: fixed;
        z-index: 1500;
    }
    
    .sidebar.open {
        transform: translateX(0);
    }
    
    .main {
        margin-left: 0;
        padding: 20px;
        padding-top: 70px;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-box {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-box input,
    .filter-box select {
        min-width: auto;
        width: 100%;
    }
    
    .mobile-menu-btn {
        display: block;
    }
    
    .overlay.active {
        display: block;
    }
}

@media (max-width: 768px) {
    .topbar {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .actions {
        flex-direction: column;
    }
    
    .btn-save,
    .btn-reset {
        width: 100%;
    }
}
</style>
</head>
<body>

<!-- MOBILE MENU BUTTON -->
<button class="mobile-menu-btn" id="mobileMenuBtn">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="6" x2="21" y2="6"></line>
        <line x1="3" y1="12" x2="21" y2="12"></line>
        <line x1="3" y1="18" x2="21" y2="18"></line>
    </svg>
</button>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>

<div class="wrapper">

<!-- SIDEBAR MULTI-FUNGSI -->
<aside class="sidebar" id="sidebar">
    <h3>🖥️ PSE</h3>
    <ul>
        <li class="active" data-target="page-pendaftaran">
            📝 Pendaftaran SE
        </li>
        <li data-target="page-list">
            📋 List SE Terdaftar
        </li>
        <li data-target="page-riwayat">
            ⏰ Riwayat Pengajuan
        </li>
        <li data-target="page-profil">
            👤 Profil Pejabat
        </li>
        <li data-target="page-panduan">
            📖 Panduan Penggunaan
        </li>
        <li data-target="page-dashboard">
            📊 Dashboard
        </li>
        <li data-target="page-laporan">
            📈 Laporan
        </li>
        <li data-target="page-setting">
            ⚙️ Pengaturan
        </li>
    </ul>
</aside>

<!-- MAIN CONTENT -->
<main class="main">

<!-- PAGE: DASHBOARD (BARU) -->
<div class="content-container page-section" id="page-dashboard">
    <div class="topbar">
        <h2>📊 Dashboard</h2>
        <div class="user">FITRIANINGSIH</div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; text-align: center;">
            <div style="font-size: 36px; margin-bottom: 10px;">22</div>
            <div style="font-size: 14px; opacity: 0.9;">SE Terdaftar</div>
        </div>
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 25px; border-radius: 12px; text-align: center;">
            <div style="font-size: 36px; margin-bottom: 10px;">8</div>
            <div style="font-size: 14px; opacity: 0.9;">Pengajuan Aktif</div>
        </div>
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 25px; border-radius: 12px; text-align: center;">
            <div style="font-size: 36px; margin-bottom: 10px;">3</div>
            <div style="font-size: 14px; opacity: 0.9;">Dalam Proses</div>
        </div>
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 25px; border-radius: 12px; text-align: center;">
            <div style="font-size: 36px; margin-bottom: 10px;">100%</div>
            <div style="font-size: 14px; opacity: 0.9;">Kepatuhan</div>
        </div>
    </div>
</div>

<!-- PAGE: PENDAFTARAN (ACTIVE) -->
<div class="content-container page-section active" id="page-pendaftaran">
    <div class="topbar">
        <h2>📝 Pendaftaran Sistem Elektronik</h2>
        <div class="user">FITRIANINGSIH</div>
    </div>
    
    <form id="formPendaftaran">
        <div class="form-grid">
            <!-- KOLOM KIRI -->
            <div>
                <div class="form-group">
                    <label>Instansi</label>
                    <input type="text" placeholder="Pemerintah Kota Probolinggo" required>
                </div>
                <div class="form-group">
                    <label>Unit Kerja pemilik Sistem Elektronik</label>
                    <input type="text" placeholder="Contoh: Direktorat Jenderal Aplikasi Informatika">
                </div>
                <div class="form-group">
                    <label>Nama Sistem Elektronik</label>
                    <input type="text" placeholder="Contoh: Sistem Informasi Pelayanan Publik">
                </div>
                <div class="form-group">
                    <label>Versi Sistem Elektronik</label>
                    <input type="text" placeholder="Contoh: 2.5.1">
                </div>
                <div class="form-group">
                    <label>Bidang/Sektor Sistem Elektronik</label>
                    <select>
                        <option>--Pilih--</option>
                        <option>Pemerintahan</option>
                        <option>Pendidikan</option>
                        <option>Kesehatan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Narahubung Sistem Elektronik</label>
                    <input type="text" placeholder="Contoh: Budi Santoso">
                </div>
            </div>
            
            <!-- KOLOM KANAN -->
            <div>
                <div class="form-group">
                    <label>Deskripsi Singkat Fungsi dan Proses Bisnis</label>
                    <textarea placeholder="Contoh: Sistem ini digunakan untuk mengelola layanan publik secara elektronik..."></textarea>
                </div>
                <div class="form-group">
                    <label>Kategori Sistem Elektronik Berdasarkan Asas Risiko</label>
                    <div class="upload-group">
                        <select>
                            <option>--Pilih--</option>
                            <option>Rendah</option>
                            <option>Sedang</option>
                            <option>Tinggi</option>
                        </select>
                        <button type="button" class="upload-btn">⬆ Upload</button>
                    </div>
                </div>
                <div class="form-group">
                    <label>Klasifikasi Data Sesuai Risiko</label>
                    <div class="upload-group">
                        <select>
                            <option>--Pilih--</option>
                            <option>Publik</option>
                            <option>Internal</option>
                            <option>Rahasia</option>
                        </select>
                        <button type="button" class="upload-btn">⬆ Upload</button>
                    </div>
                </div>
                <div class="form-group">
                    <label>Keterangan Data Pribadi yang Diproses</label>
                    <input type="text" placeholder="Pilih Data Pribadi">
                </div>
                <div class="form-group">
                    <label>Lokasi Pengelolaan/Pemrosesan/Penyimpanan</label>
                    <select>
                        <option>--Pilih--</option>
                        <option>Dalam Negeri</option>
                        <option>Luar Negeri</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Penyelenggara Sistem Elektronik wajib melakukan:</div>
            <div class="checkbox-list">
                <label><input type="checkbox"> Memastikan keamanan informasi sesuai peraturan perundang-undangan</label>
                <label><input type="checkbox"> Menyediakan sistem pengamanan dan pencegahan gangguan</label>
                <label><input type="checkbox"> Melindungi Data Pribadi sesuai ketentuan</label>
                <label><input type="checkbox"> Melakukan uji kelayakan Sistem Elektronik</label>
                <label><input type="checkbox"> Menerapkan arsitektur SPBE nasional</label>
            </div>
        </div>
        
        <div class="actions">
            <button type="reset" class="btn-reset">Reset</button>
            <button type="submit" class="btn-save">Simpan Pengajuan</button>
        </div>
    </form>
</div>

<!-- PAGE: LIST SE TERDAFTAR -->
<div class="content-container page-section" id="page-list">
    <div class="topbar">
        <h2>📋 List SE Terdaftar</h2>
        <div class="user">FITRIANINGSIH</div>
    </div>
    
    <div class="filter-box">
        <input type="text" placeholder="🔍 Masukan Nama Sistem Elektronik">
        <input type="text" placeholder="🏢 Masukan Instansi">
        <select>
            <option>Semua Status</option>
            <option>Menunggu Penerbitan Sertifikat</option>
            <option>✅ Terbit</option>
        </select>
        <button class="btn-search">🔎 Cari</button>
        <button class="btn-add">➕ Tambah SE</button>
    </div>
    
    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>📋 Aksi</th>
                    <th>🏢 Nama Instansi / Unit Kerja</th>
                    <th>💻 Sistem Elektronik / Pejabat</th>
                    <th>📊 Status</th>
                    <th>📝 Keterangan</th>
                    <th>📅 Tanggal Terbit</th>
                    <th>🆔 No. Tanda Daftar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><button class="icon-btn">📄</button></td>
                    <td>Pemerintah Kota Probolinggo / RSUD dr. Mohamad Saleh</td>
                    <td>Website RSUD dr. Mohamad Saleh / FITRIANINGSIH</td>
                    <td><span class="badge badge-orange">⏳ Menunggu Sertifikat</span></td>
                    <td>Website RSUD dr Mohammad Saleh merupakan sistem elektronik pelayanan informasi rumah sakit.</td>
                    <td>06/02/2026</td>
                    <td>401</td>
                </tr>
                <tr>
                    <td><button class="icon-btn">📄</button></td>
                    <td>Pemerintah Kota Probolinggo / Dinas Kominfo</td>
                    <td>PORTAL EMAS / FITRIANINGSIH</td>
                    <td><span class="badge badge-green">✅ Terbit</span></td>
                    <td>Aplikasi PORTAL EMAS (Probolinggo Smart Digital Melayani Masyarakat).</td>
                    <td>31/01/2026</td>
                    <td>296</td>
                </tr>
            </tbody>
        </table>
        <div class="table-footer">
            <div>👁️ View 1 - 2 dari 22</div>
            <div class="pagination">
                <button>First</button>
                <button>Prev</button>
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button>Next</button>
                <button>Last</button>
            </div>
        </div>
    </div>
</div>

<!-- PAGE: RIWAYAT PENGAJUAN -->
<div class="content-container page-section" id="page-riwayat">
    <div class="topbar">
        <h2>⏰ Riwayat Pengajuan SE</h2>
        <div class="user">FITRIANINGSIH</div>
    </div>
    
    <div class="filter-box">
        <input type="text" placeholder="🔍 Nama Sistem Elektronik">
        <input type="text" placeholder="🏢 Instansi">
        <button class="btn-search">🔎 Cari</button>
        <button class="btn-add">➕ Daftar Baru</button>
    </div>
    
    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>📋 Aksi</th>
                    <th>📄 Jenis Pengajuan</th>
                    <th>📊 Status</th>
                    <th>💻 Nama SE</th>
                    <th>📅 Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><button class="icon-btn">📄</button></td>
                    <td><span class="badge badge-blue">📝 Pendaftaran</span></td>
                    <td><span class="badge badge-green">✅ Diterima</span></td>
                    <td>Website RSUD dr. Mohamad Saleh</td>
                    <td>06/02/2026 07:48</td>
                </tr>
                <tr>
                    <td><button class="icon-btn">📄</button></td>
                    <td><span class="badge badge-blue">📝 Pendaftaran</span></td>
                    <td><span class="badge badge-red">❌ Ditolak</span></td>
                    <td>PORTAL EMAS</td>
                    <td>29/01/2026 16:19</td>
                </tr>
            </tbody>
        </table>
        <div class="table-footer">
            <div>👁️ View 1 - 2 dari 8</div>
            <div class="pagination">
                <button>First</button>
                <button>Prev</button>
                <button class="active">1</button>
                <button>Next</button>
                <button>Last</button>
            </div>
        </div>
    </div>
</div>

<!-- PAGE: PROFIL PEJABAT -->
<div class="content-container page-section" id="page-profil">
    <div class="topbar">
        <h2>👤 Profil Pejabat</h2>
        <div class="user">FITRIANINGSIH</div>
    </div>
    <div style="padding: 20px; background: #f8f9fa; border-radius: 6px; margin-bottom: 20px;">
        Lengkapi data pejabat yang berwenang untuk menandatangani persetujuan PSE.
    </div>
    <form>
        <div class="form-grid">
            <div>
                <div class="form-group">
                    <label>👤 Nama Pejabat</label>
                    <input type="text" value="FITRIANINGSIH">
                </div>
                <div class="form-group">
                    <label>🆔 NIP/NIK</label>
                    <input type="text" value="197801011998031001">
                </div>
                <div class="form-group">
                    <label>💼 Jabatan</label>
                    <input type="text" value="Kepala Dinas">
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label>📍 Alamat Kantor</label>
                    <textarea placeholder="Jl. Raden Wijaya No. 45, Probolinggo">Jl. Raden Wijaya No. 45, Probolinggo</textarea>
                </div>
                <div class="form-group">
                    <label>📧 Email Resmi</label>
                    <input type="email" value="fitrianingseh@probolinggokota.go.id">
                </div>
                <div class="form-group">
                    <label>📞 No. Telepon</label>
                    <input type="tel" value="(0335) 421234">
                </div>
            </div>
        </div>
        <div class="actions">
            <button type="submit" class="btn-save">💾 Update Profil</button>
        </div>
    </form>
</div>

<!-- PAGE: PANDUAN -->
<div class="content-container page-section" id="page-panduan">
    <div class="topbar">
        <h2>📖 Panduan Penggunaan</h2>
        <div class="user">FITRIANINGSIH</div>
    </div>
    
    <div style="background: #d4edda; padding: 25px; border-radius: 12px; margin-bottom: 20px;">
        <h3 style="color: #155724; margin-bottom: 20px;">🚀 Langkah-langkah Pendaftaran PSE:</h3>
        <ol style="font-size: 14px; line-height: 1.8; padding-left: 25px;">
            <li>📝 Isi form lengkap di menu <strong>Pendaftaran Sistem Elektronik</strong></li>
            <li>⬆️ Upload dokumen asesmen risiko dan klasifikasi data</li>
            <li>✅ Centang semua pernyataan kepatuhan</li>
            <li>💾 Klik tombol <strong>Simpan</strong> untuk submit</li>
            <li>⏰ Monitor status di <strong>Riwayat Pengajuan</strong></li>
            <li>📋 Lihat daftar terdaftar di <strong>List SE Terdaftar</strong></li>
        </ol>
    </div>
    
    <div style="background: #d1ecf1; padding: 25px; border-radius: 12px;">
        <h3 style="color: #0c5460; margin-bottom: 20px;">📎 Dokumen yang Diperlukan:</h3>
        <ul style="font-size: 14px; line-height: 1.8; padding-left: 25px;">
            <li>📊 Dokumen asesmen risiko sistem elektronik</li>
            <li>🔒 Klasifikasi data yang diproses sistem</li>
            <li>👤 Profil pejabat penanggung jawab</li>
            <li>🏛️ Bukti kepatuhan arsitektur SPBE</li>
        </ul>
    </div>
</div>

<!-- PAGE: LAPORAN (BARU) -->
<div class="content-container page-section" id="page-laporan">
    <div class="topbar">
        <h2>📈 Laporan</h2>
        <div class="user">FITRIANINGSIH</div>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 25px;">
        <div style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 15px;">📊 Laporan Bulanan</h3>
            <select style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 6px;">
                <option>Februari 2026</option>
                <option>Januari 2026</option>
            </select>
            <button class="btn-save" style="width: 100%;">📥 Download PDF</button>
        </div>
        <div style="background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 15px;">📋 Laporan Tahunan</h3>
            <select style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 6px;">
                <option>2026</option>
                <option>2025</option>
            </select>
            <button class="btn-save" style="width: 100%;">📥 Download Excel</button>
        </div>
    </div>
</div>

<!-- PAGE: PENGATURAN (BARU) -->
<div class="content-container page-section" id="page-setting">
    <div class="topbar">
        <h2>⚙️ Pengaturan</h2>
        <div class="user">FITRIANINGSIH</div>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
        <div>
            <h3 style="margin-bottom: 20px; color: #333;">🔐 Keamanan Akun</h3>
            <div class="form-group">
                <label>Ubah Password</label>
                <input type="password" placeholder="Password Baru">
            </div>
            <button class="btn-save" style="width: 100%; margin-top: 10px;">🔒 Update Password</button>
        </div>
        <div>
            <h3 style="margin-bottom: 20px; color: #333;">🔔 Notifikasi</h3>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 15px;">
                <label style="display: flex; align-items: center; margin-bottom: 10px;">
                    <input type="checkbox" checked style="width: 18px; height: 18px; margin-right: 10px;"> 📧 Email Notifikasi
                </label>
                <label style="display: flex; align-items: center;">
                    <input type="checkbox" checked style="width: 18px; height: 18px; margin-right: 10px;"> 📱 SMS Notifikasi
                </label>
            </div>
            <button class="btn-save" style="width: 100%;">💾 Simpan Pengaturan</button>
        </div>
    </div>
</div>

</main>
</div>

<script>
// 🌟 MENU MULTI-FUNGSI SYSTEM
document.querySelectorAll('.sidebar li').forEach((item, index) => {
    item.addEventListener('click', function() {
        // Update active menu dengan animasi
        document.querySelectorAll('.sidebar li').forEach(li => li.classList.remove('active'));
        this.classList.add('active');
        
        // Switch page content dengan smooth transition
        const targetId = this.getAttribute('data-target');
        document.querySelectorAll('.page-section').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateX(20px)';
            section.classList.remove('active');
        });
        
        setTimeout(() => {
            const targetSection = document.getElementById(targetId);
            targetSection.classList.add('active');
            targetSection.style.opacity = '1';
            targetSection.style.transform = 'translateX(0)';
        }, 150);
        
        // Close mobile menu
        closeMobileMenu();
        
        // Custom sound effect (optional)
        if ('vibrate' in navigator) {
            navigator.vibrate(50);
        }
    });
});

// 📱 MOBILE MENU SYSTEM
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

mobileMenuBtn.addEventListener('click', () => {
    sidebar.classList.add('open');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
});

overlay.addEventListener('click', closeMobileMenu);

function closeMobileMenu() {
    sidebar.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

// ✅ FORM VALIDATION & SUBMISSION
document.getElementById('formPendaftaran').addEventListener('submit', function(e) {
    e.preventDefault();
    const checkboxes = document.querySelectorAll('#page-pendaftaran input[type="checkbox"]:checked');
    
    if (checkboxes.length !== 5) {
        alert('❌ Harap centang SEMUA (5) pernyataan kepatuhan!');
        return;
    }
    
    const btn = this.querySelector('.btn-save');
    const original = btn.innerHTML;
    btn.innerHTML = '⏳ Menyimpan...';
    btn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        alert('🎉 Pengajuan berhasil disimpan!\n\nCek status di menu "Riwayat Pengajuan"');
        btn.innerHTML = original;
        btn.disabled = false;
        this.reset();
    }, 2000);
});

// 🎯 BUTTON INTERACTIONS
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('upload-btn')) {
        e.target.textContent = '📤 Uploading...';
        setTimeout(() => {
            e.target.textContent = '⬆ Upload';
            alert('📎 File berhasil diupload!');
        }, 1500);
    }
    
    if (e.target.classList.contains('icon-btn')) {
        alert('📄 Detail lengkap akan muncul di modal!');
    }
    
    if (e.target.classList.contains('btn-search')) {
        alert('🔍 Mencari data...');
    }
    
    if (e.target.classList.contains('btn-add')) {
        alert('➕ Akan redirect ke form pendaftaran!');
    }
});

// ⌨️ KEYBOARD SHORTCUTS
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey || e.metaKey) {
        switch(e.key) {
            case '1':
                e.preventDefault();
                document.querySelector('li[data-target="page-pendaftaran"]').click();
                break;
            case '2':
                e.preventDefault();
                document.querySelector('li[data-target="page-list"]').click();
                break;
            case '3':
                e.preventDefault();
                document.querySelector('li[data-target="page-riwayat"]').click();
                break;
        }
    }
});

// 🎨 LOADING ANIMATION
window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});
</script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Sistem Elektronik PSE - Premium Edition</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --dark-gradient: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            --primary: #6366f1;
            --primary-light: rgba(99, 102, 241, 0.1);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #f0f2f5 0%, #e2e8f0 50%, #cbd5e1 100%);
            color: #1e293b;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
            z-index: -1;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR PREMIUM */
        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(40px);
            border-right: 1px solid var(--glass-border);
            padding: 2rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-xl);
            scrollbar-width: thin;
            scrollbar-color: rgba(99, 102, 241, 0.3) transparent;
        }

        .sidebar h3 {
            margin-bottom: 2.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.5rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid rgba(99, 102, 241, 0.2);
            text-shadow: 0 2px 10px rgba(99, 102, 241, 0.3);
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            padding: 1rem 1.25rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            border-radius: 16px;
            margin-bottom: 0.75rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.4s ease;
            border-radius: 0 4px 4px 0;
        }

        .sidebar li.active,
        .sidebar li:hover {
            background: var(--glass-bg);
            color: var(--primary);
            transform: translateX(8px);
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .sidebar li.active::before,
        .sidebar li:hover::before {
            transform: scaleX(1);
        }

        /* MAIN CONTENT */
        .main {
            margin-left: 280px;
            flex: 1;
            padding: 2rem;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .content-container {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: var(--shadow-xl);
            padding: 2.5rem;
            max-width: 1600px;
            margin: 0 auto;
            border: 1px solid var(--glass-border);
            position: relative;
            overflow: hidden;
        }

        .content-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            box-shadow: 0 2px 10px rgba(99, 102, 241, 0.4);
        }

        /* TOPBAR PREMIUM */
        .topbar {
            background: rgba(255, 255, 255, 0.8);
            padding: 1.5rem 2rem;
            border-radius: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            position: relative;
            overflow: hidden;
        }

        .topbar::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100%;
            background: var(--primary-gradient);
            opacity: 0.05;
        }

        .topbar h2 {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 800;
            background: var(--dark-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 1;
        }

        .user {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            background: var(--glass-bg);
            padding: 1rem 1.75rem;
            border-radius: 50px;
            box-shadow: var(--shadow-md);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* FORM ENHANCEMENTS */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: inherit;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15), var(--shadow-md);
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.95);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
        }

        .upload-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .upload-btn {
            background: var(--primary-gradient);
            color: #fff;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 16px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 700;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-lg);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .upload-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: var(--shadow-xl);
        }

        /* SECTION PREMIUM */
        .section {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
            position: relative;
        }

        .section::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--primary-gradient);
        }

        .section-title {
            font-weight: 800;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .checkbox-list label {
            display: flex;
            align-items: flex-start;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            box-shadow: var(--shadow-sm);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .checkbox-list label::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .checkbox-list label:hover {
            border-color: var(--primary);
            transform: translateX(12px);
            box-shadow: var(--shadow-lg);
        }

        .checkbox-list label:hover::before {
            opacity: 0.05;
        }

        .checkbox-list input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 1rem;
            margin-top: 0.125rem;
            accent-color: var(--primary);
            flex-shrink: 0;
            z-index: 1;
            position: relative;
        }

        /* BUTTONS PREMIUM */
        .actions {
            margin-top: 2.5rem;
            display: flex;
            gap: 1.25rem;
            justify-content: flex-end;
        }

        .btn-save,
        .btn-reset {
            padding: 1rem 2rem;
            border: none;
            border-radius: 16px;
            font-size: 0.875rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .btn-save {
            background: var(--success-gradient);
            color: #fff;
        }

        .btn-save:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: var(--shadow-xl);
        }

        .btn-reset {
            background: var(--warning-gradient);
            color: #fff;
        }

        .btn-reset:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: var(--shadow-xl);
        }

        /* DASHBOARD CARDS PREMIUM */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(30px);
            padding: 2.5rem;
            border-radius: 24px;
            text-align: center;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--glass-border);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .dashboard-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .dashboard-number {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 1rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }

        /* TABLE PREMIUM */
        .filter-box {
            background: rgba(255, 255, 255, 0.9);
            padding: 1.75rem;
            border-radius: 20px;
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
        }

        .filter-box input,
        .filter-box select {
            padding: 1rem 1.25rem;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            font-size: 0.875rem;
            min-width: 250px;
            flex: 1;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .btn-search,
        .btn-add {
            background: var(--primary-gradient);
            color: #fff;
            border: none;
            padding: 1rem 1.75rem;
            border-radius: 16px;
            cursor: pointer;
            font-weight: 800;
            box-shadow: var(--shadow-lg);
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-add {
            background: var(--success-gradient);
            margin-left: auto;
        }

        .btn-search:hover,
        .btn-add:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .table-box {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        thead {
            background: rgba(248, 250, 252, 0.8);
            backdrop-filter: blur(10px);
        }

        th, td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            font-weight: 800;
            color: #1e293b;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tr:hover {
            background: var(--primary-light);
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-green { background: var(--success-gradient); color: #fff; }
        .badge-red { background: var(--danger-gradient); color: #fff; }
        .badge-blue { background: linear-gradient(135deg, #3b82f6, #1e40af); color: #fff; }
        .badge-orange { background: var(--warning-gradient); color: #fff; }

        .icon-btn {
            background: var(--primary-gradient);
            color: #fff;
            border: none;
            padding: 0.875rem 1rem;
            border-radius: 12px;
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.4s ease;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .icon-btn:hover {
            transform: translateY(-3px) scale(1.08);
            box-shadow: var(--shadow-xl);
        }

        /* PAGE ANIMATIONS */
        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
            animation: slideInFromRight 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideInFromRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* MOBILE RESPONSIVE */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 2000;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            padding: 1.25rem;
            border-radius: 20px;
            cursor: pointer;
            box-shadow: var(--shadow-xl);
            backdrop-filter: blur(30px);
            transition: all 0.4s ease;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            z-index: 999;
        }

        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main {
                margin-left: 0;
                padding: 1.5rem;
                padding-top: 5rem;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .filter-box {
                flex-direction: column;
                align-items: stretch;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .overlay.active {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .topbar {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn-save,
            .btn-reset {
                width: 100%;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

        /* SCROLLBAR CUSTOM */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-gradient);
        }
    </style>
</head>
<body>

<!-- MOBILE MENU BUTTON -->
<button class="mobile-menu-btn" id="mobileMenuBtn" title="Buka Menu">
    <i class="fas fa-bars" style="font-size: 1.25rem;"></i>
</button>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>

<div class="wrapper">

<!-- SIDEBAR PREMIUM -->
<aside class="sidebar" id="sidebar">
    <h3><i class="fas fa-server"></i> PSE System</h3>
    <ul>
        <li class="active" data-target="page-pendaftaran">
            <i class="fas fa-file-signature"></i> Pendaftaran SE
        </li>
        <li data-target="page-list">
            <i class="fas fa-list-check"></i> List SE Terdaftar
        </li>
        <li data-target="page-riwayat">
            <i class="fas fa-clock-rotate"></i> Riwayat Pengajuan
        </li>
        <li data-target="page-profil">
            <i class="fas fa-user-tie"></i> Profil Pejabat
        </li>
        <li data-target="page-panduan">
            <i class="fas fa-book-open"></i> Panduan Penggunaan
        </li>
        <li data-target="page-dashboard">
            <i class="fas fa-gauge-high"></i> Dashboard
        </li>
        <li data-target="page-laporan">
            <i class="fas fa-chart-line-up"></i> Laporan
        </li>
        <li data-target="page-setting">
            <i class="fas fa-gear"></i> Pengaturan
        </li>
    </ul>
</aside>

<!-- MAIN CONTENT -->
<main class="main">

<!-- PAGE: DASHBOARD -->
<div class="content-container page-section" id="page-dashboard">
    <div class="topbar">
        <h2><i class="fas fa-gauge-high"></i> Dashboard Overview</h2>
        <div class="user">
            FITRIANINGSIH 
            <i class="fas fa-circle" style="color: var(--success); font-size: 0.625rem;"></i>
            Online
        </div>
    </div>
    
    <div class="dashboard-grid">
        <div class="dashboard-card">
            <div class="dashboard-number">22</div>
            <div style="font-size: 1.125rem; font-weight: 700; color: #64748b; margin-bottom: 0.25rem;">SE Terdaftar</div>
            <div style="font-size: 0.875rem; color: #94a3b8;">Total sistem elektronik terdaftar</div>
        </div>
        <div class="dashboard-card">
            <div class="dashboard-number" style="background: var(--secondary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">8</div>
            <div style="font-size: 1.125rem; font-weight: 700; color: #64748b; margin-bottom: 0.25rem;">Pengajuan Aktif</div>
            <div style="font-size: 0.875rem; color: #94a3b8;">Sedang dalam proses</div>
        </div>
        <div class="
