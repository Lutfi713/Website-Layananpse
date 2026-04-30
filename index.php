<?php
session_start();
include 'koneksi.php';
// Jika user sudah login, arahkan ke dashboard user
if (isset($_SESSION['user_id'])) {
    header("Location: user_dashboard.php");
    exit();
}

// ============================================
// STATISTIK REAL-TIME DARI DATABASE
// ============================================
$q_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM layanan_se");
$d_total = mysqli_fetch_assoc($q_total);
$stat_total = $d_total['total'];

$q_aktif = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM layanan_se WHERE status IN ('Terbit', 'Diterima', 'Aktif')");
$d_aktif = mysqli_fetch_assoc($q_aktif);
$stat_aktif = $d_aktif['total'];

$q_nonaktif = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM layanan_se WHERE status IN ('Ditolak', 'Dihapus', 'Non-aktif')");
$d_nonaktif = mysqli_fetch_assoc($q_nonaktif);
$stat_nonaktif = $d_nonaktif['total'];

// Hitung persentase kepatuhan (Aktif / Total * 100)
$stat_kepatuhan = $stat_total > 0 ? round(($stat_aktif / $stat_total) * 100, 1) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Portal PSE - DisKominfo Probolinggo</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
/* ============================================ */
/* SEMUA CSS ANDA TETAP SAMA - TIDAK DIUBAH */
/* ============================================ */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', 'Inter', sans-serif;
}

html {
    scroll-behavior: smooth;
}

body {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
    min-height: 100vh;
    color: #f1f5f9;
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
    animation: float 20s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(1deg); }
}

/* Font Awesome circle numbers fix */
.fa-1-circle:before, .fa-2-circle:before, .fa-3-circle:before, 
.fa-4-circle:before, .fa-5-circle:before, .fa-6-circle:before {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    content: "\f111";
}

.fa-1-circle:after, .fa-2-circle:after, .fa-3-circle:after,
.fa-4-circle:after, .fa-5-circle:after, .fa-6-circle:after {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    position: relative;
    left: -1.2em;
    color: white;
}

.fa-1-circle:after { content: "1"; }
.fa-2-circle:after { content: "2"; }
.fa-3-circle:after { content: "3"; }
.fa-4-circle:after { content: "4"; }
.fa-5-circle:after { content: "5"; }
.fa-6-circle:after { content: "6"; }

/* NAVBAR PREMIUM */
.navbar-wrapper {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 2000;
    padding: 1.5rem 0;
    backdrop-filter: blur(20px);
    background: rgba(255, 255, 255, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.navbar {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 1rem 2rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.app-wrapper {
    margin-top: 100px;
}

.nav-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

/* LOGO DIPERBESAR - dari 48px menjadi 64px */
.nav-left img {
    height: 64px;
    width: auto;
    filter: drop-shadow(0 4px 12px rgba(30, 64, 175, 0.4));
}

.nav-left span {
    font-size: 1.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.nav-menu {
    display: flex;
    gap: 1rem;
}

.nav-menu a {
    text-decoration: none;
    color: #334155;
    font-weight: 600;
    padding: 12px 20px;
    border-radius: 50px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.nav-menu a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.5s;
}

.nav-menu a:hover::before {
    left: 100%;
}

.nav-menu a.active,
.nav-menu a:hover {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 20px 40px rgba(30, 64, 175, 0.4);
}

.nav-right {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-login {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white !important;
    padding: 12px 24px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    border: 2px solid transparent;
}

.btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.6s;
}

.btn-login:hover::before {
    left: 100%;
}

.btn-login:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 25px 50px rgba(59, 130, 246, 0.5);
    border-color: rgba(255, 255, 255, 0.3);
}

.btn-logout {
    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
}

.btn-logout:hover {
    box-shadow: 0 25px 50px rgba(239, 68, 68, 0.5) !important;
}

/* WRAPPER LAYOUT BARU DENGAN SIDEBAR */
.app-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
    display: flex;
    gap: 2rem;
    transition: all 0.3s ease;
}

/* SIDEBAR MULTI-FUNGSI */
.sidebar {
    width: 280px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 2rem 1.5rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.2);
    height: calc(100vh - 4rem);
    position: fixed;
    top: 2rem;
    left: 2rem;
    z-index: 1000;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow-y: auto;
}

.sidebar.closed {
    transform: translateX(-120%);
}

.sidebar-toggle {
    display: none;
    position: fixed;
    top: 1rem;
    left: 1rem;
    z-index: 1100;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 10px;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

@media (max-width: 1024px) {
    .sidebar {
        transform: translateX(-120%);
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
    
    .sidebar-toggle {
        display: block;
    }
    
    .app-wrapper {
        margin-left: 0;
        width: 100%;
    }
}

/* Add padding to app-wrapper to account for fixed sidebar */
.app-wrapper {
    margin-left: 300px;
    width: calc(100% - 300px);
    max-width: none;
}

/* Sidebar Toggle Button for Desktop */
.sidebar-toggle-desktop {
    position: absolute;
    top: 1.5rem;
    right: -15px;
    background: #3b82f6;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: 2px solid white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    z-index: 1001;
}

.sidebar.closed + .app-wrapper {
    margin-left: 0;
    width: 100%;
}


.sidebar h3 {
    margin-bottom: 2rem;
    color: #1e40af;
    font-size: 1.3rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(59, 130, 246, 0.3);
}

.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar li {
    padding: 14px 18px;
    font-size: 0.95rem;
    color: #334155;
    cursor: pointer;
    border-radius: 12px;
    margin-bottom: 5px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 500;
}

.sidebar li i {
    width: 20px;
    color: #64748b;
    transition: all 0.3s ease;
}

.sidebar li.active,
.sidebar li:hover {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(30, 64, 175, 0.1));
    color: #1e40af;
    transform: translateX(5px);
}

.sidebar li.active i,
.sidebar li:hover i {
    color: #1e40af;
}

.sidebar li.active {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
}

.sidebar li.active i {
    color: white;
}

/* MAIN CONTENT */
.main-content {
    flex: 1;
    min-width: 0;
}

/* DASHBOARD CONTENT */
.dashboard-content {
    display: none;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 2.5rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.dashboard-content.active {
    display: block;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.dashboard-header h2 {
    font-size: 1.8rem;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 0;
    font-weight: 700;
}

.user-badge {
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* STATS CARDS */
.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card-dash {
    background: white;
    padding: 1.8rem;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border-left: 5px solid #3b82f6;
    transition: all 0.3s ease;
}

.stat-card-dash:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
}

.stat-card-dash h3 {
    font-size: 2rem;
    color: #1e40af;
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.stat-card-dash p {
    color: #64748b;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* FORM PENDAFTARAN SE - SESUAI GAMBAR */
.se-form-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    color: #1e293b;
}

.se-form-section h2 {
    font-size: 1.6rem;
    margin-bottom: 1.5rem;
    color: #1e40af;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 1rem;
}

.se-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1rem;
}

.se-form-group {
    margin-bottom: 1.2rem;
}

.se-form-group label {
    display: block;
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 0.4rem;
    font-size: 0.9rem;
}

.se-form-group input,
.se-form-group select,
.se-form-group textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: white;
    color: #0f172a;
}

.se-form-group input:focus,
.se-form-group select:focus,
.se-form-group textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.upload-group {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.upload-btn {
    background: #3b82f6;
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.upload-btn:hover {
    background: #1e40af;
}

.upload-btn-small {
    background: #f59e0b;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    margin-left: 5px;
}

.upload-btn-small:hover {
    background: #d97706;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    padding: 8px 12px;
    background: #f0f9ff;
    border-radius: 6px;
    border-left: 3px solid #3b82f6;
    font-size: 0.85rem;
    color: #1e293b;
}

.file-info i {
    color: #10b981;
    font-size: 1rem;
}

.file-info .file-name {
    flex: 1;
    font-weight: 500;
    word-break: break-all;
}

.file-info .file-size {
    color: #64748b;
    font-size: 0.8rem;
    margin-right: 10px;
}

.se-section-divider {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1e40af;
    margin: 1.5rem 0 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #3b82f6;
}

.checkbox-group {
    margin: 1.2rem 0;
    padding: 1.2rem;
    background: #f8fafc;
    border-radius: 12px;
}

.checkbox-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1rem;
    padding: 0.5rem;
    background: white;
    border-radius: 8px;
}

.checkbox-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 1rem;
    margin-top: 2px;
    accent-color: #3b82f6;
}

.checkbox-item label {
    color: #1e293b;
    font-size: 0.9rem;
    line-height: 1.5;
}

.se-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    flex-wrap: wrap;
    align-items: center;
}

.btn-se-secondary,
.btn-se-success,
.btn-se-draft,
.btn-se-load,
.btn-se-reset,
.btn-se-ajukan {
    padding: 12px 28px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
}

.btn-se-secondary {
    background: #f59e0b;
    color: white;
}

.btn-se-secondary:hover {
    background: #d97706;
}

.btn-se-success {
    background: #10b981;
    color: white;
}

.btn-se-success:hover {
    background: #059669;
}

.btn-se-draft {
    background: #64748b;
    color: white;
}

.btn-se-draft:hover {
    background: #475569;
}

.btn-se-load {
    background: #6366f1;
    color: white;
}

.btn-se-load:hover {
    background: #4f46e5;
}

.btn-se-reset {
    background: #ef4444;
    color: white;
}

.btn-se-reset:hover {
    background: #dc2626;
}

.btn-se-ajukan {
    background: #10b981;
    color: white;
    font-size: 1.1rem;
    padding: 14px 36px;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    animation: pulse 2s infinite;
}

.btn-se-ajukan:hover {
    background: #059669;
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.5);
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
    }
}

/* BUTTON STATUS UNTUK LIST DAN RIWAYAT */
.btn-status-group {
    display: flex;
    gap: 0.8rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.btn-status {
    padding: 8px 16px;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-status i {
    font-size: 0.9rem;
}

.btn-status-primary {
    background: #3b82f6;
    color: white;
}

.btn-status-primary:hover {
    background: #1e40af;
}

.btn-status-success {
    background: #10b981;
    color: white;
}

.btn-status-success:hover {
    background: #059669;
}

.btn-status-danger {
    background: #ef4444;
    color: white;
}

.btn-status-danger:hover {
    background: #dc2626;
}

.btn-status-warning {
    background: #f59e0b;
    color: white;
}

.btn-status-warning:hover {
    background: #d97706;
}

.btn-status-info {
    background: #6366f1;
    color: white;
}

.btn-status-info:hover {
    background: #4f46e5;
}

.btn-status-secondary {
    background: #64748b;
    color: white;
}

.btn-status-secondary:hover {
    background: #475569;
}

/* TABLE STYLES */
.filter-box {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.filter-box input,
.filter-box select {
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 0.9rem;
    min-width: 200px;
    flex: 1;
}

.btn-search,
.btn-add {
    background: #3b82f6;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-search:hover,
.btn-add:hover {
    background: #1e40af;
}

.btn-add {
    background: #10b981;
}

.btn-add:hover {
    background: #059669;
}

.table-box {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    overflow: hidden;
}

.table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}

.table thead {
    background: #f8fafc;
}

.table th {
    padding: 1rem 1.2rem;
    text-align: left;
    font-weight: 700;
    color: #1e293b;
    border-bottom: 2px solid #e2e8f0;
}

.table td {
    padding: 1rem 1.2rem;
    border-bottom: 1px solid #e2e8f0;
    color: #334155;
}

.table tr:hover {
    background: #f1f5f9;
}

.badge {
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    display: inline-block;
}

.badge-green { background: #d4edda; color: #155724; }
.badge-red { background: #f8d7da; color: #721c24; }
.badge-blue { background: #d1ecf1; color: #0c5460; }
.badge-orange { background: #fff3cd; color: #856404; }
.badge-purple { background: #e9d8fd; color: #553c9a; }

.icon-btn {
    background: #3b82f6;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.icon-btn:hover {
    background: #1e40af;
}

.icon-btn-danger {
    background: #ef4444;
}

.icon-btn-danger:hover {
    background: #dc2626;
}

.icon-btn-success {
    background: #10b981;
}

.icon-btn-success:hover {
    background: #059669;
}

.icon-btn-warning {
    background: #f59e0b;
}

.icon-btn-warning:hover {
    background: #d97706;
}

.icon-btn-secondary {
    background: #64748b;
}

.icon-btn-secondary:hover {
    background: #475569;
}

.table-footer {
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    color: #64748b;
    background: #fafbfc;
    border-top: 1px solid #e2e8f0;
}

.pagination button {
    padding: 6px 12px;
    border: 1px solid #cbd5e1;
    background: white;
    cursor: pointer;
    border-radius: 6px;
    margin: 0 2px;
    transition: all 0.3s ease;
}

.pagination button:hover,
.pagination button.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

/* PROFIL PEJABAT */
.profil-card {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    display: flex;
    gap: 2rem;
    align-items: center;
    margin-bottom: 2rem;
}

.profil-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 700;
}

.profil-info h3 {
    font-size: 1.5rem;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.profil-info p {
    color: #64748b;
    margin-bottom: 0.3rem;
}

/* PANDUAN PENGGUNA - DIPERJELAS */
.panduan-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.panduan-card h3 {
    color: #1e40af;
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 1rem;
}

.panduan-card h3 i {
    font-size: 1.6rem;
}

.panduan-card h4 {
    color: #0f172a;
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
}

.panduan-card p {
    color: #475569;
    font-size: 0.9rem;
    line-height: 1.5;
}

/* LAPORAN & PENGATURAN */
.setting-group {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.setting-group h3 {
    color: #1e293b;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

/* MOBILE MENU */
.mobile-menu-btn {
    display: none;
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 2000;
    background: white;
    border: none;
    padding: 12px;
    border-radius: 12px;
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
    z-index: 1499;
}

.overlay.active {
    display: block;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .app-wrapper {
        flex-direction: column;
        padding: 1rem;
    }
    
    .sidebar {
        width: 100%;
        position: fixed;
        left: -100%;
        top: 0;
        height: 100vh;
        z-index: 1500;
        transition: left 0.3s ease;
        border-radius: 0;
    }
    
    .sidebar.open {
        left: 0;
    }
    
    .mobile-menu-btn {
        display: block;
    }
    
    .navbar {
        flex-direction: column;
        gap: 1rem;
    }
    
    .nav-menu {
        display: none;
    }
}

@media (max-width: 768px) {
    .se-form-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-box {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-box input,
    .filter-box select {
        min-width: auto;
    }
    
    .se-actions {
        flex-direction: column;
    }
    
    .profil-card {
        flex-direction: column;
        text-align: center;
    }
    
    .btn-status-group {
        flex-direction: column;
    }
}

/* AUTH MODAL */
.auth-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(20px);
    justify-content: center;
    align-items: center;
    z-index: 4000;
}

.auth-box {
    display: flex;
    background: white;
    padding: 0;
    border-radius: 24px;
    width: 1000px; /* Lebar ditambah untuk split layout */
    max-width: 95vw;
    position: relative;
    box-shadow: 0 50px 100px rgba(0, 0, 0, 0.4);
    overflow: hidden;
    min-height: 600px;
}

.auth-left {
    flex: 0 0 40%;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    padding: 3rem 2rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: white;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.auth-left::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: url('https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_Kota_Probolinggo_%282010%29.png/387px-Logo_Kota_Probolinggo_%282010%29.png') no-repeat center center;
    background-size: 150%;
    opacity: 0.1;
}

.auth-left img {
    height: 150px; /* Diperbesar dari 120px */
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 1;
    filter: brightness(0) invert(1) drop-shadow(0 5px 15px rgba(0,0,0,0.2)); /* Logo jadi putih */
}

.auth-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    position: relative;
    max-height: 90vh;
    overflow: hidden; /* Container utama tidak scroll */
}

.auth-right-header {
    padding: 2rem 3rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    z-index: 10;
    flex-shrink: 0;
}

.auth-right-header h2 {
    margin: 0;
    color: #1e40af;
    font-size: 1.8rem;
    font-weight: 700;
}

.auth-right-content {
    padding: 1.25rem 3rem 2rem;
    overflow-y: auto;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center; /* Membuat konten (login form) berada di tengah vertikal */
}

/* Khusus form register, karena panjang, kita biarkan start dari atas */
.register-form.active {
    margin-top: 1.25rem;
    margin-bottom: auto; /* Agar tidak dipaksa ke tengah jika panjang */
}

.close-btn {
    font-size: 2.5rem;
    cursor: pointer;
    color: #64748b;
    line-height: 0.8;
    transition: 0.2s;
}
.close-btn:hover { color: #ef4444; }

.auth-right-content::-webkit-scrollbar {
    width: 6px;
}
.auth-right-content::-webkit-scrollbar-track {
    background: #f1f5f9;
}
.auth-right-content::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.auth-box h2 {
    margin-bottom: 1.5rem;
    color: #1e40af;
    font-size: 1.8rem;
    font-weight: 700;
}

.auth-box input,
.auth-box select {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 1rem;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.input-group,
.password-wrapper {
    position: relative;
}

.password-group {
    margin-bottom: 1rem;
}

.password-group input {
    margin-bottom: 0;
}

.password-wrapper {
    margin-bottom: 1rem;
}

.password-wrapper input {
    margin-bottom: 0;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #64748b;
    cursor: pointer;
    width: 34px;
    height: 34px;
    padding: 0;
    border-radius: 10px;
    transition: 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
}

.password-toggle:hover {
    color: #f97316;
    background: #fff7ed;
    border-color: #fdba74;
    transform: translateY(-50%);
}

.password-toggle:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.18);
}

.auth-box input:focus,
.auth-box select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.auth-box button {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    font-weight: 700;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.auth-box .password-toggle {
    width: 34px;
    height: 34px;
    padding: 0;
    background: transparent;
    border: none;
    box-shadow: none;
}

.auth-box .password-toggle:hover {
    transform: translateY(-50%);
}

.auth-box button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
}

.auth-box button.password-toggle:hover {
    transform: translateY(-50%);
    box-shadow: none;
}

.auth-box button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.close {
    position: absolute;
    top: 1.5rem;
    right: 2rem;
    cursor: pointer;
    font-size: 1.5rem;
    color: #94a3b8;
    transition: all 0.3s ease;
}

.close:hover {
    color: #ef4444;
}

.login-form,
.register-form,
.forgot-password-form,
.reset-password-form {
    display: none;
}

.login-form.active,
.register-form.active,
.forgot-password-form.active,
.reset-password-form.active {
    display: block;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-row-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 0.8rem;
}

.switch {
    margin-top: 1rem;
    font-size: 0.9rem;
    color: #64748b;
    text-align: center;
}

.switch span {
    color: #3b82f6;
    cursor: pointer;
    font-weight: 700;
    transition: all 0.3s ease;
}

.switch span:hover {
    color: #1e40af;
    text-decoration: underline;
}

.password-requirements {
    font-size: 0.8rem;
    color: #64748b;
    margin-top: -0.5rem;
    margin-bottom: 1rem;
    padding: 0.5rem;
    background: #f8fafc;
    border-radius: 8px;
}

.password-requirements ul {
    list-style: none;
    padding: 0.5rem 0 0 0;
    margin: 0;
}

.password-requirements li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.3rem;
    font-size: 0.8rem;
}

.password-requirements li i {
    width: 16px;
    font-size: 0.8rem;
}

.password-requirements li.valid {
    color: #10b981;
}

.password-requirements li.invalid {
    color: #ef4444;
}

.reset-link {
    text-align: right;
    margin-top: -0.5rem;
    margin-bottom: 1rem;
}

.reset-link span {
    color: #3b82f6;
    font-size: 0.85rem;
    cursor: pointer;
    font-weight: 600;
}

.reset-link span:hover {
    color: #1e40af;
    text-decoration: underline;
}

/* Info box untuk verifikasi */
.info-box-small {
    background: #f0f9ff;
    border-left: 4px solid #3b82f6;
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 8px;
    font-size: 0.9rem;
    color: #1e293b;
}

.info-box-small i {
    color: #3b82f6;
    margin-right: 8px;
}

.otp-input {
    letter-spacing: 8px;
    font-size: 1.5rem;
    font-weight: 700;
    text-align: center;
}

.timer {
    font-weight: 600;
    color: #ef4444;
}

/* ============================================ */
/* MODAL SERTIFIKAT PREMIUM - TAMBAHAN BARU */
/* ============================================ */
.sertifikat-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(10px);
    justify-content: center;
    align-items: center;
    z-index: 5000;
    padding: 2rem;
}

.sertifikat-box {
    background: #fef9e7;
    border-radius: 40px;
    width: 900px;
    max-width: 95vw;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 50px 100px rgba(0, 0, 0, 0.5), 0 0 0 2px #d4af37, 0 0 0 5px #fef9e7;
    animation: slideUp 0.5s ease;
    background-image: 
        radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 30%),
        radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 30%),
        repeating-linear-gradient(45deg, rgba(212, 175, 55, 0.05) 0px, rgba(212, 175, 55, 0.05) 2px, transparent 2px, transparent 8px);
    border: 1px solid #d4af37;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.sertifikat-header {
    background: linear-gradient(135deg, #8b6912, #d4af37, #8b6912);
    color: white;
    padding: 2rem 2.5rem;
    border-radius: 40px 40px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    border-bottom: 3px solid #fff3cd;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.sertifikat-header::before {
    content: '';
    position: absolute;
    top: 10px;
    left: 10px;
    right: 10px;
    bottom: 0;
    background: repeating-linear-gradient(45deg, rgba(255,255,255,0.1) 0px, rgba(255,255,255,0.1) 5px, transparent 5px, transparent 10px);
    border-radius: 40px 40px 0 0;
    pointer-events: none;
}

.sertifikat-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    font-weight: 900;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 1rem;
    letter-spacing: 2px;
}

.sertifikat-header h2 i {
    font-size: 2.5rem;
    filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));
}

.sertifikat-close {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid white;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(5px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.sertifikat-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg) scale(1.1);
    border-color: #d4af37;
}

.sertifikat-body {
    padding: 2.5rem;
}

.sertifikat-border {
    border: 3px solid #d4af37;
    border-radius: 30px;
    padding: 2rem;
    position: relative;
    background: white;
    box-shadow: inset 0 0 30px rgba(212, 175, 55, 0.2);
}

.sertifikat-border::before {
    content: '';
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    background: linear-gradient(135deg, #d4af37, #fff3cd, #d4af37);
    border-radius: 40px;
    z-index: -1;
    opacity: 0.5;
}

.sertifikat-border::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><path d="M10,10 L90,10 L90,90 L10,90 Z" fill="none" stroke="%23d4af37" stroke-width="1" stroke-dasharray="5,5"/></svg>');
    background-size: 40px 40px;
    opacity: 0.1;
    pointer-events: none;
}

.sertifikat-logo {
    text-align: center;
    margin-bottom: 1.5rem;
    position: relative;
}

.sertifikat-logo img {
    height: 90px;
    width: auto;
    filter: drop-shadow(0 6px 12px rgba(212, 175, 55, 0.4));
}

.sertifikat-garuda {
    font-size: 4rem;
    color: #8b6912;
    margin: 0.5rem 0;
    text-shadow: 2px 2px 4px rgba(212, 175, 55, 0.3);
}

.sertifikat-title {
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
}

.sertifikat-title h3 {
    font-family: 'Playfair Display', serif;
    color: #8b6912;
    font-size: 2rem;
    font-weight: 900;
    margin-bottom: 0.5rem;
    letter-spacing: 4px;
    text-transform: uppercase;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.sertifikat-title p {
    color: #666;
    font-size: 1.1rem;
    text-transform: uppercase;
    letter-spacing: 3px;
    font-weight: 500;
}

.sertifikat-title hr {
    width: 200px;
    margin: 1rem auto;
    border: none;
    height: 2px;
    background: linear-gradient(90deg, transparent, #d4af37, transparent);
}

.sertifikat-nomor {
    text-align: center;
    margin-bottom: 2rem;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #fef9e7, #fff3cd);
    border-radius: 50px;
    display: inline-block;
    width: auto;
    margin-left: auto;
    margin-right: auto;
    border: 2px solid #d4af37;
    box-shadow: 0 6px 12px rgba(212, 175, 55, 0.2);
}

.sertifikat-nomor span {
    font-size: 1.4rem;
    font-weight: 900;
    color: #8b6912;
    letter-spacing: 3px;
    font-family: 'Playfair Display', serif;
}

.sertifikat-content {
    margin: 2rem 0;
    text-align: center;
}

.sertifikat-content p {
    color: #333;
    font-size: 1.2rem;
    line-height: 1.8;
    font-style: italic;
}

.sertifikat-content strong {
    color: #8b6912;
    font-size: 1.5rem;
    font-weight: 900;
    font-style: normal;
    font-family: 'Playfair Display', serif;
}

.sertifikat-detail {
    background: linear-gradient(135deg, #fef9e7, #fff);
    border-radius: 20px;
    padding: 2rem;
    margin: 2rem 0;
    border: 2px solid #d4af37;
    box-shadow: 0 10px 20px rgba(212, 175, 55, 0.15);
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.sertifikat-detail-item {
    display: flex;
    flex-direction: column;
    padding: 0.8rem;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 12px;
    border-left: 4px solid #d4af37;
}

.sertifikat-detail-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #8b6912;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.3rem;
}

.sertifikat-detail-value {
    font-size: 1rem;
    color: #0f172a;
    font-weight: 700;
    word-break: break-word;
}

.sertifikat-footer {
    margin-top: 2.5rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    position: relative;
}

.sertifikat-footer-left {
    text-align: left;
}

.sertifikat-footer-left p {
    color: #666;
    font-size: 0.95rem;
    margin-bottom: 0.5rem;
}

.sertifikat-footer-left h4 {
    font-family: 'Playfair Display', serif;
    color: #8b6912;
    font-size: 1.3rem;
    font-weight: 700;
    margin-top: 1rem;
    border-bottom: 2px solid #d4af37;
    display: inline-block;
    padding-bottom: 0.3rem;
}

.sertifikat-footer-right {
    text-align: right;
    background: #fef9e7;
    padding: 1rem 1.5rem;
    border-radius: 20px;
    border: 2px solid #d4af37;
}

.sertifikat-qr {
    text-align: center;
    margin-bottom: 0.5rem;
}

.sertifikat-qr i {
    font-size: 5rem;
    color: #8b6912;
    opacity: 0.8;
    filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.2));
}

.sertifikat-qr p {
    font-size: 0.8rem;
    color: #666;
    letter-spacing: 1px;
}

.sertifikat-stamp {
    position: absolute;
    bottom: 20px;
    right: 20px;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, #d4af37 0%, #8b6912 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    font-weight: 900;
    transform: rotate(-15deg);
    opacity: 0.9;
    border: 3px solid white;
    box-shadow: 0 0 0 3px #d4af37;
    font-family: 'Playfair Display', serif;
    text-transform: uppercase;
}

.sertifikat-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px dashed #d4af37;
}

.btn-sertifikat {
    padding: 14px 28px;
    border: none;
    border-radius: 50px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    font-size: 1rem;
    letter-spacing: 1px;
}

.btn-sertifikat-primary {
    background: linear-gradient(135deg, #8b6912, #d4af37);
    color: white;
    box-shadow: 0 8px 16px rgba(212, 175, 55, 0.3);
}

.btn-sertifikat-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(212, 175, 55, 0.5);
}

.btn-sertifikat-secondary {
    background: white;
    color: #8b6912;
    border: 2px solid #d4af37;
}

.btn-sertifikat-secondary:hover {
    background: #fef9e7;
    transform: translateY(-3px);
}

/* ============================================ */
/* FONT RAPI UNTUK HALAMAN 1 (PUBLIC WRAPPER) */
/* ============================================ */

/* Halaman Public - Perapihan Font */
#publicWrapper {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 0 2rem;
}

#publicWrapper .content {
    display: none;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: 32px;
    padding: 3rem 2.5rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
    margin-bottom: 2rem;
}

#publicWrapper .content.active {
    display: block;
    animation: fadeIn 0.5s ease;
}

/* Hero Section */
#publicWrapper .hero {
    text-align: center;
    max-width: 800px;
    margin: 0 auto 3rem;
}

#publicWrapper .hero h1 {
    font-size: 3.2rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, #ffffff, #e2e8f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: -0.02em;
}

#publicWrapper .hero p {
    font-size: 1.25rem;
    line-height: 1.7;
    color: #cbd5e1;
    margin-bottom: 2rem;
    font-weight: 400;
}

/* Stats Grid */
#publicWrapper .stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin-top: 3rem;
}

#publicWrapper .stat-card {
    background: rgba(255, 255, 255, 0.1);
    padding: 2rem;
    border-radius: 24px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

#publicWrapper .stat-card:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-5px);
}

#publicWrapper .stat-card h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #3b82f6, #60a5fa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

#publicWrapper .stat-card p {
    font-size: 1rem;
    font-weight: 500;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Card Style untuk halaman public */
#publicWrapper .card {
    background: rgba(255, 255, 255, 0.1);
    padding: 2.5rem;
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

#publicWrapper .card h3 {
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 1.8rem;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

#publicWrapper .card h3 i {
    color: #3b82f6;
    font-size: 2rem;
}

#publicWrapper .card p {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #e2e8f0;
}

/* Steps Grid */
#publicWrapper .steps-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-top: 1.5rem;
}

#publicWrapper .step-card {
    background: rgba(255, 255, 255, 0.1);
    padding: 2rem;
    border-radius: 20px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

#publicWrapper .step-card:hover {
    background: rgba(59, 130, 246, 0.15);
    border-color: #3b82f6;
}

#publicWrapper .step-number {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 auto 1rem;
}

#publicWrapper .step-card h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
    margin-top: 1rem;
}

/* Table di halaman public */
#publicWrapper .table {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    overflow: hidden;
}

#publicWrapper .table th {
    color: white;
    font-weight: 600;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    padding: 1.2rem;
}

#publicWrapper .table td {
    color: #e2e8f0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 1.2rem;
}

#publicWrapper .badge-success {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.3);
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.8rem;
}

/* Chart container */
#publicWrapper canvas {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    padding: 1rem;
    margin-top: 1rem;
}

/* Responsive untuk public wrapper */
@media (max-width: 768px) {
    #publicWrapper .hero h1 {
        font-size: 2.2rem;
    }
    
    #publicWrapper .hero p {
        font-size: 1rem;
    }
    
    #publicWrapper .stats-grid {
        grid-template-columns: 1fr;
    }
    
    #publicWrapper .steps-grid {
        grid-template-columns: 1fr;
    }
    
    #publicWrapper .content {
        padding: 2rem 1.5rem;
    }
}

/* ============================================ */
/* AKHIR PERAPIHAN FONT HALAMAN 1 */
/* ============================================ */

/* Info Box untuk data kosong */
.info-box {
    text-align: center;
    padding: 3rem;
    background: #f8fafc;
    border-radius: 12px;
    color: #64748b;
}

.info-box i {
    font-size: 3rem;
    color: #3b82f6;
    margin-bottom: 1rem;
}

.info-box h4 {
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.info-box p {
    margin-bottom: 1.5rem;
}

.info-box .btn-add {
    display: inline-block;
    padding: 10px 24px;
}

/* Tambahan CSS untuk button status aktif */
.btn-status.active {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    border: 2px solid white;
}
.btn-status-primary.active {
    background: #1e40af;
}
.btn-status-success.active {
    background: #059669;
}
.btn-status-danger.active {
    background: #dc2626;
}
.btn-status-warning.active {
    background: #d97706;
}
.btn-status-info.active {
    background: #4f46e5;
}
.btn-status-secondary.active {
    background: #475569;
}

/* CSS TAMBAHAN UNTUK MEMPERJELAS TULISAN PADA CARD PORTAL */
.panduan-card .portal-url {
    font-size: 2.2rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.panduan-card .social-media-badge {
    background: #eef2ff;
    padding: 8px 18px;
    border-radius: 50px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #1e40af;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2);
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.panduan-card .tagar-container {
    background: linear-gradient(145deg, #ffffff, #f8fafc);
    padding: 1.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

.panduan-card .tagar-title {
    font-weight: 700;
    margin-bottom: 1rem;
    font-size: 1.2rem;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.panduan-card .tagar-item {
    background: #ffffff;
    padding: 8px 18px;
    border-radius: 50px;
    font-size: 0.95rem;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
    color: #1e40af;
    transition: all 0.3s ease;
}

.panduan-card .tagar-item:hover {
    background: #1e40af;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(30, 64, 175, 0.2);
}

/* CSS untuk validasi tanpa pesan error */
.nip-input-error, .email-input-error {
    border-color: #ef4444 !important;
}

.nip-valid, .email-valid {
    border-color: #10b981 !important;
}

/* Sembunyikan semua pesan error */
/* CSS KHUSUS HALAMAN PUBLIK */
#publicWrapper {
    display: block !important;
}
</style>
</head>
<body>

<!-- MOBILE MENU BUTTON -->
<button class="mobile-menu-btn" id="mobileMenuBtn">
    <i class="fas fa-bars" style="font-size: 24px; color: #1e40af;"></i>
</button>

<!-- OVERLAY -->
<div class="overlay" id="overlay"></div>

<!-- NAVBAR - LOGO SUDAH DIPERBESAR MENJADI 64px -->
<div class="navbar-wrapper">
<div class="navbar">
    <div class="nav-left">
        <img src="Logo Diskominfo Solusi.png" alt="Logo DisKominfo Probolinggo" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2264%22 height=%2264%22 viewBox=%220 0 48 48%22><rect width=%2248%22 height=%2248%22 fill=%22%233b82f6%22 rx=%2212%22/><text x=%2224%22 y=%2232%22 font-size=%2220%22 font-weight=%22bold%22 text-anchor=%22middle%22 fill=%22white%22>PSE</text></svg>'">
        <span>PSE DisKominfo</span>
    </div>

    <div class="nav-menu">
        <a href="#" class="active" data-page="beranda"><i class="fas fa-home"></i> Beranda</a>
        <a href="#" data-page="cari"><i class="fas fa-search"></i> Cari</a>
        <a href="#" data-page="tentang"><i class="fas fa-info-circle"></i> Tentang</a>
        <a href="#" data-page="panduan"><i class="fas fa-book"></i> Panduan</a>
        <a href="#" data-page="statistik"><i class="fas fa-chart-bar"></i> Statistik</a>
    </div>

    <div class="nav-right">
        <a href="#" class="btn-login" id="loginBtn" onclick="showAuth('login')">Masuk / Daftar</a>
    </div>
</div>
</div>

<!-- CONTENT WRAPPER UTAMA - DASHBOARD DIHAPUS DARI HALAMAN PUBLIK -->
<!--
<button class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<div class="app-wrapper" id="appWrapper" style="display: none;">
    ...
</div>
-->

<!-- HALAMAN PUBLIC (BERANDA, CARI, TENTANG, PANDUAN, STATISTIK) -->
<div class="content-wrapper" id="publicWrapper" style="padding-top: 120px;">
    <!-- BERANDA -->
    <section id="beranda" class="content active">
        <div class="hero">
            <h1>Portal Penyelenggara Sistem Elektronik</h1>
            <p>Daftar PSE Anda dan patuhi regulasi Kominfo Kota Probolinggo dengan mudah dan cepat</p>
            <a href="#" class="btn-login" style="font-size:1.2rem;padding:18px 36px;" onclick="showAuth('login')">
                <i class="fas fa-rocket"></i> Mulai Pendaftaran
            </a>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <h2>10.000+</h2>
                <p>PSE Terdaftar</p>
            </div>
            <div class="stat-card">
                <h2>98%</h2>
                <p>Tingkat Kepatuhan</p>
            </div>
            <div class="stat-card">
                <h2>36</h2>
                <p>Perlu Update</p>
            </div>
        </div>
        
        <div style="margin-top: 3rem; display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem;">
            <div style="background: rgba(255,255,255,0.05); padding: 2rem; border-radius: 20px; text-align: center;">
                <i class="fas fa-shield-alt" style="font-size: 3rem; color: #3b82f6; margin-bottom: 1rem;"></i>
                <h3 style="color: white; margin-bottom: 0.5rem;">Terdaftar Resmi</h3>
                <p style="color: #94a3b8;">Terdaftar di Kominfo RI</p>
            </div>
            <div style="background: rgba(255,255,255,0.05); padding: 2rem; border-radius: 20px; text-align: center;">
                <i class="fas fa-bolt" style="font-size: 3rem; color: #f59e0b; margin-bottom: 1rem;"></i>
                <h3 style="color: white; margin-bottom: 0.5rem;">Proses Cepat</h3>
                <p style="color: #94a3b8;">Verifikasi 3x24 jam</p>
            </div>
            <div style="background: rgba(255,255,255,0.05); padding: 2rem; border-radius: 20px; text-align: center;">
                <i class="fas fa-phone-alt" style="font-size: 3rem; color: #10b981; margin-bottom: 1rem;"></i>
                <h3 style="color: white; margin-bottom: 0.5rem;">Bantuan 24/7</h3>
                <p style="color: #94a3b8;">CS: (0335) 421234</p>
            </div>
        </div>
    </section>

    <!-- CARI PSE -->
    <section id="cari" class="content">
        <div class="card">
            <h3><i class="fas fa-search"></i> Cari PSE Terdaftar</h3>
            
            <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
                <input type="text" id="cariPublicInput" placeholder="Masukkan nama PSE atau instansi..." style="flex: 1; padding: 1rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.05); color: white;">
                <button onclick="cariPublicPSE()" style="padding: 1rem 2rem; background: #3b82f6; border: none; border-radius: 12px; color: white; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
            
            <div class="table-container">
                <table class="table" id="publicCariTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama PSE</th>
                            <th>Instansi</th>
                            <th>Status</th>
                            <th>Terdaftar</th>
                            <th>No. Tanda Daftar</th>
                        </tr>
                    </thead>
                    <tbody id="publicCariBody">
                        <tr><td>1</td><td>SP4N-Lapor Probolinggo</td><td>Diskominfo</td><td><span class="badge badge-success">Aktif</span></td><td>10 Feb 2026</td><td>PSE-001/2026</td></tr>
                        <tr><td>2</td><td>SIMDA Kepegawaian</td><td>BKD</td><td><span class="badge badge-success">Aktif</span></td><td>15 Jan 2026</td><td>PSE-045/2026</td></tr>
                        <tr><td>3</td><td>SIPD Probolinggo</td><td>Bappeda</td><td><span class="badge badge-success">Aktif</span></td><td>20 Des 2025</td><td>PSE-089/2025</td></tr>
                        <tr><td>4</td><td>E-Puskesmas</td><td>Dinkes</td><td><span class="badge badge-success">Aktif</span></td><td>5 Feb 2026</td><td>PSE-012/2026</td></tr>
                        <tr><td>5</td><td>SIMPEG Kota</td><td>BKPSDM</td><td><span class="badge badge-success">Aktif</span></td><td>12 Jan 2026</td><td>PSE-056/2026</td></tr>
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 2rem; text-align: center; color: #94a3b8;">
                <i class="fas fa-info-circle"></i> Total 125 PSE terdaftar â€¢ Terakhir diperbarui: 13 Februari 2026
            </div>
        </div>
    </section>

    <!-- TENTANG -->
    <section id="tentang" class="content">
        <div class="card">
            <h3><i class="fas fa-info-circle"></i> Tentang Portal PSE</h3>
            <p style="color: #e2e8f0; line-height: 1.8; font-size: 1.1rem; margin-bottom: 2rem;">
                Penyelenggara Sistem Elektronik (PSE) wajib terdaftar sesuai Permenkominfo No. 5 Tahun 2020. 
                Portal ini merupakan layanan resmi Diskominfo Kota Probolinggo untuk memudahkan pendaftaran, 
                verifikasi, dan monitoring kepatuhan PSE.
            </p>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <h4 style="color: white; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-gavel" style="color: #3b82f6;"></i> Dasar Hukum
                    </h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">Permenkominfo No. 5 Tahun 2020</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">UU No. 11 Tahun 2008 (ITE)</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">UU No. 27 Tahun 2022 (PDP)</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">Perwal Probolinggo No. 12/2023</li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: white; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-building" style="color: #3b82f6;"></i> Pengelola
                    </h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;"> Dinas Komunikasi dan Informatika</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">Bidang Aplikasi Informatika</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;"> Seksi Tata Kelola PSE</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;"> Jl. Dr. Moch. Saleh No.5, Kecamatan Kanigaran, Kota Probolinggo</li>
                    </ul>
                </div>
            </div>
            
            <div style="background: rgba(59, 130, 246, 0.1); padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(59,130,246,0.3);">
                <h4 style="color: white; margin-bottom: 1rem;">Visi & Misi</h4>
                <p style="color: #e2e8f0; margin-bottom: 0.5rem;">
                    <strong>Visi:</strong> Mewujudkan tata kelola Sistem Elektronik yang transparan, akuntabel, dan berkelanjutan.
                </p>
                <p style="color: #e2e8f0;">
                    <strong>Misi:</strong> Memfasilitasi pendaftaran PSE, meningkatkan kepatuhan, dan mengoptimalkan layanan digital.
                </p>
            </div>
        </div>
    </section>

    <!-- PANDUAN LENGKAP PUBLIC -->
    <section id="panduan" class="content">
        <div class="card" style="padding: 2.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-book" style="font-size: 2rem; color: white;"></i>
                </div>
                <h3 style="color: white; font-size: 2rem; font-weight: 700; margin: 0;">Panduan Lengkap Pendaftaran PSE</h3>
            </div>
            
            <!-- QUICK ACCESS -->
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 3rem; justify-content: center;">
                <a href="#persiapan" style="background: rgba(59, 130, 246, 0.2); color: white; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; border: 1px solid rgba(59, 130, 246, 0.3); transition: all 0.3s;">
                    <i class="fas fa-box"></i> Persiapan
                </a>
                <a href="#alur" style="background: rgba(59, 130, 246, 0.2); color: white; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; border: 1px solid rgba(59, 130, 246, 0.3); transition: all 0.3s;">
                    <i class="fas fa-diagram-project"></i> Alur Pendaftaran
                </a>
                <a href="#dokumen" style="background: rgba(59, 130, 246, 0.2); color: white; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; border: 1px solid rgba(59, 130, 246, 0.3); transition: all 0.3s;">
                    <i class="fas fa-file-alt"></i> Dokumen
                </a>
                <a href="#faq" style="background: rgba(59, 130, 246, 0.2); color: white; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; border: 1px solid rgba(59, 130, 246, 0.3); transition: all 0.3s;">
                    <i class="fas fa-question-circle"></i> FAQ
                </a>
                <a href="#video" style="background: rgba(59, 130, 246, 0.2); color: white; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; border: 1px solid rgba(59, 130, 246, 0.3); transition: all 0.3s;">
                    <i class="fas fa-video"></i> Video
                </a>
            </div>

            <!-- PERSIAPAN -->
            <div id="persiapan" style="margin-bottom: 3rem; scroll-margin-top: 2rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-box" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h4 style="color: white; font-size: 1.8rem; font-weight: 600; margin: 0;">Persiapan Sebelum Mendaftar</h4>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                    <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fas fa-building" style="font-size: 2rem; color: #3b82f6; margin-bottom: 1rem;"></i>
                        <h5 style="color: white; font-size: 1.2rem; margin-bottom: 1rem;">Data Instansi</h5>
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ Nama lengkap instansi</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ Alamat kantor pusat</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ NIP/NIK penanggung jawab</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ SK pengangkatan pejabat</li>
                        </ul>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fas fa-server" style="font-size: 2rem; color: #10b981; margin-bottom: 1rem;"></i>
                        <h5 style="color: white; font-size: 1.2rem; margin-bottom: 1rem;">Data Sistem Elektronik</h5>
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ Nama dan versi sistem</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ URL/domain aktif</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ IP server/lokasi hosting</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ Deskripsi fungsi sistem</li>
                        </ul>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fas fa-shield" style="font-size: 2rem; color: #f59e0b; margin-bottom: 1rem;"></i>
                        <h5 style="color: white; font-size: 1.2rem; margin-bottom: 1rem;">Dokumen Keamanan</h5>
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ Hasil asesmen risiko</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ Klasifikasi data</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ Kebijakan keamanan</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">âœ“ SOP penanganan insiden</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- ALUR PENDAFTARAN -->
            <div id="alur" style="margin-bottom: 3rem; scroll-margin-top: 2rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-diagram-project" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h4 style="color: white; font-size: 1.8rem; font-weight: 600; margin: 0;">Alur Pendaftaran PSE</h4>
                </div>

                <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 1rem; margin-bottom: 2rem;">
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">1</span>
                        </div>
                        <h5 style="color: white;">Login</h5>
                    </div>
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">2</span>
                        </div>
                        <h5 style="color: white;">Isi Form</h5>
                    </div>
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">3</span>
                        </div>
                        <h5 style="color: white;">Upload</h5>
                    </div>
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">4</span>
                        </div>
                        <h5 style="color: white;">Verifikasi</h5>
                    </div>
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">5</span>
                        </div>
                        <h5 style="color: white;">Terbit</h5>
                    </div>
                    <div style="text-align: center;">
                        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <span style="color: white; font-size: 1.5rem; font-weight: 700;">6</span>
                        </div>
                        <h5 style="color: white;">Monitoring</h5>
                    </div>
                </div>
            </div>

            <!-- DOKUMEN -->
            <div id="dokumen" style="margin-bottom: 3rem; scroll-margin-top: 2rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-alt" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h4 style="color: white; font-size: 1.8rem; font-weight: 600; margin: 0;">Dokumen yang Diperlukan</h4>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                    <div style="background: rgba(255,255,255,0.1); border-radius: 20px; padding: 2rem;">
                        <h5 style="color: white; font-size: 1.2rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-exclamation-circle" style="color: #ef4444;"></i> Dokumen Wajib
                        </h5>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                                <i class="fas fa-check-circle" style="color: #10b981;"></i> Profil instansi/unit kerja
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                                <i class="fas fa-check-circle" style="color: #10b981;"></i> Dokumen asesmen risiko
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                                <i class="fas fa-check-circle" style="color: #10b981;"></i> Klasifikasi data
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                                <i class="fas fa-check-circle" style="color: #10b981;"></i> Profil pejabat penanggung jawab
                            </div>
                        </div>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); border-radius: 20px; padding: 2rem;">
                        <h5 style="color: white; font-size: 1.2rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-info-circle" style="color: #3b82f6;"></i> Dokumen Pendukung
                        </h5>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div style="display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                                <i class="fas fa-check" style="color: #94a3b8;"></i> SK Kepala Daerah/Pejabat
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                                <i class="fas fa-check" style="color: #94a3b8;"></i> Bukti kepatuhan arsitektur SPBE
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                                <i class="fas fa-check" style="color: #94a3b8;"></i> Sertifikat keamanan (jika ada)
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem; background: rgba(255,255,255,0.05); border-radius: 8px;">
                                <i class="fas fa-check" style="color: #94a3b8;"></i> Rekomendasi teknis
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="unduh-pdf" style="margin-bottom: 3rem; scroll-margin-top: 2rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3b82f6, #1e40af); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-download" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h4 style="color: white; font-size: 1.8rem; font-weight: 600; margin: 0;">Unduh Dokumen Panduan (PDF)</h4>
                </div>

                <div style="background: rgba(255,255,255,0.08); border-radius: 20px; padding: 2rem; border: 1px solid rgba(255,255,255,0.1);">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 1rem;">
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=JUKNIS%20PSE%20PUBLIK%20KOMDIGI.pdf&nd=1772155683552" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">1. JUKNIS PSE PUBLIK KOMDIGI</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=JUKNIS%20KLASIFIKASI%20DATA%20SE.pdf&nd=1772155775845" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">2. JUKNIS KLASIFIKASI DATA SE</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20KATEGORI%20SISTEM%20ELEKTRONIK.pdf&nd=1772155810386" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">3. FORMAT KATEGORI SISTEM ELEKTRONIK</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=20251106%20SOP%20Pendaftaran%20PSE%20Lingkup%20Publik.pdf&nd=1772155829764" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">4. SOP PENDAFTARAN PSE LINGKUP PUBLIK</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20TUGAS%20PEJABAT%20PENDAFTAR%20PSE%20LINGKUP%20PUBLIK%20YANG%20BERASAL%20DARI%20INSTITUSI.pdf&nd=1772155849038" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">5. FORMAT SURAT TUGAS PEJABAT (INSTITUSI)</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20TUGAS%20PEJABAT%20PENDAFTAR%20PSE%20LINGKUP%20PUBLIK%20YANG%20BERASAL%20DARI%20INSTANSI.pdf&nd=1772155874761" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">6. FORMAT SURAT TUGAS PEJABAT (INSTANSI)</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20PERMOHONAN%20PEMUTUSAN%20AKSES%20OLEH%20KEMENTERIAN_LEMBAGA%20APARAT%20PENEGAK%20HUKUM%20DAN_ATAU%20LEMBAGA%20PERADILAN.pdf&nd=1772155898246" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">7. FORMAT SURAT PEMUTUSAN AKSES (K/L/APH)</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20PERMOHONAN%20PEMUTUSAN%20AKSES%20OLEH%20MASYARAKAT.pdf&nd=1772155921852" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">8. FORMAT SURAT PEMUTUSAN AKSES (MASYARAKAT)</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20PERMOHONAN%20NORMALISASI%20SISTEM%20ELEKTRONIK%20LINGKUP%20PUBLIK%20INSTANSI%20DAN%20INSTITUSI.pdf&nd=1772155943551" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">9. FORMAT SURAT PERMOHONAN NORMALISASI SE</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20KETERANGAN%20SISTEM%20ELEKTRONIK%20TIDAK%20DIGUNAKAN.pdf&nd=1772155965780" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">10. FORMAT SURAT KETERANGAN SE TIDAK DIGUNAKAN</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=Kepmen%20Kominfo%20519%202024%20Ekosistem%20PDN.pdf&nd=1772155989153" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">11. KEPMEN KOMINFO 519 2024 (EKOSISTEM PDN)</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=PP%2071%202019%20PSTE.pdf&nd=1772156009620" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">12. PP 71 2019 PSTE</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=PM%20Komdigi%205%202025%20PSE%20Lingkup%20Publik.pdf&nd=1772156061201" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">13. PM KOMDIGI 5 2025 PSE LINGKUP PUBLIK</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=UU%2019%202016%20Perubahan%20ITE.pdf&nd=1772156084421" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">14. UU 19 2016 PERUBAHAN ITE</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=UU%201%202024%20Perubahan%20Kedua%20ITE.pdf&nd=1772156116490" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">15. UU 1 2024 PERUBAHAN KEDUA ITE</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                        <a href="https://pse.layanan.go.id/api/downloadguide?fileName=UU%2011%202008%20ITE.pdf&nd=1772156134201" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; gap: 0.9rem; padding: 0.9rem 1rem; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; color: white; text-decoration: none; transition: all 0.2s;">
                            <span style="width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: rgba(239,68,68,0.18); color: #fecaca;"><i class="fas fa-file-pdf"></i></span>
                            <span style="flex: 1; font-weight: 600;">16. UU 11 2008 ITE</span>
                            <i class="fas fa-arrow-down" style="color: #93c5fd;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- FAQ -->
            <div id="faq" style="margin-bottom: 3rem; scroll-margin-top: 2rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #8b5cf6, #6d28d9); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-question-circle" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h4 style="color: white; font-size: 1.8rem; font-weight: 600; margin: 0;">Frequently Asked Questions</h4>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                    <div style="background: rgba(255,255,255,0.1); border-radius: 16px; padding: 1.5rem;">
                        <h5 style="color: white; font-weight: 600; margin-bottom: 0.8rem;">Berapa lama proses pendaftaran?</h5>
                        <p style="color: #e2e8f0;">Verifikasi dokumen maksimal 3x24 jam kerja setelah pengajuan lengkap.</p>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); border-radius: 16px; padding: 1.5rem;">
                        <h5 style="color: white; font-weight: 600; margin-bottom: 0.8rem;">Apakah pendaftaran dipungut biaya?</h5>
                        <p style="color: #e2e8f0;">Tidak, pendaftaran PSE di lingkungan Pemkot Probolinggo GRATIS.</p>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); border-radius: 16px; padding: 1.5rem;">
                        <h5 style="color: white; font-weight: 600; margin-bottom: 0.8rem;">Format dokumen yang diterima?</h5>
                        <p style="color: #e2e8f0;">PDF, DOC/DOCX, XLS/XLSX, JPG, PNG dengan maksimal ukuran file 100MB per dokumen.</p>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); border-radius: 16px; padding: 1.5rem;">
                        <h5 style="color: white; font-weight: 600; margin-bottom: 0.8rem;">Masa berlaku TDPSE?</h5>
                        <p style="color: #e2e8f0;">Tanda Daftar PSE berlaku selama 5 tahun dan dapat diperpanjang.</p>
                    </div>
                </div>
            </div>

          

            <!-- TOMBOL AKSI -->
            <div style="display: flex; gap: 1.5rem; justify-content: center; margin-top: 3rem;">
                <a href="#" onclick="showAuth('login'); return false;" style="background: linear-gradient(135deg, #3b82f6, #1e40af); color: white; padding: 16px 36px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.8rem;">
                    <i class="fas fa-rocket"></i> Mulai Pendaftaran
                </a>
                <a href="#unduh-pdf" style="background: rgba(255,255,255,0.1); color: white; padding: 16px 36px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.8rem; border: 1px solid rgba(255,255,255,0.2);">
                    <i class="fas fa-download"></i> Download Panduan PDF
                </a>
            </div>

            <!-- CONTACT HELP -->
            <div style="margin-top: 2rem; padding: 1.5rem; background: rgba(255,255,255,0.05); border-radius: 16px; text-align: center;">
                <p style="color: #e2e8f0;">
                    <i class="fas fa-headset" style="color: #3b82f6;"></i> 
                    Butuh bantuan? Hubungi Helpdesk PSE: 
                    <strong style="color: white;">(0335) 421234</strong> atau 
                    <strong style="color: white;">pse@probolinggokota.go.id</strong>
                </p>
                <p style="color: #94a3b8; margin-top: 0.5rem; font-size: 0.9rem;">
                    <i class="fas fa-clock"></i> Senin - Jumat, 08.00 - 16.00 WIB
                </p>
            </div>
        </div>
    </section>

    <!-- STATISTIK -->
    <section id="statistik" class="content">
        <div class="card">
            <h3><i class="fas fa-chart-bar"></i> Statistik PSE Kota Probolinggo</h3>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <canvas id="pseChart" height="250"></canvas>
                </div>
                <div style="display: flex; flex-direction: column; justify-content: center;">
                    <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; margin-bottom: 1rem;">
                        <h4 style="color: white; margin-bottom: 1rem;">Ringkasan Statistik</h4>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                            <div>
                                <p style="color: #94a3b8;">Total PSE</p>
                                <p style="color: white; font-size: 1.8rem; font-weight: 700;"><?php echo $stat_total; ?></p>
                            </div>
                            <div>
                                <p style="color: #94a3b8;">Aktif</p>
                                <p style="color: #10b981; font-size: 1.8rem; font-weight: 700;"><?php echo $stat_aktif; ?></p>
                            </div>
                            <div>
                                <p style="color: #94a3b8;">Non-aktif</p>
                                <p style="color: #ef4444; font-size: 1.8rem; font-weight: 700;"><?php echo $stat_nonaktif; ?></p>
                            </div>
                            <div>
                                <p style="color: #94a3b8;">Kepatuhan</p>
                                <p style="color: #3b82f6; font-size: 1.8rem; font-weight: 700;"><?php echo $stat_kepatuhan; ?>%</p>
                            </div>
                        </div>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px;">
                        <h4 style="color: white; margin-bottom: 1rem;">Statistik per Sektor</h4>
                        <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span style="color: white; width: 120px;">Pemerintahan</span>
                                <div style="flex: 1; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px;">
                                    <div style="width: 65%; height: 100%; background: #3b82f6; border-radius: 4px;"></div>
                                </div>
                                <span style="color: white; min-width: 50px;">65%</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span style="color: white; width: 120px;">Pendidikan</span>
                                <div style="flex: 1; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px;">
                                    <div style="width: 45%; height: 100%; background: #10b981; border-radius: 4px;"></div>
                                </div>
                                <span style="color: white; min-width: 50px;">45%</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <span style="color: white; width: 120px;">Kesehatan</span>
                                <div style="flex: 1; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px;">
                                    <div style="width: 30%; height: 100%; background: #f59e0b; border-radius: 4px;"></div>
                                </div>
                                <span style="color: white; min-width: 50px;">30%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <p style="color: #94a3b8;">
                    <i class="fas fa-chart-line"></i> Data diperbarui setiap hari â€¢ Update terakhir: 13 Februari 2026
                </p>
            </div>
        </div>
    </section>
</div>

<!-- MODAL SERTIFIKAT PREMIUM -->
<div id="sertifikatModal" class="sertifikat-modal">
    <div class="sertifikat-box">
        <div class="sertifikat-header">
            <h2>
                <i class="fas fa-certificate"></i> 
                TANDA DAFTAR PSE
            </h2>
            <button class="sertifikat-close" onclick="tutupSertifikat()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="sertifikat-body">
            <div class="sertifikat-border">
                <div class="sertifikat-logo">
                    <div class="sertifikat-garuda">
                        <i class="fas fa-crown"></i>
                    </div>
                    <img src="Logo Diskominfo Solusi.png" alt="Logo" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2290%22 height=%2290%22 viewBox=%220 0 48 48%22><rect width=%2248%22 height=%2248%22 fill=%22%23d4af37%22 rx=%2212%22/><text x=%2224%22 y=%2232%22 font-size=%2220%22 font-weight=%22bold%22 text-anchor=%22middle%22 fill=%22white%22>PSE</text></svg>'">
                </div>
                
                <div class="sertifikat-title">
                    <h3>KEMENTERIAN KOMUNIKASI DAN DIGITAL</h3>
                    <p>REPUBLIK INDONESIA</p>
                    <hr>
                </div>
                
                <div class="sertifikat-nomor">
                    <span id="sertifikatNomor">PSE-200/2026</span>
                </div>
                
                <div class="sertifikat-content">
                    <p>Dengan ini menyatakan bahwa:</p>
                    <p><strong id="sertifikatNamaInstansi">PEMERINTAH KOTA PROBOLINGGO</strong></p>
                    <p>Telah terdaftar sebagai Penyelenggara Sistem Elektronik dengan:</p>
                </div>
                
                <div class="sertifikat-detail">
                    <div class="sertifikat-detail-item">
                        <span class="sertifikat-detail-label">Nama Instansi</span>
                        <span class="sertifikat-detail-value" id="sertifikatInstansi">-</span>
                    </div>
                    <div class="sertifikat-detail-item">
                        <span class="sertifikat-detail-label">Unit Kerja</span>
                        <span class="sertifikat-detail-value" id="sertifikatUnitKerja">-</span>
                    </div>
                    <div class="sertifikat-detail-item">
                        <span class="sertifikat-detail-label">Sistem Elektronik</span>
                        <span class="sertifikat-detail-value" id="sertifikatNamaSE">-</span>
                    </div>
                    <div class="sertifikat-detail-item">
                        <span class="sertifikat-detail-label">Versi</span>
                        <span class="sertifikat-detail-value" id="sertifikatVersi">-</span>
                    </div>
                    <div class="sertifikat-detail-item">
                        <span class="sertifikat-detail-label">Pejabat Penanggung Jawab</span>
                        <span class="sertifikat-detail-value" id="sertifikatPejabat">-</span>
                    </div>
                    <div class="sertifikat-detail-item">
                        <span class="sertifikat-detail-label">Tanggal Terbit</span>
                        <span class="sertifikat-detail-value" id="sertifikatTanggal">-</span>
                    </div>
                    <div class="sertifikat-detail-item">
                        <span class="sertifikat-detail-label">Masa Berlaku</span>
                        <span class="sertifikat-detail-value" id="sertifikatMasaBerlaku">-</span>
                    </div>
                    <div class="sertifikat-detail-item">
                        <span class="sertifikat-detail-label">Kategori Risiko</span>
                        <span class="sertifikat-detail-value" id="sertifikatRisiko">-</span>
                    </div>
                    <div class="sertifikat-detail-item">
                        <span class="sertifikat-detail-label">Klasifikasi Data</span>
                        <span class="sertifikat-detail-value" id="sertifikatKlasifikasi">-</span>
                    </div>
                    <div class="sertifikat-detail-item">
                        <span class="sertifikat-detail-label">Lokasi Penyimpanan</span>
                        <span class="sertifikat-detail-value" id="sertifikatLokasi">-</span>
                    </div>
                </div>
                
                <div class="sertifikat-footer">
                    <div class="sertifikat-footer-left">
                        <p>Dikeluarkan di Kota Probolinggo</p>
                        <p>pada tanggal <span id="sertifikatJakartaTanggal">19 Februari 2026</span></p>
                        <br>
                        <p>Direktur Diskominfo</p>
                        <p>Penyelenggaraan Sistem Elektronik</p>
                        <br>
                        <h4>FITRIANINGSIH.S.Kom.</h4>
                        <p>NIP. 196812121998031001</p>
                    </div>
                    <div class="sertifikat-footer-right">
                        <div class="sertifikat-qr">
                            <i class="fas fa-qrcode"></i>
                            <p>scan untuk verifikasi</p>
                        </div>
                    </div>
                </div>
                
                <div class="sertifikat-stamp">
                    <div style="transform: rotate(-15deg);">
                        <i class="fas fa-certificate"></i>
                    </div>
                </div>
            </div>
            
            <div class="sertifikat-actions">
                <button class="btn-sertifikat btn-sertifikat-secondary" onclick="cetakSertifikat()">
                    <i class="fas fa-print"></i> CETAK
                </button>
                <button class="btn-sertifikat btn-sertifikat-primary" onclick="downloadSertifikat()">
                    <i class="fas fa-download"></i> UNDUH PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- LOGIN/REGISTER MODAL -->
<div id="authModal" class="auth-modal">
<div class="auth-box">
    <!-- LEFT SIDE: LOGO & BRANDING -->
    <div class="auth-left">
        <img src="Logo Diskominfo Solusi.png" alt="Logo PSE">
        <h3>PSE Diskominfo</h3>
        <p>Sistem Pendaftaran Penyelenggara Sistem Elektronik<br>Lingkup Pemerintah Kota Probolinggo</p>
        <div style="margin-top: auto; font-size: 0.8rem; opacity: 0.7;">
            &copy; 2026 Diskominfo
        </div>
    </div>

    <!-- RIGHT SIDE: FORMS -->
    <div class="auth-right">
        <div class="auth-right-header">
            <h2 id="authTitle">Login Dashboard</h2>
            <div class="close-btn" onclick="closeAuth()">&times;</div>
        </div>
        
        <div class="auth-right-content">
            <!-- LOGIN FORM -->
            <form id="loginForm" class="login-form active" action="login.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user" style="position: absolute; margin: 15px; color: #94a3b8;"></i>
                <input type="text" name="username" id="loginUsername" placeholder="Username / Email" required style="padding-left: 40px;">
            </div>
            <div class="input-group password-group">
                <i class="fas fa-lock" style="position: absolute; margin: 15px; color: #94a3b8;"></i>
                <input type="password" name="password" id="loginPassword" placeholder="Password" required style="padding-left: 40px; padding-right: 44px;">
                <button type="button" class="password-toggle" data-target="loginPassword" onclick="togglePasswordVisibility(this)" aria-label="Tampilkan password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <div class="reset-link">
                <span onclick="showForgotPassword()">Lupa Password?</span>
            </div>
            <button type="submit">Masuk</button>
            <div class="switch">
                Belum punya akun? <span onclick="showRegister()">Daftar Sekarang</span>
            </div>
        </form>

        <!-- REGISTER FORM -->
        <form id="registerForm" class="register-form" action="register.php" method="POST">
            <div class="input-group">
                <i class="fas fa-user-circle" style="position: absolute; margin: 15px; color: #94a3b8;"></i>
                <input type="text" name="fullname" id="regFullname" placeholder="Nama Lengkap *" required style="padding-left: 40px;">
            </div>
            
            <div class="form-row">
                <div class="input-wrapper">
                    <input type="text" name="nip" id="regNIP" placeholder="NIP *" maxlength="18" oninput="validateNIP(this)" onkeypress="return hanyaAngka(event)" required>
                </div>
                <input type="text" name="jabatan" id="regJabatan" placeholder="Jabatan *" required>
            </div>
            
            <div class="form-row">
                <input type="text" name="pangkat" id="regPangkat" placeholder="Pangkat / Golongan">
                <input type="text" name="no_hp" id="regNoHP" placeholder="No. HP *" required>
            </div>
            
            <div class="form-row">
                <input type="text" name="username" id="regUsername" placeholder="Username *" required>
                <div class="input-wrapper">
                    <input type="email" name="email" id="regEmail" placeholder="Email Instansi *" oninput="validateEmail(this)" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="input-wrapper password-wrapper">
                    <input type="password" name="password" id="regPassword" placeholder="Password *" required style="padding-right: 44px;">
                    <button type="button" class="password-toggle" data-target="regPassword" onclick="togglePasswordVisibility(this)" aria-label="Tampilkan password">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <input type="text" name="instansi" id="regInstansi" placeholder="Instansi *" required>
            </div>
            
            <div class="password-requirements">
                <p style="margin-bottom: 0.5rem; font-weight: 600; font-size: 0.85rem; color: #64748b;">Syarat Password:</p>
                <ul style="font-size: 0.8rem; color: #64748b; padding-left: 1.2rem;">
                    <li id="reg-req-all">Minimal 8–16 karakter dan mengandung huruf serta angka</li>
                </ul>
            </div>
            
            <button type="submit" class="btn-register" style="margin-top: 1rem;">Daftar Akun</button>
            <div class="switch">
                Sudah punya akun? <span onclick="showLoginForm()">Masuk Sekarang</span>
            </div>
        </form>

        <!-- FORGOT PASSWORD FORM (VERIFIKASI) -->
        <div id="forgotPasswordForm" class="forgot-password-form">
            <div class="info-box-small">
                <i class="fas fa-info-circle"></i> Masukkan username atau email Anda. Kami akan mengirim kode verifikasi.
            </div>
            <input type="text" id="resetUsername" placeholder="Username / Email">
            <button onclick="requestResetCode()" id="requestResetBtn">Kirim Kode Verifikasi</button>
            <div class="switch" style="margin-top: 1rem;">
                <span onclick="showLoginForm()">Kembali ke Login</span>
            </div>
        </div>

        <!-- RESET PASSWORD FORM (SETELAH VERIFIKASI) -->
        <div id="resetPasswordForm" class="reset-password-form">
            <div class="info-box-small">
                <i class="fas fa-lock"></i> Masukkan kode verifikasi terlebih dahulu, lalu ubah password.
            </div>
            
            <input type="hidden" id="resetUserId" value="">
            
            <div class="se-form-group">
                <label>Kode Verifikasi</label>
                <input type="text" id="verificationCode" placeholder="Masukkan kode 6 digit" class="otp-input" maxlength="6">
                <button onclick="verifyResetCode()" id="verifyCodeBtn" style="margin-top: 0.5rem;">Verifikasi Kode</button>
            </div>
            
            <div id="resetPasswordFields" style="display: none;">
                <div class="se-form-group">
                    <label>Password Baru</label>
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="newResetPassword" placeholder="Minimal 8 karakter" style="padding-right:44px;">
                        <button type="button" class="password-toggle" data-target="newResetPassword" onclick="togglePasswordVisibility(this)" aria-label="Tampilkan password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="se-form-group">
                    <label>Konfirmasi Password Baru</label>
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="confirmResetPassword" placeholder="Ulangi password baru" style="padding-right:44px;">
                        <button type="button" class="password-toggle" data-target="confirmResetPassword" onclick="togglePasswordVisibility(this)" aria-label="Tampilkan password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <button onclick="resetPassword()" id="resetPasswordBtn" disabled>Ubah Password</button>
            <div class="switch" style="margin-top: 1rem;">
                <span onclick="showForgotPassword()">Kirim ulang kode</span> 
                <span onclick="showLoginForm()">Kembali ke Login</span>
            </div>
        </div>
    </div>
    </div>
</div>
</div>

<script>
// ============================================
// DATA GLOBAL DAN PENYIMPANAN PER AKUN
// ============================================
let isLoggedIn = false;
let currentUser = null;
let databasePengajuan = [];
let databaseSETerdaftar = [];
let resetRequest = { userId: null, code: null, expiry: null, username: null };
let timerInterval = null;
let currentListFilter = 'semua';
let currentRiwayatFilter = 'semua';
let currentListPage = 1;
let currentRiwayatPage = 1;
const itemsPerPage = 5;
let uploadedFiles = {};

// Akun demo
const demoAccounts = [
    { username: 'admin', password: 'admin123', fullname: 'Administrator', nip: '197801011998031001', jabatan: 'Administrator', pangkat: 'Pembina', noHP: '08123456789', instansi: 'Diskominfo Probolinggo', email: 'admin@probolinggokota.go.id' },
    { username: 'fitrianingsih', password: '123456', fullname: 'FITRIANINGSIH', nip: '197801011998031001', jabatan: 'Kepala Dinas', pangkat: 'Pembina Utama Muda', noHP: '08123456789', instansi: 'Diskominfo Probolinggo', email: 'fitrianingsih@probolinggokota.go.id' }
];

// Inisialisasi database
function initDatabase() {
    // Tidak perlu inisialisasi global lagi karena setiap akun punya data sendiri
    console.log('Sistem siap dengan data per akun');
    
    // Simpan akun demo jika belum ada
    demoAccounts.forEach(account => {
        if (!localStorage.getItem('pseUser_' + account.username)) {
            localStorage.setItem('pseUser_' + account.username, JSON.stringify(account));
            
            // Inisialisasi data kosong untuk akun demo jika belum ada
            if (!localStorage.getItem('pse_pengajuan_' + account.username)) {
                localStorage.setItem('pse_pengajuan_' + account.username, JSON.stringify([]));
            }
            if (!localStorage.getItem('pse_terdaftar_' + account.username)) {
                localStorage.setItem('pse_terdaftar_' + account.username, JSON.stringify([]));
            }
        }
    });
}

// Fungsi untuk memuat data pengajuan berdasarkan user
function loadUserData(username) {
    const pengajuanKey = 'pse_pengajuan_' + username;
    const terdaftarKey = 'pse_terdaftar_' + username;
    
    databasePengajuan = JSON.parse(localStorage.getItem(pengajuanKey)) || [];
    databaseSETerdaftar = JSON.parse(localStorage.getItem(terdaftarKey)) || [];
    
    console.log(`Data dimuat untuk user ${username}:`, databasePengajuan.length, 'pengajuan,', databaseSETerdaftar.length, 'terdaftar');
}

// Fungsi untuk menyimpan data pengajuan berdasarkan user
function saveUserData(username) {
    const pengajuanKey = 'pse_pengajuan_' + username;
    const terdaftarKey = 'pse_terdaftar_' + username;
    
    localStorage.setItem(pengajuanKey, JSON.stringify(databasePengajuan));
    localStorage.setItem(terdaftarKey, JSON.stringify(databaseSETerdaftar));
    
    console.log(`Data disimpan untuk user ${username}`);
}

// ============================================
// FUNGSI VALIDASI NIP DAN EMAIL (TANPA PESAN ERROR)
// ============================================

// Fungsi untuk hanya mengizinkan angka pada input NIP
function hanyaAngka(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

// Fungsi validasi NIP (hanya visual, tanpa pesan error)
function validateNIP(input) {
    const nip = input.value;
    
    // Hapus spasi
    input.value = nip.replace(/\s/g, '');
    
    // Validasi panjang maksimal 18 karakter
    if (nip.length > 18) {
        input.classList.add('nip-input-error');
        input.classList.remove('nip-valid');
        return false;
    }
    
    // Validasi tidak boleh mengandung spasi
    if (nip.includes(' ')) {
        input.classList.add('nip-input-error');
        input.classList.remove('nip-valid');
        return false;
    }
    
    // Validasi hanya angka
    if (!/^\d*$/.test(nip)) {
        input.classList.add('nip-input-error');
        input.classList.remove('nip-valid');
        return false;
    }
    
    // Jika valid
    input.classList.remove('nip-input-error');
    input.classList.add('nip-valid');
    return true;
}

// Fungsi validasi Email (hanya visual, tanpa pesan error)
function validateEmail(input) {
    const email = input.value;
    
    // Validasi harus mengandung @
    if (!email.includes('@')) {
        input.classList.add('email-input-error');
        input.classList.remove('email-valid');
        return false;
    }
    
    // Validasi format email sederhana
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        input.classList.add('email-input-error');
        input.classList.remove('email-valid');
        return false;
    }
    
    // Jika valid
    input.classList.remove('email-input-error');
    input.classList.add('email-valid');
    return true;
}

function togglePasswordVisibility(button) {
    const targetId = button.getAttribute('data-target');
    const input = document.getElementById(targetId);
    if (!input) return;

    const icon = button.querySelector('i');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';

    if (icon) {
        icon.classList.remove(isHidden ? 'fa-eye' : 'fa-eye-slash');
        icon.classList.add(isHidden ? 'fa-eye-slash' : 'fa-eye');
    }

    button.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
}

// ============================================
// FUNGSI AUTHENTICATION
// ============================================
function showAuth(mode) {
    document.getElementById('authModal').style.display = 'flex';
    (function(){var ov=document.getElementById('overlay');if(ov){ov.classList.remove('active');}document.body.style.overflow='';})();
    
    document.getElementById('loginForm').classList.remove('active');
    document.getElementById('registerForm').classList.remove('active');
    document.getElementById('forgotPasswordForm').classList.remove('active');
    document.getElementById('resetPasswordForm').classList.remove('active');
    
    if (mode === 'register') {
        document.getElementById('registerForm').classList.add('active');
        document.getElementById('authTitle').innerText = 'Daftar Akun Baru';
    } else if (mode === 'forgot') {
        document.getElementById('forgotPasswordForm').classList.add('active');
        document.getElementById('authTitle').innerText = 'Lupa Password';
    } else if (mode === 'reset') {
        document.getElementById('resetPasswordForm').classList.add('active');
        document.getElementById('authTitle').innerText = 'Reset Password';
    } else {
        document.getElementById('loginForm').classList.add('active');
        document.getElementById('authTitle').innerText = 'Login Dashboard';
    }
}

function closeAuth() {
    document.getElementById('authModal').style.display = 'none';
    showLoginForm();
    clearForms();
    (function(){var ov=document.getElementById('overlay');if(ov){ov.classList.remove('active');}document.body.style.overflow='';})();
    
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

function showRegister() {
    document.getElementById('loginForm').classList.remove('active');
    document.getElementById('forgotPasswordForm').classList.remove('active');
    document.getElementById('resetPasswordForm').classList.remove('active');
    document.getElementById('registerForm').classList.add('active');
    document.getElementById('authTitle').innerText = 'Daftar Akun Baru';
    (function(){var c=document.querySelector('.auth-right-content');if(c){c.scrollTop=0;}var ov=document.getElementById('overlay');if(ov){ov.classList.remove('active');}document.body.style.overflow='';})();
}

function showLoginForm() {
    document.getElementById('registerForm').classList.remove('active');
    document.getElementById('forgotPasswordForm').classList.remove('active');
    document.getElementById('resetPasswordForm').classList.remove('active');
    document.getElementById('loginForm').classList.add('active');
    document.getElementById('authTitle').innerText = 'Login Dashboard';
    
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

function showForgotPassword() {
    document.getElementById('loginForm').classList.remove('active');
    document.getElementById('registerForm').classList.remove('active');
    document.getElementById('resetPasswordForm').classList.remove('active');
    document.getElementById('forgotPasswordForm').classList.add('active');
    document.getElementById('authTitle').innerText = 'Lupa Password';
    
    document.getElementById('resetUsername').value = '';
    
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

function validatePassword(password) {
    return password.length >= 8 && password.length <= 16 && /[a-zA-Z]/.test(password) && /[0-9]/.test(password);
}

// Validasi password real-time
document.addEventListener('DOMContentLoaded', function() {
    const regPassword = document.getElementById('regPassword');
    if (regPassword) {
        regPassword.addEventListener('input', function() {
            const pwd = this.value;
            const ok = validatePassword(pwd);
            const item = document.getElementById('reg-req-all');
            if (item) item.className = ok ? 'valid' : 'invalid';
        });
    }
    
    const newPassword = document.getElementById('newPassword');
    if (newPassword) {
        newPassword.addEventListener('input', function() {
            const pwd = this.value;
            document.getElementById('req-length').className = pwd.length >= 8 ? 'valid' : 'invalid';
            document.getElementById('req-max').className = pwd.length <= 16 ? 'valid' : 'invalid';
            document.getElementById('req-letter').className = /[a-zA-Z]/.test(pwd) ? 'valid' : 'invalid';
            document.getElementById('req-number').className = /[0-9]/.test(pwd) ? 'valid' : 'invalid';
        });
    }
    
    const newResetPassword = document.getElementById('newResetPassword');
    if (newResetPassword) {
        newResetPassword.addEventListener('input', function() {
            const pwd = this.value;
            document.getElementById('reset-req-length').className = pwd.length >= 8 ? 'valid' : 'invalid';
            document.getElementById('reset-req-max').className = pwd.length <= 16 ? 'valid' : 'invalid';
            document.getElementById('reset-req-letter').className = /[a-zA-Z]/.test(pwd) ? 'valid' : 'invalid';
            document.getElementById('reset-req-number').className = /[0-9]/.test(pwd) ? 'valid' : 'invalid';
        });
    }
});

function handleRegister() {
    const fullname = document.getElementById('regFullname').value;
    const nip = document.getElementById('regNIP').value;
    const jabatan = document.getElementById('regJabatan').value;
    const pangkat = document.getElementById('regPangkat').value;
    const noHP = document.getElementById('regNoHP').value;
    const username = document.getElementById('regUsername').value;
    const email = document.getElementById('regEmail').value;
    const password = document.getElementById('regPassword').value;
    const instansi = document.getElementById('regInstansi').value;

    // Validasi data wajib
    if (!fullname || !nip || !jabatan || !noHP || !username || !email || !password || !instansi) {
        alert('âŒ Lengkapi semua data wajib (bertanda *)');
        return;
    }
    
    // Validasi NIP: maksimal 18 karakter, tanpa spasi, hanya angka
    if (nip.length > 18) {
        alert('âŒ NIP maksimal 18 karakter!');
        return;
    }
    
    if (nip.includes(' ')) {
        alert('âŒ NIP tidak boleh mengandung spasi!');
        return;
    }
    
    if (!/^\d+$/.test(nip)) {
        alert('âŒ NIP hanya boleh berisi angka!');
        return;
    }
    
    // Validasi Email: harus mengandung @
    if (!email.includes('@')) {
        alert('âŒ Email harus valid dan mengandung karakter @!');
        return;
    }
    
    // Validasi format email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('âŒ Format email tidak valid! Contoh: nama@domain.com');
        return;
    }
    
    if (!validatePassword(password)) {
        alert('âŒ Password harus 8-16 karakter dan mengandung huruf dan angka');
        return;
    }

    // Cek apakah username sudah ada
    if (localStorage.getItem('pseUser_' + username)) {
        alert('âŒ Username sudah digunakan!');
        return;
    }

    const userData = {
        fullname,
        nip,
        jabatan,
        pangkat: pangkat || '-',
        noHP,
        username,
        email,
        instansi,
        password,
        joined: new Date().toLocaleDateString('id-ID')
    };
    
    localStorage.setItem('pseUser_' + username, JSON.stringify(userData));
    
    // Inisialisasi data kosong untuk user baru (mulai dari 0)
    localStorage.setItem('pse_pengajuan_' + username, JSON.stringify([]));
    localStorage.setItem('pse_terdaftar_' + username, JSON.stringify([]));
    
    alert('âœ… Registrasi berhasil! Silakan login dengan akun baru Anda. Dashboard akan dimulai dari 0.');
    showLoginForm();
    clearForms();
}

function handleLogin() {
    const username = document.getElementById('loginUsername').value;
    const password = document.getElementById('loginPassword').value;

    if (!username || !password) {
        alert('âŒ Lengkapi username dan password');
        return;
    }

    // Cek demo accounts
    const demoAccount = demoAccounts.find(acc => acc.username === username && acc.password === password);
    if (demoAccount) {
        loginSuccess(demoAccount);
        return;
    }

    // Cek user biasa
    const userData = localStorage.getItem('pseUser_' + username);
    if (userData) {
        const user = JSON.parse(userData);
        if (user.password === password) {
            loginSuccess(user);
        } else {
            alert(' Password salah');
        }
    } else {
        alert('Username tidak ditemukan');
    }
}

function requestResetCode() {
    const username = document.getElementById('resetUsername').value;
    if (!username) { alert(' Masukkan username atau email'); return; }
    const fd = new FormData(); fd.append('identifier', username);
    fetch('request_reset_code.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                if (res.email_sent) {
                    alert(' Kode verifikasi telah dikirim ke email: ' + (res.email_to || '(tidak ada)'));
                } else {
                    alert(`âš Padlock KODE VERIFIKASI ANDA: ${res.code}\n\nKode berlaku hingga ${res.expiry}.`);
                }
                document.getElementById('forgotPasswordForm').classList.remove('active');
                document.getElementById('resetPasswordForm').classList.add('active');
                document.getElementById('authTitle').innerText = 'Reset Password';
                document.getElementById('resetUserId').value = res.username || username;
                startResetTimer(new Date(res.expiry).getTime());
                const codeInput = document.getElementById('verificationCode');
                if (codeInput) {
                    setTimeout(function() {
                        codeInput.focus();
                        document.getElementById('resetPasswordForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 100);
                }
            } else {
                alert(' ' + (res.message || 'Gagal membuat kode verifikasi'));
            }
        })
      
}

function startResetTimer(expiry) {
    if (timerInterval) clearInterval(timerInterval);
    timerInterval = setInterval(function() {
        const now = new Date().getTime();
        if (now > expiry) {
            clearInterval(timerInterval);
            timerInterval = null;
        }
    }, 1000);
}

function resetPassword() {
    const verificationCode = document.getElementById('verificationCode').value;
    const newPassword = document.getElementById('newResetPassword').value;
    const confirmPassword = document.getElementById('confirmResetPassword').value;
    const username = document.getElementById('resetUserId').value;
    if (!verificationCode || !newPassword || !confirmPassword) { alert(' Lengkapi semua field'); return; }
    if (newPassword !== confirmPassword) { alert('Konfirmasi password tidak cocok'); return; }
    if (!validatePassword(newPassword)) { alert('Password harus 8-16 karakter dan mengandung huruf dan angka'); return; }
    const fd = new FormData(); fd.append('username', username); fd.append('code', verificationCode); fd.append('new_password', newPassword);
    fetch('reset_password.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                alert(' Password berhasil diubah! Silakan login dengan password baru.');
                sessionStorage.removeItem('pse_reset_request');
                if (timerInterval) { clearInterval(timerInterval); timerInterval = null; }
                showLoginForm();
                clearForms();
            } else {
                alert(' ' + (res.message || 'Gagal mengubah password'));
            }
        })
      
}

function verifyResetCode() {
    const username = document.getElementById('resetUserId').value;
    const code = document.getElementById('verificationCode').value;
    if (!code || !username) { alert(' Masukkan kode verifikasi'); return; }
    const fd = new FormData(); fd.append('username', username); fd.append('code', code);
    fetch('verify_reset_code.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                if (confirm('Kode valid. Lanjut ubah password?')) {
                    document.getElementById('resetPasswordFields').style.display = 'block';
                    document.getElementById('resetPasswordBtn').disabled = false;
                    document.getElementById('newResetPassword').focus();
                }
            } else {
                alert(' ' + (res.message || 'Kode verifikasi tidak valid'));
            }
        })
        .catch(() => alert(' Gagal memverifikasi kode'));
}

function loginSuccess(user) {
    isLoggedIn = true;
    currentUser = user;
    
    // Load data spesifik untuk user ini
    loadUserData(user.username);
    
    // Update semua element yang menampilkan nama user
    document.querySelectorAll('#dashboardUserName, #pendaftaranUserName, #listUserName, #riwayatUserName, #profilUserName, #riwayatPejabatUserName, #panduanUserName, #laporanUserName, #settingUserName, #editRiwayatUserName').forEach(el => {
        if (el) el.textContent = user.fullname;
    });
    
    // Update profil pejabat
    document.getElementById('profilNama').textContent = user.fullname;
    document.getElementById('profilAvatar').textContent = user.fullname.charAt(0);
    
    // Isi form profil
    document.getElementById('profil_nama').value = user.fullname || '';
    document.getElementById('profil_nip').value = user.nip || '';
    document.getElementById('profil_jabatan').value = user.jabatan || '';
    document.getElementById('profil_email').value = user.email || '';
    document.getElementById('profil_alamat').value = 'Jl. Dr. Moch. Saleh No.5, Kecamatan Kanigaran, Kota Probolinggo';
    document.getElementById('profil_telp').value = user.noHP || '';
    
    // Isi form pendaftaran
    document.getElementById('se_instansi').value = '';
    document.getElementById('se_narahubung').value = user.fullname || '';
    document.getElementById('se_telepon').value = user.noHP || '';
    
    // Update tombol login
    const loginBtn = document.getElementById('loginBtn');
    loginBtn.innerHTML = `<i class="fas fa-sign-out-alt"></i> Logout ${user.fullname}`;
    loginBtn.className = 'btn-login btn-logout';
    loginBtn.onclick = logout;
    
    // Tampilkan dashboard
    document.getElementById('publicWrapper').style.display = 'none';
    document.getElementById('appWrapper').style.display = 'flex';
    
    // Aktifkan menu dashboard
    document.querySelectorAll('.sidebar li').forEach(li => li.classList.remove('active'));
    document.querySelector('.sidebar li[data-target="page-dashboard"]').classList.add('active');
    
    document.querySelectorAll('.dashboard-content').forEach(c => c.classList.remove('active'));
    document.getElementById('page-dashboard').classList.add('active');
    
    // Load semua data untuk user ini
    loadAllData();
    
    closeAuth();
    clearForms();
    
    console.log(`âœ… Login berhasil untuk ${user.username} dengan ${databasePengajuan.length} pengajuan dan ${databaseSETerdaftar.length} SE terdaftar`);
}

function logout() {
    isLoggedIn = false;
    currentUser = null;
    databasePengajuan = [];
    databaseSETerdaftar = [];
    
    // Update tombol login
    const loginBtn = document.getElementById('loginBtn');
    loginBtn.innerHTML = 'Masuk / Daftar';
    loginBtn.className = 'btn-login';
    loginBtn.onclick = () => showAuth('login');
    
    // Tampilkan halaman public
    document.getElementById('appWrapper').style.display = 'none';
    document.getElementById('publicWrapper').style.display = 'block';
    
    // Aktifkan beranda
    document.querySelectorAll('.nav-menu a').forEach(x => x.classList.remove('active'));
    document.querySelector('a[data-page="beranda"]').classList.add('active');
    document.querySelectorAll('.content').forEach(c => c.classList.remove('active'));
    document.getElementById('beranda').classList.add('active');
    
    clearForms();
}

function clearForms() {
    document.getElementById('loginUsername').value = '';
    document.getElementById('loginPassword').value = '';
    document.getElementById('regFullname').value = '';
    document.getElementById('regNIP').value = '';
    document.getElementById('regJabatan').value = '';
    document.getElementById('regPangkat').value = '';
    document.getElementById('regNoHP').value = '';
    document.getElementById('regUsername').value = '';
    document.getElementById('regEmail').value = '';
    document.getElementById('regPassword').value = '';
    document.getElementById('regInstansi').value = '';
    document.getElementById('resetUsername').value = '';
    document.getElementById('verificationCode').value = '';
    document.getElementById('newResetPassword').value = '';
    document.getElementById('confirmResetPassword').value = '';
    document.getElementById('currentPassword').value = '';
    document.getElementById('newPassword').value = '';
    document.getElementById('confirmPassword').value = '';
}

// ============================================
// FUNGSI MANAJEMEN DATA
// ============================================
function generateNoTandaDaftar() {
    const randomNum = Math.floor(Math.random() * 900 + 100);
    const year = new Date().getFullYear();
    return `PSE-${randomNum}/${year}`;
}

function simpanPengajuan(data) {
    if (!currentUser) {
        alert('Silakan login terlebih dahulu!');
        return null;
    }
    
    const now = new Date();
    const tanggal = now.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
    const jam = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    
    const pengajuanBaru = {
        id: Date.now(),
        nomorPengajuan: 'P-' + Math.floor(Math.random() * 9000 + 1000),
        tanggalPengajuan: tanggal + ' ' + jam,
        tanggal: tanggal,
        jenis: 'ðŸ“ Pendaftaran',
        status: 'Menunggu Verifikasi',
        statusText: 'â³ Menunggu Verifikasi',
        pengaju: currentUser.username,
        ...data
    };
    
    databasePengajuan.unshift(pengajuanBaru);
    
    // Simpan ke localStorage dengan prefix username
    saveUserData(currentUser.username);
    
    return pengajuanBaru;
}

function approvePengajuan(id) {
    if (!currentUser) return;
    
    const index = databasePengajuan.findIndex(p => p.id === id);
    if (index !== -1) {
        const pengajuan = databasePengajuan[index];
        
        pengajuan.status = 'âœ… Diterima';
        pengajuan.statusText = 'âœ… Diterima';
        
        const noTandaDaftar = generateNoTandaDaftar();
        
        const seTerdaftarBaru = {
            id: Date.now() + Math.random(),
            instansi: pengajuan.instansi,
            unitKerja: pengajuan.unitKerja || '-',
            namaSE: pengajuan.namaSE,
            pejabat: currentUser.fullname,
            status: 'âœ… Terbit',
            tanggalTerbit: new Date().toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }),
            tanggal: new Date().toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }),
            noTandaDaftar: noTandaDaftar,
            versi: pengajuan.versi || '-',
            bidang: pengajuan.bidang || '-',
            url: pengajuan.url || '-',
            dns: pengajuan.dns || '-',
            deskripsi: pengajuan.deskripsi || '-',
            risiko: pengajuan.risiko || '-',
            klasifikasi: pengajuan.klasifikasi || '-',
            dataPribadi: pengajuan.dataPribadi || '-',
            lokasi: pengajuan.lokasi || '-',
            dokumen: pengajuan.dokumen || '-'
        };
        
        databaseSETerdaftar.unshift(seTerdaftarBaru);
        
        // Simpan ke localStorage dengan prefix username
        saveUserData(currentUser.username);
        
        loadAllData();
        alert('âœ… Pengajuan disetujui dan SE berhasil terdaftar!');
    }
}

function tolakPengajuan(id) {
    if (!currentUser) return;
    
    const index = databasePengajuan.findIndex(p => p.id === id);
    if (index !== -1) {
        databasePengajuan[index].status = ' Ditolak';
        databasePengajuan[index].statusText = ' Ditolak';
        
        saveUserData(currentUser.username);
        loadAllData();
        alert(' Pengajuan ditolak!');
    }
}

function hapusPengajuan(id) {
    if (!currentUser) return;
    
    if (confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')) {
        const index = databasePengajuan.findIndex(p => p.id === id);
        if (index !== -1) {
            databasePengajuan.splice(index, 1);
            saveUserData(currentUser.username);
            loadAllData();
            alert('ðŸ—‘ï¸ Pengajuan berhasil dihapus!');
        }
    }
}

function mintaPembaharuan(id) {
    if (!currentUser) return;
    
    const index = databasePengajuan.findIndex(p => p.id === id);
    if (index !== -1) {
        const pengajuan = databasePengajuan[index];
        
        pengajuan.status = 'ðŸ”„ Permintaan Pembaharuan';
        pengajuan.statusText = 'ðŸ”„ Permintaan Pembaharuan';
        pengajuan.jenis = 'Pembaharuan';
        
        saveUserData(currentUser.username);
        loadAllData();
        
        bukaEditRiwayat(id);
    }
}

function mintaPenghapusan(id) {
    if (!currentUser) return;
    
    const index = databasePengajuan.findIndex(p => p.id === id);
    if (index !== -1) {
        databasePengajuan[index].status = 'â›” Permintaan Penghapusan';
        databasePengajuan[index].statusText = 'â›” Permintaan Penghapusan';
        databasePengajuan[index].jenis = 'Penghapusan';
        
        saveUserData(currentUser.username);
        loadAllData();
        alert('â›” Permintaan penghapusan telah dikirim!');
    }
}

function hapusSETerdaftar(id) {
    if (!currentUser) return;
    
    if (confirm('Apakah Anda yakin ingin menghapus SE terdaftar ini?')) {
        const index = databaseSETerdaftar.findIndex(s => s.id === id);
        if (index !== -1) {
            databaseSETerdaftar.splice(index, 1);
            saveUserData(currentUser.username);
            loadAllData();
            alert('ðŸ—‘ï¸ SE terdaftar berhasil dihapus!');
        }
    }
}

function loadAllData() {
    if (!currentUser) return;
    
    loadUserData(currentUser.username);
    
    loadRiwayat();
    loadListSE();
    loadAktivitas();
    loadRiwayatPejabat();
    updateDashboardStats();
    loadRingkasanPengajuan();
    loadRingkasanSE();
    loadDashboardChart();
    
    const listFooter = document.getElementById('listSEFooter');
    const riwayatFooter = document.getElementById('riwayatFooter');
    
    if (listFooter) {
        listFooter.style.display = databaseSETerdaftar.length > 0 ? 'flex' : 'none';
    }
    if (riwayatFooter) {
        riwayatFooter.style.display = databasePengajuan.length > 0 ? 'flex' : 'none';
    }
}

function updateDashboardStats() {
    const totalSE = databaseSETerdaftar.length;
    const totalPengajuan = databasePengajuan.length;
    const ditolak = databasePengajuan.filter(p => p.status === ' Ditolak' || p.status === 'Ditolak').length;
    const dihapus = databaseSETerdaftar.filter(s => s.status === '¸ Dihapus').length;
    const pembaharuan = databasePengajuan.filter(p => p.jenis === 'Pembaharuan' || p.status.includes('Pembaharuan')).length;
    const penghapusan = databasePengajuan.filter(p => p.jenis === 'Penghapusan' || p.status.includes('Penghapusan')).length;
    
    document.getElementById('statPengajuan').innerHTML = totalPengajuan;
    document.getElementById('statTerdaftar').innerHTML = totalSE;
    document.getElementById('statDitolak').innerHTML = ditolak;
    document.getElementById('statDihapus').innerHTML = dihapus;
    document.getElementById('statPembaharuan').innerHTML = pembaharuan;
    document.getElementById('statPenghapusan').innerHTML = penghapusan;
}

function loadRingkasanPengajuan() {
    const tbody = document.getElementById('ringkasanPengajuanBody');
    if (!tbody) return;
    
    if (databasePengajuan.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">Belum ada pengajuan</td></tr>';
        return;
    }
    
    const dataTerbaru = databasePengajuan.slice(0, 5);
    let html = '';
    dataTerbaru.forEach(item => {
        const badgeClass = item.status === ' Diterima' ? 'badge-green' : 
                          item.status === 'Ditolak' ? 'badge-red' : 'badge-orange';
        html += `<tr>
            <td>${item.tanggalPengajuan?.split(' ')[0] || item.tanggal || '-'}</td>
            <td>${item.namaSE || '-'}</td>
            <td>${item.instansi || '-'}</td>
            <td><span class="badge ${badgeClass}">${item.statusText || item.status}</span></td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
}

function loadRingkasanSE() {
    const tbody = document.getElementById('ringkasanSEBody');
    if (!tbody) return;
    
    if (databaseSETerdaftar.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">Belum ada SE terdaftar</td></tr>';
        return;
    }
    
    const dataTerbaru = databaseSETerdaftar.slice(0, 5);
    let html = '';
    dataTerbaru.forEach(item => {
        html += `<tr>
            <td>${item.tanggalTerbit || item.tanggal || '-'}</td>
            <td>${item.namaSE || '-'}</td>
            <td>${item.instansi || '-'}</td>
            <td><strong>${item.noTandaDaftar || '-'}</strong></td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
}

function loadDashboardChart() {
    const canvas = document.getElementById('dashboardChart');
    if (!canvas) return;
    
    const existingChart = Chart.getChart(canvas);
    if (existingChart) {
        existingChart.destroy();
    }
    
    const bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    const bulanData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    
    databasePengajuan.forEach(item => {
        if (item.tanggalPengajuan) {
            const parts = item.tanggalPengajuan.split(/[/\s]/);
            if (parts.length >= 2) {
                const bulan = parseInt(parts[1]) - 1;
                if (bulan >= 0 && bulan < 12) bulanData[bulan]++;
            }
        } else if (item.tanggal) {
            const parts = item.tanggal.split('/');
            if (parts.length >= 2) {
                const bulan = parseInt(parts[1]) - 1;
                if (bulan >= 0 && bulan < 12) bulanData[bulan]++;
            }
        }
    });
    
    const now = new Date();
    const currentMonth = now.getMonth();
    const last6Months = [];
    const last6Data = [];
    
    for (let i = 5; i >= 0; i--) {
        let monthIndex = (currentMonth - i + 12) % 12;
        last6Months.push(bulanNames[monthIndex]);
        last6Data.push(bulanData[monthIndex]);
    }
    
    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: last6Months,
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: last6Data,
                backgroundColor: '#3b82f6',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
}

function loadAktivitas() {
    const tbody = document.getElementById('aktivitasTerbaruBody');
    if (!tbody) return;
    
    const aktivitas = databasePengajuan.slice(0, 5).map(p => ({
        tanggal: p.tanggalPengajuan?.split(' ')[0] || p.tanggal || '-',
        aktivitas: 'Pendaftaran ' + (p.namaSE || 'SE'),
        status: p.status || 'Menunggu'
    }));
    
    if (aktivitas.length === 0) {
        tbody.innerHTML = '<tr><td colspan="3" style="text-align: center;">Belum ada aktivitas</td></tr>';
        return;
    }
    
    let html = '';
    aktivitas.forEach(item => {
        const badgeClass = item.status === ' Diterima' ? 'badge-green' : 
                          item.status === ' Ditolak' ? 'badge-red' : 'badge-orange';
        html += `<tr>
            <td>${item.tanggal}</td>
            <td>${item.aktivitas}</td>
            <td><span class="badge ${badgeClass}">${item.status}</span></td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
}

function loadRiwayat() {
    const tbody = document.getElementById('riwayatBody');
    if (!tbody) return;
    
    if (databasePengajuan.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="info-box">
            <i class="fas fa-history"></i>
            <h4>Belum Ada Riwayat Pengajuan</h4>
            <p>Anda belum melakukan pengajuan SE. Silakan lakukan pendaftaran terlebih dahulu.</p>
            <button class="btn-add" onclick="showPendaftaranSE()">Daftar SE Sekarang</button>
        </div></td></tr>`;
        document.getElementById('riwayatInfo').innerHTML = 'ðŸ‘ï¸ View 0 dari 0';
        return;
    }
    
    const start = (currentRiwayatPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedData = databasePengajuan.slice(start, end);
    
    let html = '';
    paginatedData.forEach((item) => {
        const badgeClass = item.status === 'âœ… Diterima' ? 'badge-green' : 
                          item.status === ' Ditolak' ? 'badge-red' : 'badge-orange';
        
        let jenisPengajuan = 'ðŸ“ Pendaftaran';
        if (item.jenis === 'Pembaharuan' || item.status.includes('Pembaharuan')) {
            jenisPengajuan = 'ðŸ”„ Pembaharuan';
        } else if (item.jenis === 'Penghapusan' || item.status.includes('Penghapusan')) {
            jenisPengajuan = 'â›” Penghapusan';
        }
        
        html += `<tr>
            <td>
                <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                    <button class="icon-btn" onclick="detailPengajuan(${item.id})" title="Detail"></button>
                    <button class="icon-btn icon-btn-success" onclick="approvePengajuan(${item.id})" title="Setujui">âœ…</button>
                    <button class="icon-btn icon-btn-danger" onclick="tolakPengajuan(${item.id})" title="Tolak"></button>
                    <button class="icon-btn icon-btn-warning" onclick="mintaPembaharuan(${item.id})" title="Minta Pembaharuan"></button>
                    <button class="icon-btn icon-btn-danger" onclick="mintaPenghapusan(${item.id})" title="Minta Penghapusan"</button>
                    <button class="icon-btn icon-btn-secondary" onclick="hapusPengajuan(${item.id})" title="Hapus"></button>
                </div>
            </td>
            <td><span class="badge ${badgeClass}">${jenisPengajuan}</span></td>
            <td><span class="badge ${badgeClass}">${item.statusText || item.status}</span></td>
            <td>${item.namaSE || '-'}</td>
            <td>${item.tanggalPengajuan || item.tanggal || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
    document.getElementById('riwayatInfo').innerHTML = `ðŸ‘ï¸ View ${start+1}-${Math.min(end, databasePengajuan.length)} dari ${databasePengajuan.length}`;
    
    const riwayatFooter = document.getElementById('riwayatFooter');
    if (riwayatFooter) {
        riwayatFooter.style.display = 'flex';
        updatePagination('riwayat', databasePengajuan.length);
    }
}

function loadListSE() {
    const tbody = document.getElementById('listSEBody');
    if (!tbody) return;
    
    if (databaseSETerdaftar.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6"><div class="info-box">
            <i class="fas fa-inbox"></i>
            <h4>Belum Ada Data SE Terdaftar</h4>
            <p>Anda belum memiliki SE yang terdaftar. Silakan lakukan pendaftaran dan tunggu persetujuan.</p>
            <button class="btn-add" onclick="showPendaftaranSE()">Daftar SE Sekarang</button>
        </div></td></tr>`;
        document.getElementById('listSEInfo').innerHTML = 'ðŸ‘ï¸ View 0 dari 0';
        
        const listFooter = document.getElementById('listSEFooter');
        if (listFooter) {
            listFooter.style.display = 'none';
        }
        return;
    }
    
    const start = (currentListPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedData = databaseSETerdaftar.slice(start, end);
    
    let html = '';
    paginatedData.forEach((item) => {
        const badgeClass = item.status === ' Terbit' ? 'badge-green' : 
                          item.status === 'Ditolak' ? 'badge-red' : 
                          item.status === ' Dalam Pembaharuan' ? 'badge-orange' : 'badge-blue';
        
        html += `<tr>
            <td>
                <div style="display: flex; gap: 5px;">
                    <button class="icon-btn" onclick="detailSE(${item.id})" title="Lihat Sertifikat">ðŸ“„</button>
                    <button class="icon-btn icon-btn-danger" onclick="hapusSETerdaftar(${item.id})" title="Hapus">ðŸ—‘ï¸</button>
                </div>
            </td>
            <td>${item.instansi || '-'} / ${item.unitKerja || '-'}</td>
            <td>${item.namaSE || '-'} / ${item.pejabat || '-'}</td>
            <td><span class="badge ${badgeClass}">${item.status || 'âœ… Terbit'}</span></td>
            <td>${item.tanggalTerbit || item.tanggal || '-'}</td>
            <td>${item.noTandaDaftar || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
    document.getElementById('listSEInfo').innerHTML = `ðŸ‘ï¸ View ${start+1}-${Math.min(end, databaseSETerdaftar.length)} dari ${databaseSETerdaftar.length}`;
    
    const listFooter = document.getElementById('listSEFooter');
    if (listFooter) {
        listFooter.style.display = 'flex';
        updatePagination('list', databaseSETerdaftar.length);
    }
}

function updatePagination(type, totalItems) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const paginationDiv = document.getElementById(type + 'SEPagination');
    if (!paginationDiv) return;
    
    let currentPage = type === 'list' ? currentListPage : currentRiwayatPage;
    
    let html = '';
    html += `<button onclick="changePage('${type}', 'first')" ${currentPage === 1 ? 'disabled' : ''}>First</button>`;
    html += `<button onclick="changePage('${type}', 'prev')" ${currentPage === 1 ? 'disabled' : ''}>Prev</button>`;
    
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
            html += `<button onclick="changePage('${type}', ${i})" class="${currentPage === i ? 'active' : ''}">${i}</button>`;
        } else if (i === currentPage - 2 || i === currentPage + 2) {
            html += `<button disabled>...</button>`;
        }
    }
    
    html += `<button onclick="changePage('${type}', 'next')" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`;
    html += `<button onclick="changePage('${type}', 'last')" ${currentPage === totalPages ? 'disabled' : ''}>Last</button>`;
    
    paginationDiv.innerHTML = html;
}

function changePage(type, action) {
    const totalItems = type === 'list' ? databaseSETerdaftar.length : databasePengajuan.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    let currentPage = type === 'list' ? currentListPage : currentRiwayatPage;
    
    if (action === 'first') currentPage = 1;
    else if (action === 'last') currentPage = totalPages;
    else if (action === 'prev') currentPage = Math.max(1, currentPage - 1);
    else if (action === 'next') currentPage = Math.min(totalPages, currentPage + 1);
    else currentPage = action;
    
    if (type === 'list') {
        currentListPage = currentPage;
        loadListSE();
    } else {
        currentRiwayatPage = currentPage;
        loadRiwayat();
    }
}

function loadRiwayatPejabat() {
    const tbody = document.getElementById('riwayatPejabatBody');
    if (!tbody) return;
    
    const riwayat = currentUser ? databasePengajuan.filter(p => p.narahubung === currentUser.fullname || p.pengaju === currentUser.fullname || p.pengaju === currentUser.username) : [];
    
    if (riwayat.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Belum ada riwayat pengajuan pejabat</td></tr>';
        return;
    }
    
    let html = '';
    riwayat.forEach(item => {
        const badgeClass = item.status === 'Diterima' ? 'badge-green' : 
                          item.status === ' Ditolak' ? 'badge-red' : 'badge-orange';
        
        let jenisPengajuan = 'Pendaftaran SE';
        if (item.jenis === 'Pembaharuan' || item.status.includes('Pembaharuan')) {
            jenisPengajuan = 'Pembaharuan SE';
        } else if (item.jenis === 'Penghapusan' || item.status.includes('Penghapusan')) {
            jenisPengajuan = 'Penghapusan SE';
        }
        
        html += `<tr>
            <td><button class="icon-btn" onclick="detailPengajuan(${item.id})">ðŸ“„</button></td>
            <td><strong>${item.narahubung || item.pengaju || '-'}</strong></td>
            <td>${item.instansi || '-'}</td>
            <td>${jenisPengajuan}</td>
            <td><span class="badge ${badgeClass}">${item.status}</span></td>
            <td>${item.tanggalPengajuan || item.tanggal || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
}

function filterRiwayatPejabat() {
    const namaFilter = document.getElementById('filterPejabatNama').value.toLowerCase();
    const instansiFilter = document.getElementById('filterPejabatInstansi').value.toLowerCase();
    
    let filtered = currentUser ? databasePengajuan.filter(p => p.narahubung === currentUser.fullname || p.pengaju === currentUser.fullname || p.pengaju === currentUser.username) : [];
    
    if (namaFilter) {
        filtered = filtered.filter(item => (item.narahubung || item.pengaju)?.toLowerCase().includes(namaFilter));
    }
    if (instansiFilter) {
        filtered = filtered.filter(item => item.instansi?.toLowerCase().includes(instansiFilter));
    }
    
    const tbody = document.getElementById('riwayatPejabatBody');
    if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Tidak ada data yang cocok</td></tr>';
        return;
    }
    
    let html = '';
    filtered.forEach(item => {
        const badgeClass = item.status === ' Diterima' ? 'badge-green' : 
                          item.status === ' Ditolak' ? 'badge-red' : 'badge-orange';
        
        let jenisPengajuan = 'Pendaftaran SE';
        if (item.jenis === 'Pembaharuan' || item.status.includes('Pembaharuan')) {
            jenisPengajuan = 'Pembaharuan SE';
        } else if (item.jenis === 'Penghapusan' || item.status.includes('Penghapusan')) {
            jenisPengajuan = 'Penghapusan SE';
        }
        
        html += `<tr>
            <td><button class="icon-btn" onclick="detailPengajuan(${item.id})">ðŸ“„</button></td>
            <td><strong>${item.narahubung || item.pengaju || '-'}</strong></td>
            <td>${item.instansi || '-'}</td>
            <td>${jenisPengajuan}</td>
            <td><span class="badge ${badgeClass}">${item.status}</span></td>
            <td>${item.tanggalPengajuan || item.tanggal || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
}

// ============================================
// FUNGSI EDIT RIWAYAT
// ============================================
function bukaEditRiwayat(id) {
    const pengajuan = databasePengajuan.find(p => p.id === id);
    if (!pengajuan) {
        alert('Data tidak ditemukan!');
        return;
    }
    
    document.querySelectorAll('.sidebar li').forEach(li => li.classList.remove('active'));
    document.querySelector('.sidebar li[data-target="page-edit-riwayat"]').classList.add('active');
    
    document.querySelectorAll('.dashboard-content').forEach(c => c.classList.remove('active'));
    document.getElementById('page-edit-riwayat').classList.add('active');
    
    document.getElementById('edit_riwayat_id').value = id;
    document.getElementById('edit_riwayat_instansi').value = pengajuan.instansi || '';
    document.getElementById('edit_riwayat_unitkerja').value = pengajuan.unitKerja || '';
    document.getElementById('edit_riwayat_nama').value = pengajuan.namaSE || '';
    document.getElementById('edit_riwayat_versi').value = pengajuan.versi || '';
    document.getElementById('edit_riwayat_bidang').value = pengajuan.bidang || '';
    document.getElementById('edit_riwayat_narahubung').value = pengajuan.narahubung || '';
    document.getElementById('edit_riwayat_telepon').value = pengajuan.telepon || '';
    document.getElementById('edit_riwayat_url').value = pengajuan.url || '';
    document.getElementById('edit_riwayat_dns').value = pengajuan.dns || '';
    document.getElementById('edit_riwayat_deskripsi').value = pengajuan.deskripsi || '';
    document.getElementById('edit_riwayat_risiko').value = pengajuan.risiko || '';
    document.getElementById('edit_riwayat_klasifikasi').value = pengajuan.klasifikasi || '';
    document.getElementById('edit_riwayat_data_pribadi').value = pengajuan.dataPribadi || '';
    document.getElementById('edit_riwayat_lokasi').value = pengajuan.lokasi || '';
    document.getElementById('edit_riwayat_dokumen').value = pengajuan.dokumen || '';
    
    document.getElementById('edit_riwayat_kewajiban1').checked = true;
    document.getElementById('edit_riwayat_kewajiban2').checked = true;
    document.getElementById('edit_riwayat_kewajiban3').checked = true;
    document.getElementById('edit_riwayat_kewajiban4').checked = true;
    
    document.getElementById('edit_riwayat_nomor').textContent = pengajuan.nomorPengajuan || '-';
    document.getElementById('edit_riwayat_tanggal').textContent = pengajuan.tanggalPengajuan || pengajuan.tanggal || '-';
    
    closeMobileMenu();
}

function batalEditRiwayat() {
    if (confirm('Batalkan edit? Perubahan yang belum disimpan akan hilang.')) {
        document.querySelectorAll('.sidebar li').forEach(li => li.classList.remove('active'));
        document.querySelector('.sidebar li[data-target="page-riwayat"]').classList.add('active');
        document.querySelectorAll('.dashboard-content').forEach(c => c.classList.remove('active'));
        document.getElementById('page-riwayat').classList.add('active');
    }
}

function simpanDraftEditRiwayat() {
    if (!currentUser) return;
    
    const draftData = {
        instansi: document.getElementById('edit_riwayat_instansi').value,
        unitKerja: document.getElementById('edit_riwayat_unitkerja').value,
        namaSE: document.getElementById('edit_riwayat_nama').value,
        versi: document.getElementById('edit_riwayat_versi').value,
        bidang: document.getElementById('edit_riwayat_bidang').value,
        narahubung: document.getElementById('edit_riwayat_narahubung').value,
        telepon: document.getElementById('edit_riwayat_telepon').value,
        url: document.getElementById('edit_riwayat_url').value,
        dns: document.getElementById('edit_riwayat_dns').value,
        deskripsi: document.getElementById('edit_riwayat_deskripsi').value,
        risiko: document.getElementById('edit_riwayat_risiko').value,
        klasifikasi: document.getElementById('edit_riwayat_klasifikasi').value,
        dataPribadi: document.getElementById('edit_riwayat_data_pribadi').value,
        lokasi: document.getElementById('edit_riwayat_lokasi').value,
        dokumen: document.getElementById('edit_riwayat_dokumen').value,
        id: document.getElementById('edit_riwayat_id').value,
        timestamp: new Date().toISOString()
    };
    
    localStorage.setItem('pse_edit_riwayat_draft_' + currentUser.username, JSON.stringify(draftData));
    alert('âœ… Draft perubahan berhasil disimpan!');
}

// ============================================
// FUNGSI UPLOAD FILE
// ============================================
function handleFileUpload(input, targetInputId, infoDivId) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileName = file.name;
        const fileSize = (file.size / 1024).toFixed(2);
        
        const MAX_FILE_SIZE = 100 * 1024 * 1024;
        
        if (file.size > MAX_FILE_SIZE) {
            alert('Ukuran file maksimal 100MB! File Anda sebesar ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB.');
            input.value = '';
            return;
        }
        
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('âŒ Tipe file harus PDF, JPG, atau PNG!');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const fileData = {
                name: fileName,
                size: fileSize,
                type: file.type,
                data: e.target.result,
                uploadedAt: new Date().toLocaleString()
            };
            
            const fileKey = 'pse_upload_' + Date.now();
            localStorage.setItem(fileKey, JSON.stringify(fileData));
            
            const baseId = targetInputId.replace('_file', '');
            uploadedFiles[baseId] = {
                key: fileKey,
                name: fileName,
                size: fileSize
            };
            
            document.getElementById(targetInputId).value = fileName;
            
            const infoDiv = document.getElementById(infoDivId);
            const fileNameSpan = document.getElementById(targetInputId.replace('_file', '_file_name'));
            const fileSizeSpan = document.getElementById(targetInputId.replace('_file', '_file_size'));
            
            if (fileNameSpan) fileNameSpan.textContent = fileName;
            if (fileSizeSpan) fileSizeSpan.textContent = '(' + fileSize + ' KB)';
            
            infoDiv.style.display = 'flex';
            
            alert(`âœ… File "${fileName}" berhasil diupload! (${fileSize} KB)`);
            
            input.value = '';
        };
        reader.readAsDataURL(file);
    }
}

function gantiFile(baseId) {
    const fileInput = document.getElementById(baseId + '_file_input');
    if (fileInput) {
        fileInput.click();
    }
}

// ============================================
// FUNGSI SERTIFIKAT
// ============================================
function lihatSertifikat(id) {
    const se = databaseSETerdaftar.find(s => s.id === id);
    if (!se) {
        alert('Data tidak ditemukan!');
        return;
    }
    
    const tanggalTerbit = se.tanggalTerbit || se.tanggal || '19/02/2026';
    const parts = tanggalTerbit.split('/');
    let tahun = parseInt(parts[2] || '2026');
    let bulan = parts[1] || '02';
    let hari = parts[0] || '19';
    const masaBerlaku = `${hari}/${bulan}/${tahun + 5}`;
    
    const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const bulanIndex = parseInt(bulan) - 1;
    const tanggalJakarta = `${hari} ${bulanIndo[bulanIndex] || 'Februari'} ${tahun}`;
    
    document.getElementById('sertifikatNomor').textContent = se.noTandaDaftar || 'PSE-XXX/2026';
    document.getElementById('sertifikatInstansi').textContent = se.instansi || '-';
    document.getElementById('sertifikatUnitKerja').textContent = se.unitKerja || '-';
    document.getElementById('sertifikatNamaSE').textContent = se.namaSE || '-';
    document.getElementById('sertifikatVersi').textContent = se.versi || '1.0';
    document.getElementById('sertifikatPejabat').textContent = se.pejabat || currentUser?.fullname || 'FITRIANINGSIH';
    document.getElementById('sertifikatTanggal').textContent = se.tanggalTerbit || se.tanggal || '19/02/2026';
    document.getElementById('sertifikatMasaBerlaku').textContent = masaBerlaku;
    document.getElementById('sertifikatRisiko').textContent = se.risiko || 'Strategis';
    document.getElementById('sertifikatKlasifikasi').textContent = se.klasifikasi || 'Terbatas';
    document.getElementById('sertifikatLokasi').textContent = se.lokasi || 'Dalam Negeri';
    document.getElementById('sertifikatJakartaTanggal').textContent = tanggalJakarta;
    document.getElementById('sertifikatNamaInstansi').textContent = se.instansi?.toUpperCase() || 'PEMERINTAH KOTA PROBOLINGGO';
    
    document.getElementById('sertifikatModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function tutupSertifikat() {
    document.getElementById('sertifikatModal').style.display = 'none';
    document.body.style.overflow = '';
}

function cetakSertifikat() {
    window.print();
}

function downloadSertifikat() {
    alert('ðŸ“¥ Download sertifikat dalam format PDF (simulasi)');
}

document.addEventListener('click', function(e) {
    const modal = document.getElementById('sertifikatModal');
    if (e.target === modal) {
        tutupSertifikat();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        tutupSertifikat();
    }
});

// ============================================
// FUNGSI SIDEBAR & NAVIGASI
// ============================================
document.querySelectorAll('.sidebar li').forEach(item => {
    item.addEventListener('click', function() {
        document.querySelectorAll('.sidebar li').forEach(li => li.classList.remove('active'));
        this.classList.add('active');
        
        const targetId = this.getAttribute('data-target');
        document.querySelectorAll('.dashboard-content').forEach(c => c.classList.remove('active'));
        document.getElementById(targetId).classList.add('active');
        
        if (targetId === 'page-riwayat') {
            currentRiwayatFilter = 'semua';
            currentRiwayatPage = 1;
            loadRiwayat();
        }
        if (targetId === 'page-list') {
            currentListFilter = 'semua';
            currentListPage = 1;
            loadListSE();
        }
        if (targetId === 'page-dashboard') {
            loadAktivitas();
            loadRingkasanPengajuan();
            loadRingkasanSE();
            loadDashboardChart();
        }
        if (targetId === 'page-riwayat-pejabat') loadRiwayatPejabat();
        
        closeMobileMenu();
    });
});

const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', () => {
        sidebar.classList.add('open');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    });
}

if (overlay) {
    overlay.addEventListener('click', closeMobileMenu);
}

function closeMobileMenu() {
    sidebar.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

// ============================================
// FUNGSI FORM PENDAFTARAN SE
// ============================================
function showPendaftaranSE() {
    if (!isLoggedIn) {
        alert(' Silakan login terlebih dahulu!');
        showAuth('login');
        return;
    }
    
    document.querySelectorAll('.sidebar li').forEach(li => li.classList.remove('active'));
    document.querySelector('.sidebar li[data-target="page-pendaftaran"]').classList.add('active');
    
    document.querySelectorAll('.dashboard-content').forEach(c => c.classList.remove('active'));
    document.getElementById('page-pendaftaran').classList.add('active');
    
    document.getElementById('btnAjukanPengajuan').style.display = 'none';
}

function resetFormSE(e) {
    if (e) e.preventDefault();
    
    if (!isLoggedIn) {
        alert('Silakan login terlebih dahulu!');
        showAuth('login');
        return;
    }
    
    if (confirm('Apakah Anda yakin ingin mereset form?')) {
        document.getElementById('formPendaftaranSE').reset();
        
        if (currentUser) {
            document.getElementById('se_instansi').value = '';
            document.getElementById('se_narahubung').value = currentUser.fullname || '';
            document.getElementById('se_telepon').value = currentUser.noHP || '';
        }
        
        document.querySelectorAll('#page-pendaftaran input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
        
        document.getElementById('se_risiko_info').style.display = 'none';
        document.getElementById('se_klasifikasi_info').style.display = 'none';
        document.getElementById('se_dokumen_info').style.display = 'none';
        
        uploadedFiles = {};
        
        document.getElementById('btnAjukanPengajuan').style.display = 'none';
    }
}

function saveDraft() {
    if (!isLoggedIn || !currentUser) {
        alert(' Silakan login terlebih dahulu!');
        return;
    }
    
    const draftData = {
        instansi: document.getElementById('se_instansi').value,
        unitKerja: document.getElementById('se_unitkerja').value,
        namaSE: document.getElementById('se_nama').value,
        versi: document.getElementById('se_versi').value,
        bidang: document.getElementById('se_bidang').value,
        narahubung: document.getElementById('se_narahubung').value,
        telepon: document.getElementById('se_telepon').value,
        url: document.getElementById('se_url').value,
        dns: document.getElementById('se_dns').value,
        deskripsi: document.getElementById('se_deskripsi').value,
        risiko: document.getElementById('se_risiko').value,
        klasifikasi: document.getElementById('se_klasifikasi').value,
        dataPribadi: document.getElementById('se_data_pribadi').value,
        lokasi: document.getElementById('se_lokasi').value,
        dokumen: document.getElementById('se_dokumen').value,
        timestamp: new Date().toISOString()
    };
    
    localStorage.setItem('pse_draft_' + currentUser.username, JSON.stringify(draftData));
    
    document.getElementById('btnAjukanPengajuan').style.display = 'inline-flex';
    
    alert('âœ… Draft berhasil disimpan! Silakan lengkapi data dan klik "Ajukan Pengajuan" untuk mengirim.');
}

function loadDraft() {
    if (!currentUser) {
        alert(' Silakan login terlebih dahulu!');
        return;
    }
    
    const draftKey = 'pse_draft_' + currentUser.username;
    const draft = localStorage.getItem(draftKey);
    
    if (draft) {
        const draftData = JSON.parse(draft);
        
        if (confirm('Draft ditemukan. Muat draft terakhir?')) {
            document.getElementById('se_instansi').value = draftData.instansi || '';
            document.getElementById('se_unitkerja').value = draftData.unitKerja || '';
            document.getElementById('se_nama').value = draftData.namaSE || '';
            document.getElementById('se_versi').value = draftData.versi || '';
            document.getElementById('se_bidang').value = draftData.bidang || '';
            document.getElementById('se_narahubung').value = draftData.narahubung || '';
            document.getElementById('se_telepon').value = draftData.telepon || '';
            document.getElementById('se_url').value = draftData.url || '';
            document.getElementById('se_dns').value = draftData.dns || '';
            document.getElementById('se_deskripsi').value = draftData.deskripsi || '';
            document.getElementById('se_risiko').value = draftData.risiko || '';
            document.getElementById('se_klasifikasi').value = draftData.klasifikasi || '';
            document.getElementById('se_data_pribadi').value = draftData.dataPribadi || '';
            document.getElementById('se_lokasi').value = draftData.lokasi || '';
            document.getElementById('se_dokumen').value = draftData.dokumen || '';
            
            alert('âœ… Draft berhasil dimuat!');
        }
    } else {
        alert('Tidak ada draft tersimpan');
    }
}

function ajukanPengajuan() {
    if (!isLoggedIn || !currentUser) {
        alert(' Silakan login terlebih dahulu!');
        return;
    }
    
    const checkboxes = document.querySelectorAll('#page-pendaftaran input[type="checkbox"]:checked');
    
    if (checkboxes.length !== 4) {
        alert('Harap centang SEMUA (4) pernyataan kepatuhan!');
        return;
    }
    
    const namaSE = document.getElementById('se_nama').value;
    if (!namaSE) {
        alert(' Nama Sistem Elektronik harus diisi!');
        return;
    }
    
    const bidang = document.getElementById('se_bidang').value;
    if (!bidang || bidang === '') {
        alert(' Bidang/Sektor harus dipilih!');
        return;
    }

    const unitKerja = document.getElementById('se_unitkerja').value;
    if (!unitKerja || unitKerja === '') {
        alert('Unit Kerja harus dipilih!');
        return;
    }
    
    const dataPengajuan = {
        instansi: document.getElementById('se_instansi').value || '-',
        unitKerja: document.getElementById('se_unitkerja').value || '-',
        namaSE: document.getElementById('se_nama').value,
        versi: document.getElementById('se_versi').value || '-',
        bidang: document.getElementById('se_bidang').value,
        narahubung: document.getElementById('se_narahubung').value || currentUser?.fullname || '-',
        telepon: document.getElementById('se_telepon').value || currentUser?.noHP || '-',
        url: document.getElementById('se_url').value || '-',
        dns: document.getElementById('se_dns').value || '-',
        deskripsi: document.getElementById('se_deskripsi').value || '-',
        risiko: document.getElementById('se_risiko').value,
        klasifikasi: document.getElementById('se_klasifikasi').value,
        dataPribadi: document.getElementById('se_data_pribadi').value || '-',
        lokasi: document.getElementById('se_lokasi').value || '-',
        dokumen: document.getElementById('se_dokumen').value || '-',
        pengaju: currentUser?.username
    };
    
    const btn = document.getElementById('btnAjukanPengajuan');
    const originalText = btn.innerHTML;
    btn.innerHTML = 'â³ Mengirim...';
    btn.disabled = true;
    
    setTimeout(() => {
        simpanPengajuan(dataPengajuan);
        
        alert('ðŸŽ‰ Pengajuan berhasil dikirim! Silakan cek di menu Riwayat Pengajuan.');
        
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        btn.style.display = 'none';
        
        updateDashboardStats();
        
        document.getElementById('formPendaftaranSE').reset();
        if (currentUser) {
            document.getElementById('se_instansi').value = '';
            document.getElementById('se_narahubung').value = currentUser.fullname || '';
            document.getElementById('se_telepon').value = currentUser.noHP || '';
        }
        
        document.getElementById('se_risiko_info').style.display = 'none';
        document.getElementById('se_klasifikasi_info').style.display = 'none';
        document.getElementById('se_dokumen_info').style.display = 'none';
        
        uploadedFiles = {};
        
        loadAllData();
        
    }, 1500);
}

// ============================================
// FUNGSI DETAIL DAN FILTER
// ============================================
function detailPengajuan(id) {
    const pengajuan = databasePengajuan.find(p => p.id === id);
    if (pengajuan) {
        let pesan = `ðŸ“‹ DETAIL PENGAJUAN\n\n`;
        pesan += `Nomor: ${pengajuan.nomorPengajuan}\n`;
        pesan += `Tanggal: ${pengajuan.tanggalPengajuan || pengajuan.tanggal}\n`;
        pesan += `Nama SE: ${pengajuan.namaSE}\n`;
        pesan += `Instansi: ${pengajuan.instansi}\n`;
        pesan += `Unit Kerja: ${pengajuan.unitKerja || '-'}\n`;
        pesan += `Bidang: ${pengajuan.bidang}\n`;
        pesan += `Narahubung: ${pengajuan.narahubung}\n`;
        pesan += `Kategori Risiko: ${pengajuan.risiko || '-'}\n`;
        pesan += `Klasifikasi Data: ${pengajuan.klasifikasi || '-'}\n`;
        pesan += `Data Pribadi: ${pengajuan.dataPribadi || '-'}\n`;
        pesan += `Lokasi: ${pengajuan.lokasi || '-'}\n`;
        pesan += `Status: ${pengajuan.status}\n`;
        pesan += `URL: ${pengajuan.url || '-'}`;
        
        alert(pesan);
    }
}

function detailSE(id) {
    lihatSertifikat(id);
}

function filterListSE() {
    if (!currentUser) return;
    
    const namaFilter = document.getElementById('filterNamaSE').value.toLowerCase();
    const instansiFilter = document.getElementById('filterInstansi').value.toLowerCase();
    const statusFilter = document.getElementById('filterStatus').value;
    
    let filtered = databaseSETerdaftar;
    
    if (namaFilter) {
        filtered = filtered.filter(item => item.namaSE?.toLowerCase().includes(namaFilter));
    }
    if (instansiFilter) {
        filtered = filtered.filter(item => item.instansi?.toLowerCase().includes(instansiFilter));
    }
    if (statusFilter && statusFilter !== 'Semua Status') {
        if (statusFilter === 'Menunggu Penerbitan Sertifikat') {
            filtered = filtered.filter(item => item.status === ' Menunggu Sertifikat');
        } else if (statusFilter === ' Terbit') {
            filtered = filtered.filter(item => item.status === 'Terbit');
        } else if (statusFilter === ' Ditolak') {
            filtered = filtered.filter(item => item.status === 'Ditolak');
        } else if (statusFilter === ' Dihapus') {
            filtered = filtered.filter(item => item.status === 'Dihapus');
        } else if (statusFilter === '”„ Permintaan Pembaharuan') {
            filtered = filtered.filter(item => item.status.includes('Pembaharuan'));
        } else if (statusFilter === 'â›” Permintaan Penghapusan') {
            filtered = filtered.filter(item => item.status.includes('Penghapusan'));
        }
    }
    
    const tbody = document.getElementById('listSEBody');
    if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Tidak ada data yang cocok</td></tr>';
        document.getElementById('listSEInfo').innerHTML = 'ðŸ‘ï¸ View 0 dari 0';
        return;
    }
    
    let html = '';
    filtered.forEach(item => {
        const badgeClass = item.status === 'âœ… Terbit' ? 'badge-green' : 
                          item.status === 'âŒ Ditolak' ? 'badge-red' : 
                          item.status === 'ðŸ”„ Dalam Pembaharuan' ? 'badge-orange' : 'badge-blue';
        
        html += `<tr>
            <td>
                <div style="display: flex; gap: 5px;">
                    <button class="icon-btn" onclick="detailSE(${item.id})" title="Lihat Sertifikat">ðŸ“„</button>
                    <button class="icon-btn icon-btn-danger" onclick="hapusSETerdaftar(${item.id})" title="Hapus">ðŸ—‘ï¸</button>
                </div>
            </td>
            <td>${item.instansi || '-'} / ${item.unitKerja || '-'}</td>
            <td>${item.namaSE || '-'} / ${item.pejabat || '-'}</td>
            <td><span class="badge ${badgeClass}">${item.status || 'âœ… Terbit'}</span></td>
            <td>${item.tanggalTerbit || item.tanggal || '-'}</td>
            <td>${item.noTandaDaftar || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
    document.getElementById('listSEInfo').innerHTML = `ðŸ‘ï¸ View 1 - ${filtered.length} dari ${filtered.length}`;
}

function filterRiwayat() {
    if (!currentUser) return;
    
    const namaFilter = document.getElementById('filterRiwayatNama').value.toLowerCase();
    const instansiFilter = document.getElementById('filterRiwayatInstansi').value.toLowerCase();
    const statusFilter = document.getElementById('filterRiwayatStatus').value;
    
    let filtered = databasePengajuan;
    
    if (namaFilter) {
        filtered = filtered.filter(item => item.namaSE?.toLowerCase().includes(namaFilter));
    }
    if (instansiFilter) {
        filtered = filtered.filter(item => item.instansi?.toLowerCase().includes(instansiFilter));
    }
    if (statusFilter && statusFilter !== 'Semua Status') {
        if (statusFilter === 'â³ Menunggu Verifikasi') {
            filtered = filtered.filter(item => item.status === 'Menunggu Verifikasi');
        } else if (statusFilter === 'âœ… Diterima') {
            filtered = filtered.filter(item => item.status === 'âœ… Diterima');
        } else if (statusFilter === 'âŒ Ditolak') {
            filtered = filtered.filter(item => item.status === 'âŒ Ditolak');
        } else if (statusFilter === 'ðŸ—‘ï¸ Dihapus') {
            filtered = filtered.filter(item => item.status === 'ðŸ—‘ï¸ Dihapus');
        } else if (statusFilter === 'ðŸ”„ Pembaharuan') {
            filtered = filtered.filter(item => item.status.includes('Pembaharuan'));
        } else if (statusFilter === 'â›” Penghapusan') {
            filtered = filtered.filter(item => item.status.includes('Penghapusan'));
        }
    }
    
    const tbody = document.getElementById('riwayatBody');
    if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Tidak ada data yang cocok</td></tr>';
        document.getElementById('riwayatInfo').innerHTML = 'ðŸ‘ï¸ View 0 dari 0';
        return;
    }
    
    let html = '';
    filtered.forEach(item => {
        const badgeClass = item.status === 'âœ… Diterima' ? 'badge-green' : 
                          item.status === 'âŒ Ditolak' ? 'badge-red' : 'badge-orange';
        
        let jenisPengajuan = 'ðŸ“ Pendaftaran';
        if (item.jenis === 'Pembaharuan' || item.status.includes('Pembaharuan')) {
            jenisPengajuan = 'ðŸ”„ Pembaharuan';
        } else if (item.jenis === 'Penghapusan' || item.status.includes('Penghapusan')) {
            jenisPengajuan = 'â›” Penghapusan';
        }
        
        html += `<tr>
            <td>
                <div style="display: flex; gap: 5px;">
                    <button class="icon-btn" onclick="detailPengajuan(${item.id})">ðŸ“„</button>
                    <button class="icon-btn icon-btn-success" onclick="approvePengajuan(${item.id})">âœ…</button>
                    <button class="icon-btn icon-btn-danger" onclick="tolakPengajuan(${item.id})">âŒ</button>
                    <button class="icon-btn icon-btn-warning" onclick="mintaPembaharuan(${item.id})">ðŸ”„</button>
                    <button class="icon-btn icon-btn-danger" onclick="mintaPenghapusan(${item.id})">â›”</button>
                    <button class="icon-btn icon-btn-secondary" onclick="hapusPengajuan(${item.id})">ðŸ—‘ï¸</button>
                </div>
            </td>
            <td><span class="badge ${badgeClass}">${jenisPengajuan}</span></td>
            <td><span class="badge ${badgeClass}">${item.statusText || item.status}</span></td>
            <td>${item.namaSE || '-'}</td>
            <td>${item.tanggalPengajuan || item.tanggal || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
    document.getElementById('riwayatInfo').innerHTML = `ðŸ‘ï¸ View 1 - ${filtered.length} dari ${filtered.length}`;
}

// ============================================
// FUNGSI PUBLIC
// ============================================
function cariPublicPSE() {
    const keyword = document.getElementById('cariPublicInput').value.toLowerCase();
    
    if (!keyword) {
        alert('ðŸ” Masukkan kata kunci pencarian');
        return;
    }
    
    // Data demo untuk pencarian publik
    const allData = [
        { namaSE: 'SP4N-Lapor Probolinggo', instansi: 'Diskominfo', tanggalTerbit: '10 Feb 2026', noTandaDaftar: 'PSE-001/2026' },
        { namaSE: 'SIMDA Kepegawaian', instansi: 'BKD', tanggalTerbit: '15 Jan 2026', noTandaDaftar: 'PSE-045/2026' },
        { namaSE: 'SIPD Probolinggo', instansi: 'Bappeda', tanggalTerbit: '20 Des 2025', noTandaDaftar: 'PSE-089/2025' },
        { namaSE: 'E-Puskesmas', instansi: 'Dinkes', tanggalTerbit: '5 Feb 2026', noTandaDaftar: 'PSE-012/2026' },
        { namaSE: 'SIMPEG Kota', instansi: 'BKPSDM', tanggalTerbit: '12 Jan 2026', noTandaDaftar: 'PSE-056/2026' }
    ];
    
    const results = allData.filter(item => 
        (item.namaSE && item.namaSE.toLowerCase().includes(keyword)) || 
        (item.instansi && item.instansi.toLowerCase().includes(keyword))
    );
    
    const tbody = document.getElementById('publicCariBody');
    
    if (results.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Tidak ada data yang ditemukan</td></tr>';
    } else {
        let html = '';
        results.slice(0, 10).forEach((item, index) => {
            html += `<tr>
                <td>${index + 1}</td>
                <td>${item.namaSE || '-'}</td>
                <td>${item.instansi || '-'}</td>
                <td><span class="badge badge-success">Aktif</span></td>
                <td>${item.tanggalTerbit || item.tanggal || '-'}</td>
                <td>${item.noTandaDaftar || '-'}</td>
            </tr>`;
        });
        tbody.innerHTML = html;
    }
}

// ============================================
// FUNGSI PROFIL
// ============================================
function updateProfile() {
    const nama = document.getElementById('profil_nama').value;
    const nip = document.getElementById('profil_nip').value;
    const jabatan = document.getElementById('profil_jabatan').value;
    const alamat = document.getElementById('profil_alamat').value;
    const email = document.getElementById('profil_email').value;
    const telp = document.getElementById('profil_telp').value;
    
    if (currentUser) {
        currentUser.fullname = nama;
        currentUser.nip = nip;
        currentUser.jabatan = jabatan;
        currentUser.email = email;
        currentUser.noHP = telp;
        
        localStorage.setItem('pseUser_' + currentUser.username, JSON.stringify(currentUser));
        
        document.getElementById('profilNama').textContent = nama;
        document.getElementById('profilAvatar').textContent = nama.charAt(0);
        
        document.querySelectorAll('#dashboardUserName, #pendaftaranUserName, #listUserName, #riwayatUserName, #profilUserName, #riwayatPejabatUserName, #panduanUserName, #laporanUserName, #settingUserName, #editRiwayatUserName').forEach(el => {
            if (el) el.textContent = nama;
        });
        
        alert('âœ… Profil berhasil diupdate!');
    } else {
        alert('âŒ Silakan login terlebih dahulu!');
    }
}

// ============================================
// FUNGSI LAPORAN
// ============================================
function downloadLaporan(jenis) {
    if (jenis === 'bulanan') {
        const bulan = document.getElementById('laporanBulan').value;
        alert(`ðŸ“¥ Download laporan bulanan: ${bulan} (PDF)`);
    } else if (jenis === 'tahunan') {
        const tahun = document.getElementById('laporanTahun').value;
        alert(`ðŸ“¥ Download laporan tahunan: ${tahun} (Excel)`);
    }
}

// ============================================
// FUNGSI PENGATURAN
// ============================================
function updatePassword() {
    if (!currentUser) {
        alert('âŒ Silakan login terlebih dahulu!');
        return;
    }
    
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (!currentPassword || !newPassword || !confirmPassword) {
        alert('âŒ Lengkapi semua field password');
        return;
    }
    
    if (currentUser.password && currentUser.password !== currentPassword) {
        const isDemoAccount = demoAccounts.some(acc => acc.username === currentUser.username);
        if (isDemoAccount) {
            if (!confirm('âš ï¸ Ini adalah akun demo. Password tidak akan benar-benar berubah. Lanjutkan simulasi?')) {
                return;
            }
        } else {
            alert('âŒ Password saat ini salah');
            return;
        }
    }
    
    if (!validatePassword(newPassword)) {
        alert('âŒ Password baru harus 8-16 karakter dan mengandung huruf dan angka');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        alert('âŒ Konfirmasi password tidak cocok');
        return;
    }
    
    if (currentUser.password) {
        currentUser.password = newPassword;
        localStorage.setItem('pseUser_' + currentUser.username, JSON.stringify(currentUser));
        alert('âœ… Password berhasil diubah!');
    } else {
        alert('âœ… (Demo) Password berhasil diubah!');
    }
    
    document.getElementById('currentPassword').value = '';
    document.getElementById('newPassword').value = '';
    document.getElementById('confirmPassword').value = '';
}

function saveNotificationSettings() {
    const emailNotif = document.getElementById('emailNotif').checked;
    const smsNotif = document.getElementById('smsNotif').checked;
    
    alert(`âœ… Pengaturan notifikasi disimpan!\nðŸ“§ Email: ${emailNotif ? 'Aktif' : 'Nonaktif'}\nðŸ“± SMS: ${smsNotif ? 'Aktif' : 'Nonaktif'}`);
}

function saveDisplaySettings() {
    const theme = document.getElementById('themeMode').value;
    const fontSize = document.getElementById('fontSize').value;
    
    alert(`âœ… Pengaturan tampilan disimpan!\nðŸŽ¨ Tema: ${theme}\nðŸ“ Ukuran Font: ${fontSize}`);
}

// ============================================
// EVENT LISTENERS
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    initDatabase();
    
    const formSE = document.getElementById('formPendaftaranSE');
    if (formSE) {
        formSE.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    }
    
    const formEditRiwayat = document.getElementById('formEditRiwayat');
    if (formEditRiwayat) {
        formEditRiwayat.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!currentUser) {
                alert('âŒ Silakan login terlebih dahulu!');
                return;
            }
            
            const checkboxes = document.querySelectorAll('#page-edit-riwayat input[type="checkbox"]:checked');
            if (checkboxes.length !== 4) {
                alert('âŒ Harap centang SEMUA (4) pernyataan kepatuhan!');
                return;
            }
            
            const namaSE = document.getElementById('edit_riwayat_nama').value;
            if (!namaSE) {
                alert('âŒ Nama Sistem Elektronik harus diisi!');
                return;
            }
            
            alert('âœ… Perubahan berhasil dikirim! Data akan diperbarui setelah diverifikasi.');
            
            document.querySelectorAll('.sidebar li').forEach(li => li.classList.remove('active'));
            document.querySelector('.sidebar li[data-target="page-riwayat"]').classList.add('active');
            document.querySelectorAll('.dashboard-content').forEach(c => c.classList.remove('active'));
            document.getElementById('page-riwayat').classList.add('active');
        });
    }
    
    const ctx = document.getElementById('pseChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['PSE Pemerintah', 'PSE Swasta'],
                datasets: [{
                    data: [72, 28],
                    backgroundColor: ['#3b82f6', '#10b981'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#f1f5f9' }
                    }
                },
                cutout: '65%'
            }
        });
    }
    
    document.querySelectorAll('.nav-menu a').forEach(a => {
        a.onclick = function(e) {
            if (isLoggedIn) {
                e.preventDefault();
                alert('âŒ Anda sudah login. Silakan logout terlebih dahulu untuk mengakses halaman public.');
                return;
            }
            
            e.preventDefault();
            document.querySelectorAll('.nav-menu a').forEach(x => x.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.content').forEach(c => c.classList.remove('active'));
            document.getElementById(this.dataset.page).classList.add('active');
        };
    });
    
    // Tambahkan tombol load draft di form pendaftaran
    const formActions = document.querySelector('.se-actions');
    if (formActions && !document.querySelector('.btn-se-load')) {
        const loadBtn = document.createElement('button');
        loadBtn.type = 'button';
        loadBtn.className = 'btn-se-load';
        loadBtn.onclick = loadDraft;
        loadBtn.innerHTML = '<i class="fas fa-upload"></i> Muat Draft';
        formActions.insertBefore(loadBtn, formActions.firstChild);
    }
});

document.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        if (document.getElementById('loginForm').classList.contains('active') && 
            document.getElementById('authModal').style.display === 'flex') {
            handleLogin();
        }
    }
});

window.onload = function() {
    console.log('âœ… Portal PSE - PHP Mode Active');
};
</script>

<!-- PHP Data Injection -->
<script>
<?php if($is_logged_in): ?>
    // Inject PHP data into JS variables for charts and details
    currentUser = {
        username: "<?php echo $_SESSION['username']; ?>",
        fullname: "<?php echo $_SESSION['fullname']; ?>",
        role: "<?php echo $_SESSION['role']; ?>"
    };

    // Populate databasePengajuan from PHP
    const databasePengajuan = <?php 
        $rows = [];
        $uid = $_SESSION['user_id'];
        $q = mysqli_query($koneksi, "SELECT * FROM layanan_se WHERE user_id='$uid'");
        while($r = mysqli_fetch_assoc($q)) {
            // Map keys to match JS expectation
            $r['namaSE'] = $r['nama_se'];
            $r['tanggalPengajuan'] = $r['tanggal_pengajuan'];
            $r['statusText'] = $r['status']; // simple mapping
            $rows[] = $r;
        }
        echo json_encode($rows);
    ?>;

    // Populate databaseSETerdaftar from PHP
    databaseSETerdaftar = <?php 
        $rows = [];
        $uid = $_SESSION['user_id'];
        $q = mysqli_query($koneksi, "SELECT * FROM layanan_se WHERE user_id='$uid' AND status='Diterima'");
        while($r = mysqli_fetch_assoc($q)) {
            $r['namaSE'] = $r['nama_se'];
            $r['tanggalTerbit'] = $r['tanggal_terbit'];
            $r['noTandaDaftar'] = $r['nomor_tanda_daftar'];
            $rows[] = $r;
        }
        echo json_encode($rows);
    ?>;

    // Override functions that would overwrite PHP content
    function loadRiwayat() { console.log("Skipping loadRiwayat (PHP Mode)"); }
    function loadListSE() { console.log("Skipping loadListSE (PHP Mode)"); }
    
    // Update charts
    setTimeout(() => {
        updateDashboardStats();
        loadDashboardChart();
    }, 500);
<?php endif; ?>
</script>

</body>
</html>
