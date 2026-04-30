<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// AMBIL DATA USER TERBARU DARI DATABASE (AGAR SELALU UPDATE TANPA RELOGIN)
$user_id = $_SESSION['user_id'];
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id'");
$user_data = mysqli_fetch_assoc($query_user);

// Update session dengan data terbaru (opsional, tapi bagus untuk konsistensi)
if ($user_data) {
    $_SESSION['fullname'] = $user_data['fullname'];
    $_SESSION['role'] = $user_data['role'];
    // ... update session lain jika perlu
}

$is_logged_in = true;
$user_fullname = $user_data['fullname']; // Gunakan data terbaru
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
    background: #f1f5f9; /* Clean light background */
    min-height: 100vh;
    color: #334155;
    overflow-x: hidden;
    position: relative;
}

/* Removed floating animation body::before for clean look */

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

.app-wrapper {
    display: flex;
    width: 100%;
    min-height: 100vh;
}

/* MODERN SIDEBAR */
.sidebar {
    width: 260px;
    background: #ffffff;
    border-right: 1px solid #e2e8f0;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    box-shadow: 4px 0 24px rgba(0, 0, 0, 0.02);
}

.sidebar-header {
    padding: 2rem 1.5rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    border-bottom: 1px solid #f1f5f9;
    text-align: center;
}

.sidebar-header img {
    height: 65px;
    width: auto;
    margin-bottom: 5px;
    transition: transform 0.3s ease;
}

.sidebar-header img:hover {
    transform: scale(1.05);
}

.sidebar-header div {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.sidebar-header h3 {
    font-size: 1.1rem;
    color: #1e293b;
    font-weight: 800;
    margin: 0;
    line-height: 1.3;
    letter-spacing: -0.5px;
}

.sidebar-header p {
    font-size: 0.8rem;
    color: #64748b;
    margin: 4px 0 0 0;
    font-weight: 500;
    background: #f1f5f9;
    padding: 2px 10px;
    border-radius: 12px;
}

.sidebar-menu {
    padding: 1.5rem 1rem;
    flex: 1;
    overflow-y: auto;
}

.sidebar-menu h3 {
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #94a3b8;
    letter-spacing: 1px;
    margin-bottom: 1rem;
    padding-left: 12px;
    font-weight: 600;
}

.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar li {
    padding: 12px 16px;
    font-size: 0.9rem;
    color: #475569;
    cursor: pointer;
    border-radius: 8px;
    margin-bottom: 4px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 500;
}

.sidebar li i {
    width: 20px;
    font-size: 1.1rem;
    color: #94a3b8;
    transition: all 0.2s ease;
    text-align: center;
}

.sidebar li:hover {
    background: #f8fafc;
    color: #1e293b;
}

.sidebar li:hover i {
    color: #3b82f6;
}

.sidebar li.active {
    background: #eff6ff;
    color: #2563eb;
    font-weight: 600;
}

.sidebar li.active i {
    color: #2563eb;
}

.sidebar-footer {
    padding: 1rem;
    border-top: 1px solid #f1f5f9;
}

/* TOP NAVBAR */
.top-navbar {
    height: 70px;
    background: white;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 2rem;
    position: sticky;
    top: 0;
    z-index: 900;
}

.nav-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.sidebar-toggle-btn {
    background: none;
    border: none;
    font-size: 1.2rem;
    color: #64748b;
    cursor: pointer;
    padding: 5px;
}

.nav-title {
    font-weight: 600;
    color: #1e293b;
    font-size: 1.1rem;
    display: none;
}

.nav-right {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-info {
    text-align: right;
}

.user-name {
    font-weight: 600;
    font-size: 0.9rem;
    color: #1e293b;
    display: block;
}

.user-role {
    font-size: 0.75rem;
    color: #64748b;
    display: block;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.1rem;
}

/* MAIN CONTENT REFACTOR */
.main-content {
    flex: 1;
    margin-left: 260px; /* Same as sidebar width */
    background: #f1f5f9;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* DASHBOARD CONTENT CLEANUP */
.dashboard-content {
    display: none;
    padding: 2rem;
    animation: fadeIn 0.4s ease;
}


.dashboard-content.active {
    display: block;
}

/* RESPONSIVE & TOGGLE */
@media (min-width: 992px) {
    .sidebar.closed {
        transform: translateX(-100%);
    }
    
    .main-content {
        transition: margin-left 0.3s ease;
    }
    
    .main-content.expanded {
        margin-left: 0;
    }
}

@media (max-width: 991px) {
    .sidebar {
        transform: translateX(-100%);
        box-shadow: none;
    }
    
    .sidebar.active {
        transform: translateX(0);
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.1);
    }
    
    .main-content {
        margin-left: 0;
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
    
    .overlay.active {
        display: block;
    }
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
    display: grid;
    grid-template-columns: 24px 1fr;
    column-gap: 12px;
    align-items: start;
    margin-bottom: 12px;
    padding: 12px;
    background: #ffffff;
    border-radius: 8px;
}

.checkbox-item input[type="checkbox"] {
    width: 20px;
    height: 20px;
    margin: 2px 0 0 0;
    accent-color: #3b82f6;
}

.checkbox-item label {
    color: #1e293b;
    font-size: 0.95rem;
    line-height: 1.6;
    display: block;
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
    background: #ffffff;
    color: #3b82f6;
    border: 1px solid #3b82f6;
}

.btn-se-draft:hover {
    background: #eff6ff;
    color: #1e40af;
    border-color: #1e40af;
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
    background: white;
    padding: 2.5rem;
    border-radius: 24px;
    width: 500px;
    max-width: 95vw;
    position: relative;
    box-shadow: 0 50px 100px rgba(0, 0, 0, 0.4);
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

.auth-box button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
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
    background: #ffffff;
    border-radius: 24px;
    width: 900px;
    max-width: 95vw;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35);
    animation: slideUp 0.5s ease;
    border: 1px solid #e2e8f0;
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
    background: #ffffff;
    color: #1e293b;
    padding: 1.25rem 1.75rem;
    border-radius: 24px 24px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e2e8f0;
}

.sertifikat-header::before {
    content: none;
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
    border-top: 1px solid #e2e8f0;
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
.nip-error, .email-error, #regNipError, #regEmailError, #nipError, #emailError {
    display: none !important;
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

<div class="app-wrapper" id="appWrapper">
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="Logo Diskominfo Solusi.png" alt="Logo DisKominfo" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2264%22 height=%2264%22 viewBox=%220 0 48 48%22><rect width=%2248%22 height=%2248%22 fill=%22%233b82f6%22 rx=%2212%22/><text x=%2224%22 y=%2232%22 font-size=%2220%22 font-weight=%22bold%22 text-anchor=%22middle%22 fill=%22white%22>PSE</text></svg>'">
            <div>
                <h3>PSE DisKominfo</h3>
                <p>User Dashboard</p>
            </div>
        </div>

        <div class="sidebar-menu">
            <h3>Menu Utama</h3>
            <ul>
                <li data-target="page-dashboard" class="active">
                    <i class="fas fa-home"></i> Dashboard
                </li>
                <li data-target="page-list">
                    <i class="fas fa-list-ul"></i> List SE Terdaftar
                </li>
                <li data-target="page-riwayat">
                    <i class="fas fa-history"></i> Riwayat Pengajuan
                </li>
                <!-- 
                <li data-target="page-riwayat-pejabat">
                    <i class="fas fa-user-clock"></i> Riwayat Pejabat
                </li> 
                -->
                <li data-target="page-pendaftaran" style="display: none;">
                    <i class="fas fa-file-signature"></i> Pendaftaran SE
                </li>
            </ul>

            <h3>Akun & Lainnya</h3>
            <ul>
                <li data-target="page-profil">
                    <i class="fas fa-user-circle"></i> Profil Penjabat
                </li>
                <li data-target="page-panduan-pengguna">
                    <i class="fas fa-book"></i> Panduan
                </li>
                <li data-target="page-laporan">
                    <i class="fas fa-chart-line"></i> Laporan
                </li>
                <li data-target="page-setting">
                    <i class="fas fa-cog"></i> Pengaturan
                </li>
                <li data-target="page-edit-riwayat" style="display: none;">
                    <i class="fas fa-edit"></i> Edit Pengajuan
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <a href="logout.php" style="text-decoration: none; display: flex; align-items: center; gap: 10px; color: #ef4444; font-weight: 600; padding: 10px; border-radius: 8px; transition: all 0.3s; background: #fef2f2;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- TOP NAVBAR -->
        <nav class="top-navbar">
            <div class="nav-left">
                <button class="sidebar-toggle-btn" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="nav-title" id="pageTitle" style="display: block;">Dashboard</div>
            </div>
            
            <div class="nav-right">
                <div class="user-profile">
                    <div class="user-info">
                        <span class="user-name"><?php echo htmlspecialchars($user_fullname); ?></span>
                        <span class="user-role">User Terdaftar</span>
                    </div>
                    <div class="user-avatar">
                        <?php 
                        $initials = "";
                        $words = explode(" ", $user_fullname);
                        foreach ($words as $w) {
                            $initials .= strtoupper(substr($w, 0, 1));
                            if (strlen($initials) >= 2) break;
                        }
                        echo $initials;
                        ?>
                    </div>
                </div>
            </div>
        </nav>

        <!-- DASHBOARD CONTENT -->
        <div id="page-dashboard" class="dashboard-content active">
            <div class="dashboard-header" style="border-bottom: none; margin-bottom: 2rem; padding: 0;">
                <div>
                    <?php 
                    $first_name = $is_logged_in ? explode(' ', $user_fullname)[0] : 'Tamu';
                    ?>
                    <h2 style="font-size: 1.8rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Selamat Datang, <?php echo htmlspecialchars($first_name); ?>! 👋</h2>
                    <p style="color: #64748b; font-size: 0.95rem;">Berikut adalah ringkasan aktivitas sistem elektronik Anda.</p>
                </div>
                <div class="user-badge" style="background: white; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <i class="fas fa-calendar-alt" style="color: #3b82f6;"></i> <span style="color: #334155; font-weight: 600;"><?php echo date('d M Y'); ?></span>
                </div>
            </div>
            
            <?php
            // MENGAMBIL DATA REAL DARI DATABASE UNTUK DASHBOARD
            $total_pengajuan = 0; $total_diterima = 0; $total_menunggu = 0; $total_ditolak = 0;
            
            if ($is_logged_in) {
                $user_id = $_SESSION['user_id'];
                
                // Hitung Total Pengajuan
                $q_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM layanan_se WHERE user_id = '$user_id'");
                $d_total = mysqli_fetch_assoc($q_total);
                $total_pengajuan = $d_total['total'];
                
                // Hitung Status Diterima/Terbit
                $q_terima = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM layanan_se WHERE user_id = '$user_id' AND (status = 'Diterima' OR status = 'Terbit')");
                $d_terima = mysqli_fetch_assoc($q_terima);
                $total_diterima = $d_terima['total'];
                
                // Hitung Status Menunggu
                $q_tunggu = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM layanan_se WHERE user_id = '$user_id' AND (status = 'Menunggu' OR status = 'Menunggu Verifikasi')");
                $d_tunggu = mysqli_fetch_assoc($q_tunggu);
                $total_menunggu = $d_tunggu['total'];
                
                // Hitung Status Ditolak
                $q_tolak = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM layanan_se WHERE user_id = '$user_id' AND status = 'Ditolak'");
                $d_tolak = mysqli_fetch_assoc($q_tolak);
                $total_ditolak = $d_tolak['total'];
            }
            ?>
            
            <!-- STATS CARDS GRID -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <!-- Card Total Pengajuan -->
                <div style="background: white; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 50px; height: 50px; background: #eff6ff; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-file-alt" style="color: #3b82f6; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <p style="color: #64748b; font-size: 0.85rem; margin: 0 0 0.2rem 0; font-weight: 600;">Total Pengajuan</p>
                        <h3 style="color: #1e293b; font-size: 1.8rem; font-weight: 700; margin: 0;"><?php echo $total_pengajuan; ?></h3>
                    </div>
                </div>
                
                <!-- Card Menunggu Verifikasi -->
                <div style="background: white; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 50px; height: 50px; background: #fff7ed; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock" style="color: #f59e0b; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <p style="color: #64748b; font-size: 0.85rem; margin: 0 0 0.2rem 0; font-weight: 600;">Menunggu Verifikasi</p>
                        <h3 style="color: #1e293b; font-size: 1.8rem; font-weight: 700; margin: 0;"><?php echo $total_menunggu; ?></h3>
                    </div>
                </div>
                
                <!-- Card Terbit/Diterima -->
                <div style="background: white; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 50px; height: 50px; background: #ecfdf5; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle" style="color: #10b981; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <p style="color: #64748b; font-size: 0.85rem; margin: 0 0 0.2rem 0; font-weight: 600;">Terbit / Diterima</p>
                        <h3 style="color: #1e293b; font-size: 1.8rem; font-weight: 700; margin: 0;"><?php echo $total_diterima; ?></h3>
                    </div>
                </div>
                
                <!-- Card Ditolak -->
                <div style="background: white; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 1rem; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 50px; height: 50px; background: #fef2f2; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-times-circle" style="color: #ef4444; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <p style="color: #64748b; font-size: 0.85rem; margin: 0 0 0.2rem 0; font-weight: 600;">Ditolak</p>
                        <h3 style="color: #1e293b; font-size: 1.8rem; font-weight: 700; margin: 0;"><?php echo $total_ditolak; ?></h3>
                    </div>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
                <!-- TABEL RINGKASAN PENGAJUAN TERBARU -->
                <div class="card" style="background: white; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                        <h3 style="color: #1e293b; font-size: 1.1rem; font-weight: 700; margin: 0;"><i class="fas fa-history" style="color: #3b82f6; margin-right: 8px;"></i> Aktivitas Terbaru</h3>
                        <button onclick="document.querySelector('[data-target=\'page-riwayat\']').click();" style="background: none; border: none; color: #3b82f6; font-size: 0.9rem; font-weight: 600; cursor: pointer;">Lihat Semua <i class="fas fa-arrow-right"></i></button>
                    </div>
                    
                    <div class="table-container" style="overflow-x: auto;">
                        <table class="table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f8fafc; text-align: left;">
                                    <th style="padding: 12px 16px; color: #64748b; font-size: 0.85rem; font-weight: 600; border-bottom: 1px solid #e2e8f0;">Sistem Elektronik</th>
                                    <th style="padding: 12px 16px; color: #64748b; font-size: 0.85rem; font-weight: 600; border-bottom: 1px solid #e2e8f0;">Tanggal</th>
                                    <th style="padding: 12px 16px; color: #64748b; font-size: 0.85rem; font-weight: 600; border-bottom: 1px solid #e2e8f0;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($is_logged_in) {
                                    $q_latest = mysqli_query($koneksi, "SELECT * FROM layanan_se WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 5");
                                    if (mysqli_num_rows($q_latest) > 0) {
                                        while ($row = mysqli_fetch_assoc($q_latest)) {
                                            $statusBadge = 'badge-orange';
                                            $statusIcon = 'fa-clock';
                                            
                                            if ($row['status'] == 'Diterima' || $row['status'] == 'Terbit') {
                                                $statusBadge = 'badge-green';
                                                $statusIcon = 'fa-check-circle';
                                            } elseif ($row['status'] == 'Ditolak') {
                                                $statusBadge = 'badge-red';
                                                $statusIcon = 'fa-times-circle';
                                            }
                                            
                                            $tgl = isset($row['created_at']) && $row['created_at'] ? date('d M Y', strtotime($row['created_at'])) : (isset($row['tanggal_pengajuan']) ? $row['tanggal_pengajuan'] : '-');
                                            
                                            echo "<tr style='border-bottom: 1px solid #f1f5f9;'>";
                                            echo "<td style='padding: 16px; font-weight: 500; color: #334155;'>" . htmlspecialchars($row['nama_se']) . "</td>";
                                            echo "<td style='padding: 16px; color: #64748b; font-size: 0.9rem;'>" . $tgl . "</td>";
                                            echo "<td style='padding: 16px;'><span class='badge $statusBadge' style='display: inline-flex; align-items: center; gap: 5px; font-size: 0.8rem;'><i class='fas $statusIcon'></i> " . htmlspecialchars($row['status']) . "</span></td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' style='padding: 30px; text-align: center; color: #94a3b8;'>Belum ada aktivitas pengajuan terbaru.</td></tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- PENDAFTARAN SE - FORM DENGAN TOMOL SESUAI GAMBAR -->
        <div id="page-pendaftaran" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-file-signature"></i> Pendaftaran Sistem Elektronik</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="pendaftaranUserName">-</span>
                </div>
            </div>
            
            <div class="se-form-section">
                <form id="formPendaftaranSE" action="process_pendaftaran.php" method="POST" enctype="multipart/form-data">
                    <div class="se-form-grid">
                        <!-- KOLOM KIRI -->
                        <div>
                            <div class="se-form-group">
                                <label>Instansi</label>
                                <input type="text" id="se_instansi" name="instansi" value="Pemerintah Kota Probolinggo" placeholder="Pemerintah Kota Probolinggo" readonly>
                            </div>
                            <div class="se-form-group">
                                <label>Unit Kerja pemilik Sistem Elektronik</label>
                                <!-- DROPDOWN UNIT KERJA DENGAN 41 DAFTAR OPD/BAGIAN/KECAMATAN -->
                                <select id="se_unitkerja" name="unit_kerja">
                                    <option value="">--Pilih Unit Kerja--</option>
                                    <option>Bagian Umum</option>
                                    <option>Bagian Pemerintahan</option>
                                    <option>Bagian Perekonomian dan Pembangunan</option>
                                    <option>Bagian Hukum</option>
                                    <option>Bagian Kesejahteraan Rakyat</option>
                                    <option>Bagian Organisasi</option>
                                    <option>Bagian Protokol dan Komunikasi Pimpinan</option>
                                    <option>Bagian Pengadaan Barang dan Jasa</option>
                                    <option>Badan Pendapatan, Pengolaan Keuangan dan Aset Daerah</option>
                                    <option>Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah</option>
                                    <option>Badan Penanggulangan Bencana Daerah</option>
                                    <option>Badan Kepegawaian dan Pengembangan SDM</option>
                                    <option>Badan Kesatuan Bangsa dan Politik</option>
                                    <option>Dinas Kependudukan dan Pencatatan Sipil</option>
                                    <option>Dinas Ketahanan Pangan Pertanian dan Perikanan</option>
                                    <option>Dinas Kesehatan, Pengedalian Penduduk, dan Keluarga Berencana</option>
                                    <option>Dinas Koperasi, Usaha Kecil dan Menengah dan Perdagangan</option>
                                    <option>Dinas Perindustrian dan Tenaga Kerja</option>
                                    <option>Dinas Perhubungan</option>
                                    <option>Dinas Lingkungan Hidup</option>
                                    <option>Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu</option>
                                    <option>Dinas Kepemudaan, Olahraga dan Pariwisata</option>
                                    <option>Dinas Sosial, Pemberdayaan Perempuan dan Perlindungan Anak</option>
                                    <option>Dinas Komunikasi dan Informatika</option>
                                    <option>Dinas Perpustakaan dan Kearsipan</option>
                                    <option>Dinas Pendidikan dan Kebudayaan</option>
                                    <option>Dinas Pekerjaan Umum, Penataan Ruang, Perumahan dan Kawasan Permukiman</option>
                                    <option>Kecamatan Mayangan</option>
                                    <option>Kecamatan Wonoasih</option>
                                    <option>Kecamatan Kademangan</option>
                                    <option>Kecamatan Kedopok</option>
                                    <option>Kecamatan Kanigaran</option>
                                    <option>Sekretariat Dewan</option>
                                    <option>RSUD Dokter Mohammad Saleh</option>
                                    <option>RSUD Ar Rozy</option>
                                    <option>Inspektorat</option>
                                    <option>Satuan Polisi Pamong Praja</option>
                                </select>
                            </div>
                            <div class="se-form-group">
                                <label>Nama Sistem Elektronik</label>
                                <input type="text" id="se_nama" name="nama_se" placeholder="Contoh: Sistem Informasi Pelayanan Publik">
                            </div>
                            <div class="se-form-group">
                                <label>Versi Sistem Elektronik</label>
                                <input type="text" id="se_versi" name="versi" placeholder="Contoh: 2.5.1">
                            </div>
                            <div class="se-form-group">
                                <label>Bidang/Sektor Sistem Elektronik</label>
                                <!-- DROPDOWN BIDANG SEKTOR DENGAN 3 PILIHAN BARU -->
                                <select id="se_bidang" name="bidang">
                                    <option value="">--Pilih Bidang/Sektor--</option>
                                    <option>Layanan Pemerintahan</option>
                                    <option>Layanan Pusat</option>
                                    <option>Layanan Institusi</option>
                                </select>
                            </div>
                            <div class="se-form-group">
                                <label>Narahubung Sistem Elektronik</label>
                                <input type="text" id="se_narahubung" name="narahubung" placeholder="Contoh: Budi Santoso">
                            </div>
                            <div class="se-form-group">
                                <label>No. Tipe /HP: Narahubung</label>
                                <input type="text" id="se_telepon" name="telepon" placeholder="Contoh: 08123456789">
                            </div>
                        </div>
                        
                        <!-- KOLOM KANAN -->
                        <div>
                            <div class="se-form-group">
                                <label>Uniform Resource Locator (URL): Situ Web</label>
                                <input type="text" id="se_url" name="url" placeholder="Contoh: https://layanan.gold">
                            </div>
                            <div class="se-form-group">
                                <label>Sistem Nama Domain (DNS)/Alamat Internet IP Server</label>
                                <input type="text" name="dns" id="se_dns" placeholder="Contoh: 192.168.1.100 atau layanan gold">
                            </div>
                            <div class="se-form-group">
                                <label>Deskripsi Singkat Fungsi dan Proses Bisnis Sistem Elektronik</label>
                                <textarea id="se_deskripsi" name="deskripsi" placeholder="Contoh: Sistem ini digunakan untuk mengelola layanan publik secara elektronik, meliputi pendaftaran, verifikasi, dan pelaporan." rows="4"></textarea>
                            </div>
                            
                            <!-- Kategori Sistem Elektronik Berdasarkan Asas Risiko -->
                            <div class="se-form-group">
                                <label>Kategori Sistem Elektronik Berdasarkan Asas Risiko</label>
                                <div style="margin-bottom: 10px;">
                                    <select name="risiko" id="se_risiko" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; background: white;">
                                        <option value="">-- Pilih Kategori Risiko --</option>
                                        <option value="Strategis">🏛️ Strategis</option>
                                        <option value="Tinggi">⚠️ Tinggi</option>
                                        <option value="Rendah">✅ Rendah</option>
                                    </select>
                                </div>
                                
                                <!-- Bagian Upload dengan info file yang bisa diganti -->
                                <div class="upload-group">
                                    <input type="text" id="se_risiko_file" placeholder="Pilih file pendukung..." value="" readonly style="background-color: #f8fafc;">
                                    <input type="file" name="file_risiko" id="se_risiko_file_input" style="display: none;" accept=".pdf" onchange="handleFileUpload(this, 'se_risiko_file', 'se_risiko_info')">
                                    <button type="button" class="upload-btn" onclick="document.getElementById('se_risiko_file_input').click()">
                                        <i class="fas fa-folder-open"></i> Pilih File
                                    </button>
                                </div>
                                <!-- Info file yang sudah dipilih -->
                                <div id="se_risiko_info" class="file-info" style="display: none;">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="file-name" id="se_risiko_file_name"></span>
                                    <span class="file-size" id="se_risiko_file_size"></span>
                                    <button type="button" class="upload-btn-small" onclick="gantiFile('se_risiko')">
                                        <i class="fas fa-sync-alt"></i> Ganti
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Klasifikasi Data Sesuai Risiko -->
                            <div class="se-form-group">
                                <label>Klasifikasi Data Sesuai Risiko</label>
                                <div style="margin-bottom: 10px;">
                                    <select id="se_klasifikasi" name="klasifikasi" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; background: white;">
                                        <option value="">-- Pilih Klasifikasi Data --</option>
                                        <option value="Terbuka">🌐 Terbuka</option>
                                        <option value="Terbatas">🔒 Terbatas</option>
                                        <option value="Tertutup">🔐 Tertutup</option>
                                    </select>
                                </div>
                                
                                <!-- Bagian Upload dengan info file yang bisa diganti -->
                                <div class="upload-group">
                                    <input type="text" id="se_klasifikasi_file" placeholder="Pilih file pendukung..." value="" readonly style="background-color: #f8fafc;">
                                    <input type="file" name="file_klasifikasi" id="se_klasifikasi_file_input" style="display: none;" accept=".pdf" onchange="handleFileUpload(this, 'se_klasifikasi_file', 'se_klasifikasi_info')">
                                    <button type="button" class="upload-btn" onclick="document.getElementById('se_klasifikasi_file_input').click()">
                                        <i class="fas fa-folder-open"></i> Pilih File
                                    </button>
                                </div>
                                <!-- Info file yang sudah dipilih -->
                                <div id="se_klasifikasi_info" class="file-info" style="display: none;">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="file-name" id="se_klasifikasi_file_name"></span>
                                    <span class="file-size" id="se_klasifikasi_file_size"></span>
                                    <button type="button" class="upload-btn-small" onclick="gantiFile('se_klasifikasi')">
                                        <i class="fas fa-sync-alt"></i> Ganti
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Keterangan Data Pribadi yang Diproses - HANYA TEXTAREA (UPLOAD DIHAPUS) -->
                            <div class="se-form-group">
                                <label>Keterangan Data Pribadi yang Diproses</label>
                                <textarea id="se_data_pribadi" name="data_pribadi" placeholder="Contoh: Data pribadi yang diproses meliputi nama, alamat, nomor telepon, email, dan ..." rows="3" style="resize: vertical; width: 100%;"></textarea>
                                <!-- BAGIAN UPLOAD FILE TELAH DIHAPUS -->
                            </div>
                            
                            <!-- Lokasi Pengelolaan/Pemrosesan/Penyimpanan - HANYA 2 PILIHAN: DALAM NEGERI / LUAR NEGERI -->
                            <div class="se-form-group">
                                <label>Lokasi Pengelolaan/Pemrosesan/Penyimpanan</label>
                                <select name="lokasi" id="se_lokasi" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; background: white;">
                                    <option value="">-- Pilih Lokasi --</option>
                                    <option value="Dalam Negeri">🇮🇩 Dalam Negeri</option>
                                    <option value="Luar Negeri">🌏 Luar Negeri</option>
                                </select>
                                <!-- BAGIAN UPLOAD FILE TELAH DIHAPUS -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="se-section-divider">Penyelenggara Sistem Elektronik wajib melakukan</div>
                    
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="kewajiban1">
                            <label for="kewajiban1">Pemenuhan kewajiban untuk memastikan keamanan informasi sesuai dengan ketentuan peraturan perundang-undangan.</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="kewajiban2">
                            <label for="kewajiban2">Pemenuhan kewajiban untuk menyediakan sistem pengamanan yang mencakup prosedur dan sistem pencegahan dan penanggulangan terhadap ancaman dan serangan yang menimbulkan gangguan, kegagalan, dan kerugian sesuai dengan ketentuan peraturan perundang-undangan.</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="kewajiban3">
                            <label for="kewajiban3">Pemenuhan kewajiban melakukan pelindungan Data Pribadi sesuai dengan ketentuan peraturan perundang-undangan.</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="kewajiban4">
                            <label for="kewajiban4">Pemenuhan keamanan elektronik sebagai penyediaan data elektronik nasional dan asisten elektronik sistem pemerintahan berbasis elektronik institusi Pusat dan Pemerintah Daerah sesuai dengan ketentuan peraturan perundang-undangan dalam penyelenggaraan sistem elektronik.</label>
                        </div>
                    </div>
                    
                    <div class="se-form-group" style="margin-top: 1.5rem;">
                        <label>Dokumen Pendukung (Optional)</label>
                        <div class="upload-group">
                            <input type="text" id="se_dokumen" placeholder="Pilih file pendukung..." readonly style="background-color: #f8fafc;">
                            <input type="file" name="dokumen_pendukung" id="se_dokumen_input" style="display: none;" accept=".pdf" onchange="handleFileUpload(this, 'se_dokumen', 'se_dokumen_info')">
                            <button type="button" class="upload-btn" onclick="document.getElementById('se_dokumen_input').click()">
                                <i class="fas fa-folder-open"></i> Pilih File
                            </button>
                        </div>
                        <!-- Info file yang sudah dipilih -->
                        <div id="se_dokumen_info" class="file-info" style="display: none;">
                            <i class="fas fa-check-circle"></i>
                            <span class="file-name" id="se_dokumen_file_name"></span>
                            <span class="file-size" id="se_dokumen_file_size"></span>
                            <button type="button" class="upload-btn-small" onclick="gantiFile('se_dokumen')">
                                <i class="fas fa-sync-alt"></i> Ganti
                            </button>
                        </div>
                    </div>
                    
                    <div class="se-actions" style="display: flex; justify-content: flex-end; align-items: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px dashed #e2e8f0;">
                        <div style="display: flex; gap: 12px;">
                           
                            
                            <button type="button" class="btn-se-ajukan" id="btnAjukanPengajuan" onclick="ajukanPengajuan()" style="display: inline-flex; align-items: center; gap: 8px; background: #3b82f6; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.4); transition: all 0.2s;">
                                <i class="fas fa-paper-plane"></i> Kirim Pengajuan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- LIST SE TERDAFTAR - DENGAN BUTTON DETAIL DAN HAPUS -->
        <div id="page-list" class="dashboard-content">
            <div class="dashboard-header" style="border-bottom: none; margin-bottom: 1.5rem;">
                <div>
                    <h2 style="font-size: 1.8rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">List SE Terdaftar</h2>
                    <p style="color: #64748b; font-size: 0.95rem;">Kelola sistem elektronik yang telah Anda daftarkan</p>
                </div>
                <button class="btn-add" onclick="showPendaftaranSE()" style="padding: 12px 24px; border-radius: 12px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-plus"></i> Tambah SE Baru
                </button>
            </div>

            <!-- FILTER MODERN -->
            <div class="filter-box" style="background: white; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); padding: 1.2rem; border-radius: 16px; gap: 1rem;">
                <div style="flex: 1; position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    <input type="text" id="filterNamaSE" placeholder="Cari nama sistem..." style="padding-left: 40px; background: #f8fafc; border-color: #e2e8f0; border-radius: 8px;">
                </div>
                <div style="flex: 1; position: relative;">
                    <i class="fas fa-building" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    <input type="text" id="filterInstansi" placeholder="Cari instansi..." style="padding-left: 40px; background: #f8fafc; border-color: #e2e8f0; border-radius: 8px;">
                </div>
                <div style="width: 200px;">
                    <select id="filterStatus" style="background: #f8fafc; border-color: #e2e8f0; cursor: pointer; border-radius: 8px; padding: 10px;">
                        <option value="">Semua Status</option>
                        <option value="Terbit">✅ Terbit</option>
                        <option value="Menunggu">⏳ Menunggu</option>
                        <option value="Ditolak">❌ Ditolak</option>
                    </select>
                </div>
                <button class="btn-search" onclick="filterListSE()" style="border-radius: 10px; padding: 10px 20px;">
                    Filter
                </button>
            </div>

            <!-- TABEL MODERN -->
            <div class="table-box" style="border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); border-radius: 16px; overflow: hidden;">
                <table class="table" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">

                            <th style="padding: 16px; text-align: left; color: #475569; font-weight: 600;">Instansi / Unit Kerja</th>
                            <th style="padding: 16px; text-align: left; color: #475569; font-weight: 600;">Sistem Elektronik</th>
                            <th style="padding: 16px; text-align: left; color: #475569; font-weight: 600;">Status</th>
                            <th style="padding: 16px; text-align: left; color: #475569; font-weight: 600;">Tanggal Terbit</th>
                            <th style="padding: 16px; text-align: left; color: #475569; font-weight: 600;">No. Tanda Daftar</th>
                            <th style="padding: 16px; text-align: left; color: #475569; font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="listSEBody">
                        <?php
                        // FIX: Memperbaiki logika tampilan List SE Terdaftar agar sesuai dengan status 'Terbit' yang baru
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                            // Ambil data dengan status 'Terbit' atau 'Diterima' (untuk backward compatibility)
                            $query = "SELECT * FROM layanan_se WHERE user_id = '$user_id' AND (status = 'Terbit' OR status = 'Diterima') ORDER BY tanggal_terbit DESC";
                            $result = mysqli_query($koneksi, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $tgl_terbit = !empty($row['tanggal_terbit']) ? date('d M Y', strtotime($row['tanggal_terbit'])) : '-';
                                    $no_daftar = !empty($row['nomor_tanda_daftar']) ? $row['nomor_tanda_daftar'] : '<span class="text-muted">-</span>';

                                    echo "<tr style='border-bottom: 1px solid #f1f5f9;'>
                                     
                                        <td style='padding: 16px;'>
                                            <div style='font-weight: 600; color: #334155;'>" . htmlspecialchars($row['instansi']) . "</div>
                                            <div style='font-size: 0.85rem; color: #64748b; margin-top: 4px;'>" . htmlspecialchars($row['unit_kerja']) . "</div>
                                        </td>
                                        <td style='padding: 16px;'>
                                            <button onclick='lihatSertifikat(".$row['id'].")' title='Lihat Sertifikat' style='background: #3b82f6; color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;'>
                                                <i class='fas fa-certificate'></i> Sertifikat
                                            </button>
                                        </td>
                                        <td style='padding: 16px;'>
                                            <div style='font-weight: 600; color: #1e293b;'>" . htmlspecialchars($row['nama_se']) . "</div>
                                            <a href='" . htmlspecialchars($row['url']) . "' target='_blank' style='font-size: 0.85rem; color: #3b82f6; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; margin-top: 4px;'>
                                                " . htmlspecialchars($row['url']) . " <i class='fas fa-external-link-alt' style='font-size: 0.7rem;'></i>
                                            </a>
                                        </td>
                                        <td style='padding: 16px;'>
                                            <span class='status-badge status-terbit'>
                                                <i class='fas fa-check-circle'></i> Terbit
                                            </span>
                                        </td>
                                        <td style='padding: 16px; color: #475569; font-size: 0.9rem;'>
                                            $tgl_terbit
                                        </td>
                                        <td style='padding: 16px;'>
                                            <div style='font-family: monospace; background: #f1f5f9; padding: 4px 8px; border-radius: 4px; color: #334155; font-size: 0.9rem; border: 1px solid #e2e8f0; display: inline-block;'>
                                                $no_daftar
                                            </div>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' style='padding: 40px; text-align: center;'>
                                        <div style='display: flex; flex-direction: column; align-items: center; gap: 1rem;'>
                                            <div style='background: #f1f5f9; padding: 20px; border-radius: 50%;'>
                                                <i class='fas fa-inbox' style='font-size: 32px; color: #94a3b8;'></i>
                                            </div>
                                            <h4 style='color: #475569; margin: 0;'>Belum Ada Data SE Terdaftar</h4>
                                            <p style='color: #94a3b8; margin: 0;'>Anda belum memiliki SE yang terdaftar. Silakan lakukan pendaftaran dan tunggu persetujuan.</p>
                                            <button onclick='showPendaftaranSE()' style='margin-top: 10px; background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500;'>
                                                Daftar SE Sekarang
                                            </button>
                                        </div>
                                      </td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="table-footer" style="background: white; border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem;">
              
                   
                </div>
            </div>
        </div>

        <!-- RIWAYAT PENGAJUAN - MODERNIZED -->
        <div id="page-riwayat" class="dashboard-content">
            <div class="dashboard-header" style="border-bottom: none; margin-bottom: 1.5rem;">
                <div>
                    <h2 style="font-size: 1.8rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Riwayat Pengajuan SE</h2>
                    <p style="color: #64748b; font-size: 0.95rem;">Pantau status verifikasi sistem elektronik yang Anda ajukan</p>
                </div>
                <div class="user-badge" style="background: white; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <i class="fas fa-user-circle" style="color: #3b82f6;"></i> <span id="riwayatUserName" style="color: #334155; font-weight: 600;">-</span>
                </div>
            </div>
            
            <div class="filter-box" style="background: white; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); padding: 1.2rem; border-radius: 16px; gap: 1rem;">
                <div style="flex: 1; position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    <input type="text" id="filterRiwayatNama" placeholder="Cari nama sistem..." style="padding-left: 40px; background: #f8fafc; border-color: #e2e8f0; border-radius: 8px;">
                </div>
                <div style="flex: 1; position: relative;">
                    <i class="fas fa-building" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                    <input type="text" id="filterRiwayatInstansi" placeholder="Cari instansi..." style="padding-left: 40px; background: #f8fafc; border-color: #e2e8f0; border-radius: 8px;">
                </div>
                <div style="width: 200px;">
                    <select id="filterRiwayatStatus" style="background: #f8fafc; border-color: #e2e8f0; cursor: pointer; border-radius: 8px; padding: 10px;">
                        <option>Semua Status</option>
                        <option>⏳ Menunggu</option>
                        <option>✅ Diterima</option>
                        <option>❌ Ditolak</option>
                    </select>
                </div>
                <button class="btn-search" onclick="filterRiwayat()" style="border-radius: 10px; padding: 10px 20px;">
                    Filter
                </button>
                <button class="btn-add" onclick="showPendaftaranSE()" style="padding: 10px 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-plus"></i> Daftar Baru
                </button>
            </div>
            
            <div class="table-box" style="border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); border-radius: 16px; overflow: hidden;">
                <table class="table" id="riwayatTable" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 16px; text-align: left; color: #475569; font-weight: 600;">Aksi</th>
                            <th style="padding: 16px; text-align: left; color: #475569; font-weight: 600;">Jenis Pengajuan</th>
                            <th style="padding: 16px; text-align: left; color: #475569; font-weight: 600;">Status</th>
                            <th style="padding: 16px; text-align: left; color: #475569; font-weight: 600;">Nama SE</th>
                            <th style="padding: 16px; text-align: left; color: #475569; font-weight: 600;">Tanggal Pengajuan</th>
                        </tr>
                    </thead>
                    <tbody id="riwayatBody">
                        <?php
                        if ($is_logged_in) {
                            $user_id = $_SESSION['user_id'];
                            $query = "SELECT * FROM layanan_se WHERE user_id = '$user_id' ORDER BY tanggal_pengajuan DESC";
                            $result = mysqli_query($koneksi, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $statusClass = 'badge-orange'; // Default Menunggu
                                    $statusIcon = 'fa-clock';
                                    $statusText = $row['status'];
                                    
                                    if ($row['status'] == 'Diterima' || $row['status'] == 'Terbit') {
                                        $statusClass = 'badge-green';
                                        $statusIcon = 'fa-check-circle';
                                    } elseif ($row['status'] == 'Ditolak') {
                                        $statusClass = 'badge-red';
                                        $statusIcon = 'fa-times-circle';
                                    }
                                    
                                    $can_delete = ($row['status'] == 'Menunggu' || $row['status'] == 'Dalam Pembaharuan' || $row['status'] == 'Ditolak');
                                    echo "<tr style='border-bottom: 1px solid #f1f5f9;'>";
                                    echo "<td style='padding: 16px;'>
                                            <div style='display: flex; gap: 8px;'>
                                                <button onclick='detailPengajuan(" . $row['id'] . ")' style='background: #eff6ff; color: #3b82f6; border: none; padding: 8px; border-radius: 8px; cursor: pointer; transition: all 0.2s;' title='Lihat Detail' onmouseover='this.style.background=\"#dbeafe\"' onmouseout='this.style.background=\"#eff6ff\"'>
                                                    <i class='fas fa-eye'></i>
                                                </button>
                                                <button onclick='editPengajuan(" . $row['id'] . ")' style='background: #f1f5f9; color: #334155; border: none; padding: 8px; border-radius: 8px; cursor: pointer; transition: all 0.2s;' title='Edit Pengajuan' onmouseover='this.style.background=\"#e2e8f0\"' onmouseout='this.style.background=\"#f1f5f9\"'>
                                                    <i class='fas fa-pencil-alt'></i>
                                                </button>
                                                " . (($row['status'] == 'Diterima' || $row['status'] == 'Terbit') ? "<button onclick='lihatSertifikat(" . $row['id'] . ")' style='background: #eff6ff; color: #1e40af; border: none; padding: 8px; border-radius: 8px; cursor: pointer; transition: all 0.2s;' title='Lihat Sertifikat' onmouseover='this.style.background=\"#dbeafe\"' onmouseout='this.style.background=\"#eff6ff\"'><i class=\"fas fa-certificate\"></i></button>" : "") . "
                                                " . ($can_delete ? "<button onclick='deletePengajuan(" . $row['id'] . ")' style='background: #fef2f2; color: #ef4444; border: none; padding: 8px; border-radius: 8px; cursor: pointer; transition: all 0.2s;' title='Batalkan/Hapus' onmouseover='this.style.background=\"#fee2e2\"' onmouseout='this.style.background=\"#fef2f2\"'><i class='fas fa-trash-alt'></i></button>" : "") . "
                                            </div>
                                          </td>";
                                    echo "<td style='padding: 16px;'><span style='background: #f1f5f9; color: #475569; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;'><i class='fas fa-file-import'></i> Pendaftaran</span></td>";
                                    echo "<td style='padding: 16px;'><span class='badge $statusClass' style='display: inline-flex; align-items: center; gap: 5px;'><i class='fas $statusIcon'></i> " . htmlspecialchars($statusText) . "</span></td>";
                                    echo "<td style='padding: 16px; font-weight: 500; color: #1e293b;'>" . htmlspecialchars($row['nama_se']) . "</td>";
                                    echo "<td style='padding: 16px; color: #64748b;'>" . (isset($row['created_at']) && $row['created_at'] ? date('d M Y H:i', strtotime($row['created_at'])) : (isset($row['tanggal_pengajuan']) ? $row['tanggal_pengajuan'] : '-')) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' style='padding: 40px; text-align: center;'>
                                        <div style='display: flex; flex-direction: column; align-items: center; gap: 1rem;'>
                                            <div style='background: #f1f5f9; padding: 20px; border-radius: 50%;'>
                                                <i class='fas fa-history' style='font-size: 32px; color: #94a3b8;'></i>
                                            </div>
                                            <h4 style='color: #475569; margin: 0;'>Belum Ada Riwayat Pengajuan</h4>
                                            <p style='color: #94a3b8; margin: 0;'>Anda belum melakukan pengajuan SE. Silakan lakukan pendaftaran terlebih dahulu.</p>
                                            <button onclick='showPendaftaranSE()' style='margin-top: 10px; background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500;'>
                                                Daftar SE Sekarang
                                            </button>
                                        </div>
                                      </td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="table-footer" style="background: white; border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem;">
                    <span id="riwayatInfo" style="color: #64748b; font-weight: 500;">Menampilkan data...</span>
                    <div class="pagination" style="display: flex; gap: 5px;">
                        <button onclick="changePage('riwayat', 'prev')" style="border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-chevron-left"></i></button>
                        <button onclick="changePage('riwayat', 'next')" style="border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- PROFIL PEJABAT - MODERNIZED -->
        <div id="page-profil" class="dashboard-content">
            <div class="dashboard-header" style="border-bottom: none; margin-bottom: 1.5rem;">
                <div>
                    <h2 style="font-size: 1.8rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Profile Pejabat</h2>
                    <p style="color: #64748b; font-size: 0.95rem;">Kelola informasi profil Penjabat</p>
                </div>
                <div class="user-badge" style="background: white; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <i class="fas fa-user-circle" style="color: #3b82f6;"></i> <span id="profilUserName" style="color: #334155; font-weight: 600;">-</span>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; align-items: start;">
                <!-- KARTU PROFIL KIRI -->
                <div style="background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; text-align: center;">
                    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: white; font-size: 3.5rem; font-weight: 700; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);">
                        <span id="profilAvatar">-</span>
                    </div>
                    <h3 id="profilNama" style="color: #1e293b; font-size: 1.4rem; font-weight: 700; margin-bottom: 0.5rem;">-</h3>
                    <p id="profilRole" style="color: #64748b; font-size: 0.95rem; margin-bottom: 1.5rem; background: #f1f5f9; display: inline-block; padding: 4px 12px; border-radius: 20px;">Pejabat Penghubung</p>
                    
                    <div style="text-align: left; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9;">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1rem;">
                            <div style="width: 36px; height: 36px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-id-card" style="color: #3b82f6;"></i>
                            </div>
                            <div>
                                <p style="font-size: 0.75rem; color: #64748b; margin: 0;">NIP / NIK</p>
                                <p id="profilNIPDisplay" style="font-weight: 600; color: #334155; margin: 0;">-</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 1rem;">
                            <div style="width: 36px; height: 36px; background: #fff7ed; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-building" style="color: #f59e0b;"></i>
                            </div>
                            <div>
                                <p style="font-size: 0.75rem; color: #64748b; margin: 0;">Instansi</p>
                                <p id="profilInstansiDisplay" style="font-weight: 600; color: #334155; margin: 0;">-</p>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 36px; height: 36px; background: #ecfdf5; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-briefcase" style="color: #10b981;"></i>
                            </div>
                            <div>
                                <p style="font-size: 0.75rem; color: #64748b; margin: 0;">Jabatan</p>
                                <p id="profilJabatanDisplay" style="font-weight: 600; color: #334155; margin: 0;">-</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- FORM DETAIL PROFIL KANAN (READ ONLY) -->
                <div style="background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;">
                    <h3 style="color: #1e293b; font-size: 1.2rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-user-check" style="color: #3b82f6;"></i> Detail Informasi Pejabat
                    </h3>
                    
                 
                    
                    <form>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="se-form-group">
                                <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Nama Lengkap</label>
                                <div style="position: relative;">
                                    <i class="fas fa-user" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                                    <input type="text" id="profil_nama" style="padding-left: 40px; border-radius: 10px; border: 1px solid #cbd5e1; width: 100%; padding-top: 12px; padding-bottom: 12px; background-color: #f8fafc; color: #64748b;" placeholder="Nama Lengkap" readonly disabled>
                                </div>
                            </div>
                            <div class="se-form-group">
                                <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">NIP / NIK</label>
                                <div style="position: relative;">
                                    <i class="fas fa-id-badge" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                                    <input type="text" id="profil_nip" style="padding-left: 40px; border-radius: 10px; border: 1px solid #cbd5e1; width: 100%; padding-top: 12px; padding-bottom: 12px; background-color: #f8fafc; color: #64748b;" placeholder="Nomor Induk Pegawai" readonly disabled>
                                </div>
                            </div>
                            <div class="se-form-group">
                                <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Jabatan</label>
                                <div style="position: relative;">
                                    <i class="fas fa-briefcase" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                                    <input type="text" id="profil_jabatan" style="padding-left: 40px; border-radius: 10px; border: 1px solid #cbd5e1; width: 100%; padding-top: 12px; padding-bottom: 12px; background-color: #f8fafc; color: #64748b;" placeholder="Jabatan Saat Ini" readonly disabled>
                                </div>
                            </div>
                            <div class="se-form-group">
                                <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Nomor Telepon</label>
                                <div style="position: relative;">
                                    <i class="fas fa-phone" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                                    <input type="text" id="profil_telp" style="padding-left: 40px; border-radius: 10px; border: 1px solid #cbd5e1; width: 100%; padding-top: 12px; padding-bottom: 12px; background-color: #f8fafc; color: #64748b;" placeholder="08xxxxxxxxxx" readonly disabled>
                                </div>
                            </div>
                            <div class="se-form-group" style="grid-column: 1 / -1;">
                                <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Email Resmi</label>
                                <div style="position: relative;">
                                    <i class="fas fa-envelope" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                                    <input type="email" id="profil_email" style="padding-left: 40px; border-radius: 10px; border: 1px solid #cbd5e1; width: 100%; padding-top: 12px; padding-bottom: 12px; background-color: #f8fafc; color: #64748b;" placeholder="email@instansi.go.id" readonly disabled>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tombol Simpan Dihilangkan karena User Tidak Bisa Edit -->
                    </form>
                </div>
            </div>
        </div>

        <!-- RIWAYAT PENGAJUAN PEJABAT -->
        <div id="page-riwayat-pejabat" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-clock"></i> Riwayat Pengajuan Pejabat</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="riwayatPejabatUserName">-</span>
                </div>
            </div>
            
            <div class="filter-box">
                <input type="text" id="filterPejabatNama" placeholder="🔍 Nama Pejabat">
                <input type="text" id="filterPejabatInstansi" placeholder="🏢 Instansi">
                <button class="btn-search" onclick="filterRiwayatPejabat()">🔎 Cari</button>
            </div>
            
            <div class="table-box">
                <table class="table">
                    <thead>
                        <tr>
                            <th>📋 Aksi</th>
                            <th>👤 Nama Pejabat</th>
                            <th>🏢 Instansi</th>
                            <th>📄 Jenis</th>
                            <th>📊 Status</th>
                            <th>📅 Tanggal</th>
                        </tr>
                    </thead>
                    <tbody id="riwayatPejabatBody">
                        <tr>
                            <td colspan="6" style="text-align: center;">Belum ada riwayat pengajuan pejabat</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- PANDUAN PENGGUNA - BAGIAN PORTAL DIPERJELAS -->
        <!-- ============================================ -->
        <div id="page-panduan-pengguna" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-book-open"></i> Panduan Pengguna</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="panduanUserName">-</span>
                </div>
            </div>
            
            <!-- CARD INFORMASI PORTAL PSE NASIONAL - DIPERJELAS WARNA TULISAN -->
            <div class="panduan-card">
                <h3>
                    <i class="fas fa-globe" style="color: #3b82f6;"></i> 
                    Portal Resmi PSE Lingkup Publik
                </h3>
                <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap; margin-bottom: 1rem;">
                    <div style="flex: 1;">
                        <!-- URL UTAMA - DIPERJELAS -->
                        <p style="font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            pse.layanan.go.id
                        </p>
                        
                        <!-- SOCIAL MEDIA ICONS - DIPERJELAS -->
                        <div style="display: flex; gap: 1.2rem; margin-top: 1rem; flex-wrap: wrap;">
                            <span style="background: #eef2ff; padding: 8px 18px; border-radius: 50px; font-size: 0.95rem; font-weight: 600; color: #1e40af; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.3);">
                                <i class="fab fa-twitter" style="color: #1DA1F2;"></i> @PSELingkupPublik
                            </span>
                            <span style="background: #eef2ff; padding: 8px 18px; border-radius: 50px; font-size: 0.95rem; font-weight: 600; color: #1e40af; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.3);">
                                <i class="fab fa-instagram" style="color: #E4405F;"></i> @PSELingkupPublik
                            </span>
                            <span style="background: #eef2ff; padding: 8px 18px; border-radius: 50px; font-size: 0.95rem; font-weight: 600; color: #1e40af; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.3);">
                                <i class="fab fa-facebook" style="color: #1877F2;"></i> PSELingkupPublik
                            </span>
                        </div>
                    </div>
                    
                    <!-- TAGAR RESMI - DIPERJELAS -->
                    <div style="flex: 1; background: linear-gradient(145deg, #ffffff, #f8fafc); padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;">
                        <p style="font-weight: 700; margin-bottom: 1rem; font-size: 1.2rem; color: #0f172a; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-hashtag" style="color: #3b82f6;"></i> Tagar Resmi:
                        </p>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.8rem;">
                            <span style="background: #ffffff; padding: 8px 18px; border-radius: 50px; font-size: 0.95rem; font-weight: 600; box-shadow: 0 2px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; color: #1e40af; transition: all 0.3s ease;">
                                #PSELingkupPublik
                            </span>
                            <span style="background: #ffffff; padding: 8px 18px; border-radius: 50px; font-size: 0.95rem; font-weight: 600; box-shadow: 0 2px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; color: #1e40af;">
                                #PemerintahDigital
                            </span>
                            <span style="background: #ffffff; padding: 8px 18px; border-radius: 50px; font-size: 0.95rem; font-weight: 600; box-shadow: 0 2px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; color: #1e40af;">
                                #SistemElektronik
                            </span>
                            <span style="background: #ffffff; padding: 8px 18px; border-radius: 50px; font-size: 0.95rem; font-weight: 600; box-shadow: 0 2px 6px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; color: #1e40af;">
                                #Kominfo
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- DOKUMEN PANDUAN LENGKAP -->
            <div class="panduan-card">
                <h3>
                    <i class="fas fa-file-download" style="color: #3b82f6;"></i> 
                    Dokumen Panduan & Regulasi
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">
                    
                    <!-- KELOMPOK 1: PANDUAN & JUKNIS -->
                    <div class="doc-group">
                        <div class="doc-header bg-blue-light">
                            <i class="fas fa-book-reader" style="color: #2563eb;"></i>
                            <h4>Panduan & Juknis</h4>
                        </div>
                        <div class="doc-list">
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=JUKNIS%20PSE%20PUBLIK%20KOMDIGI.pdf&nd=1772155683552" target="_blank" class="doc-item">
                                <i class="fas fa-file-pdf text-red"></i>
                                <span>JUKNIS PSE PUBLIK KOMDIGI</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=JUKNIS%20KLASIFIKASI%20DATA%20SE.pdf&nd=1772155775845" target="_blank" class="doc-item">
                                <i class="fas fa-file-pdf text-red"></i>
                                <span>JUKNIS KLASIFIKASI DATA SE</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20KATEGORI%20SISTEM%20ELEKTRONIK.pdf&nd=1772155810386" target="_blank" class="doc-item">
                                <i class="fas fa-file-pdf text-red"></i>
                                <span>FORMAT KATEGORI SISTEM ELEKTRONIK</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=20251106%20SOP%20Pendaftaran%20PSE%20Lingkup%20Publik.pdf&nd=1772155829764" target="_blank" class="doc-item">
                                <i class="fas fa-file-pdf text-red"></i>
                                <span>SOP Pendaftaran PSE Lingkup Publik</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                        </div>
                    </div>

                    <!-- KELOMPOK 2: FORMAT SURAT -->
                    <div class="doc-group">
                        <div class="doc-header bg-green-light">
                            <i class="fas fa-file-contract" style="color: #10b981;"></i>
                            <h4>Format Surat</h4>
                        </div>
                        <div class="doc-list">
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20TUGAS%20PEJABAT%20PENDAFTAR%20PSE%20LINGKUP%20PUBLIK%20YANG%20BERASAL%20DARI%20INSTITUSI.pdf&nd=1772155849038" target="_blank" class="doc-item">
                                <i class="fas fa-file-word text-blue"></i>
                                <span>Surat Tugas Pejabat (Institusi)</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20TUGAS%20PEJABAT%20PENDAFTAR%20PSE%20LINGKUP%20PUBLIK%20YANG%20BERASAL%20DARI%20INSTANSI.pdf&nd=1772155874761" target="_blank" class="doc-item">
                                <i class="fas fa-file-word text-blue"></i>
                                <span>Surat Tugas Pejabat (Instansi)</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20PERMOHONAN%20PEMUTUSAN%20AKSES%20OLEH%20KEMENTERIAN_LEMBAGA%20APARAT%20PENEGAK%20HUKUM%20DAN_ATAU%20LEMBAGA%20PERADILAN.pdf&nd=1772155898246" target="_blank" class="doc-item">
                                <i class="fas fa-file-word text-blue"></i>
                                <span>Permohonan Pemutusan Akses (K/L/APH)</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20PERMOHONAN%20PEMUTUSAN%20AKSES%20OLEH%20MASYARAKAT.pdf&nd=1772155921852" target="_blank" class="doc-item">
                                <i class="fas fa-file-word text-blue"></i>
                                <span>Permohonan Pemutusan Akses (Masyarakat)</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20PERMOHONAN%20NORMALISASI%20SISTEM%20ELEKTRONIK%20LINGKUP%20PUBLIK%20INSTANSI%20DAN%20INSTITUSI.pdf&nd=1772155943551" target="_blank" class="doc-item">
                                <i class="fas fa-file-word text-blue"></i>
                                <span>Permohonan Normalisasi SE</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20SURAT%20KETERANGAN%20SISTEM%20ELEKTRONIK%20TIDAK%20DIGUNAKAN.pdf&nd=1772155965780" target="_blank" class="doc-item">
                                <i class="fas fa-file-word text-blue"></i>
                                <span>Keterangan SE Tidak Digunakan</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                        </div>
                    </div>

                    <!-- KELOMPOK 3: REGULASI -->
                    <div class="doc-group full-width">
                        <div class="doc-header bg-purple-light">
                            <i class="fas fa-balance-scale" style="color: #8b5cf6;"></i>
                            <h4>Regulasi & Peraturan</h4>
                        </div>
                        <div class="doc-grid">
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=Kepmen%20Kominfo%20519%202024%20Ekosistem%20PDN.pdf&nd=1772155989153" target="_blank" class="doc-item">
                                <i class="fas fa-gavel text-purple"></i>
                                <span>Kepmen Kominfo 519 2024 (Ekosistem PDN)</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=PP%2071%202019%20PSTE.pdf&nd=1772156009620" target="_blank" class="doc-item">
                                <i class="fas fa-gavel text-purple"></i>
                                <span>PP 71 2019 PSTE</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=PM%20Komdigi%205%202025%20PSE%20Lingkup%20Publik.pdf&nd=1772156061201" target="_blank" class="doc-item">
                                <i class="fas fa-gavel text-purple"></i>
                                <span>PM Komdigi 5 2025 PSE Lingkup Publik</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=UU%2019%202016%20Perubahan%20ITE.pdf&nd=1772156084421" target="_blank" class="doc-item">
                                <i class="fas fa-gavel text-purple"></i>
                                <span>UU 19 2016 Perubahan ITE</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=UU%201%202024%20Perubahan%20Kedua%20ITE.pdf&nd=1772156116490" target="_blank" class="doc-item">
                                <i class="fas fa-gavel text-purple"></i>
                                <span>UU 1 2024 Perubahan Kedua ITE</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                            <a href="https://pse.layanan.go.id/api/downloadguide?fileName=UU%2011%202008%20ITE.pdf&nd=1772156134201" target="_blank" class="doc-item">
                                <i class="fas fa-gavel text-purple"></i>
                                <span>UU 11 2008 ITE</span>
                                <i class="fas fa-download text-gray"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

<style>
/* CSS DOKUMEN PANDUAN */
.doc-group {
    background: #f8fafc;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
}
.doc-group.full-width {
    grid-column: 1 / -1;
}
.doc-header {
    padding: 1rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    border-bottom: 1px solid #e2e8f0;
}
.doc-header h4 {
    margin: 0;
    color: #1e293b;
    font-size: 1.05rem;
    font-weight: 700;
}
.doc-list {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.doc-grid {
    padding: 1rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 0.8rem;
}
.doc-item {
    display: flex;
    align-items: center;
    padding: 0.8rem 1rem;
    background: white;
    border-radius: 8px;
    text-decoration: none;
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
    gap: 1rem;
}
.doc-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    border-color: #3b82f6;
}
.doc-item span {
    flex: 1;
    color: #334155;
    font-size: 0.9rem;
    font-weight: 500;
}
.text-red { color: #ef4444; font-size: 1.2rem; }
.text-blue { color: #2563eb; font-size: 1.2rem; }
.text-purple { color: #8b5cf6; font-size: 1.2rem; }
.text-gray { color: #94a3b8; font-size: 1rem; }
.bg-blue-light { background: #dbeafe; }
.bg-green-light { background: #d1fae5; }
.bg-purple-light { background: #f3e8ff; }
</style>
            
            <!-- CARD PERATURAN DAN DASAR HUKUM - SESUAI GAMBAR -->
            <div class="panduan-card">
                <h3>
                    <i class="fas fa-gavel" style="color: #10b981;"></i> 
                    Peraturan & Dasar Hukum
                </h3>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                    <div style="background: #f8fafc; border-radius: 12px; padding: 1.2rem; text-align: center;">
                        <div style="width: 50px; height: 50px; background: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <i class="fas fa-file-contract" style="color: #2563eb; font-size: 1.5rem;"></i>
                        </div>
                        <h5 style="font-weight: 700; margin-bottom: 0.5rem;">UU 11/2008</h5>
                        <p style="font-size: 0.85rem; color: #64748b;">Informasi & Transaksi Elektronik</p>
                    </div>
                    <div style="background: #f8fafc; border-radius: 12px; padding: 1.2rem; text-align: center;">
                        <div style="width: 50px; height: 50px; background: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <i class="fas fa-file-contract" style="color: #2563eb; font-size: 1.5rem;"></i>
                        </div>
                        <h5 style="font-weight: 700; margin-bottom: 0.5rem;">UU 19/2016</h5>
                        <p style="font-size: 0.85rem; color: #64748b;">Perubahan UU ITE</p>
                    </div>
                    <div style="background: #f8fafc; border-radius: 12px; padding: 1.2rem; text-align: center;">
                        <div style="width: 50px; height: 50px; background: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <i class="fas fa-file-contract" style="color: #2563eb; font-size: 1.5rem;"></i>
                        </div>
                        <h5 style="font-weight: 700; margin-bottom: 0.5rem;">UU 1/2024</h5>
                        <p style="font-size: 0.85rem; color: #64748b;">Perubahan Kedua ITE</p>
                    </div>
                    <div style="background: #f8fafc; border-radius: 12px; padding: 1.2rem; text-align: center;">
                        <div style="width: 50px; height: 50px; background: #fee2e2; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <i class="fas fa-file-contract" style="color: #dc2626; font-size: 1.5rem;"></i>
                        </div>
                        <h5 style="font-weight: 700; margin-bottom: 0.5rem;">PP 71/2019</h5>
                        <p style="font-size: 0.85rem; color: #64748b;">Penyelenggaraan Sistem & Transaksi Elektronik</p>
                    </div>
                    <div style="background: #f8fafc; border-radius: 12px; padding: 1.2rem; text-align: center;">
                        <div style="width: 50px; height: 50px; background: #fee2e2; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <i class="fas fa-file-contract" style="color: #dc2626; font-size: 1.5rem;"></i>
                        </div>
                        <h5 style="font-weight: 700; margin-bottom: 0.5rem;">Kepmen 519/2024</h5>
                        <p style="font-size: 0.85rem; color: #64748b;">Ekosistem PDN</p>
                    </div>
                    <div style="background: #f8fafc; border-radius: 12px; padding: 1.2rem; text-align: center;">
                        <div style="width: 50px; height: 50px; background: #fee2e2; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <i class="fas fa-file-contract" style="color: #dc2626; font-size: 1.5rem;"></i>
                        </div>
                        <h5 style="font-weight: 700; margin-bottom: 0.5rem;">PM Komdigi 5/2025</h5>
                        <p style="font-size: 0.85rem; color: #64748b;">PSE Lingkup Publik</p>
                    </div>
                </div>
            </div>
            
            <!-- CARD FORMAT SURAT LAINNYA - SESUAI GAMBAR -->
            <div class="panduan-card">
                <h3>
                    <i class="fas fa-envelope" style="color: #f59e0b;"></i> 
                    Format Surat Lainnya
                </h3>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.2rem;">
                    <div style="background: #f8fafc; padding: 1.2rem; border-radius: 12px; border-left: 4px solid #ef4444;">
                        <i class="fas fa-file-alt" style="color: #ef4444; font-size: 1.5rem; margin-bottom: 0.8rem;"></i>
                        <h5 style="font-weight: 700; margin-bottom: 0.3rem;">Pemutusan Akses</h5>
                        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.8rem;">Oleh Kementerian/Lembaga/APH</p>
                        <span style="background: #ef4444; color: white; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; cursor: pointer;" onclick="alert('📥 Download Format Surat')">Download</span>
                    </div>
                    <div style="background: #f8fafc; padding: 1.2rem; border-radius: 12px; border-left: 4px solid #10b981;">
                        <i class="fas fa-file-alt" style="color: #10b981; font-size: 1.5rem; margin-bottom: 0.8rem;"></i>
                        <h5 style="font-weight: 700; margin-bottom: 0.3rem;">Pemutusan Akses</h5>
                        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.8rem;">Oleh Masyarakat</p>
                        <span style="background: #10b981; color: white; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; cursor: pointer;" onclick="alert('📥 Download Format Surat')">Download</span>
                    </div>
                    <div style="background: #f8fafc; padding: 1.2rem; border-radius: 12px; border-left: 4px solid #f59e0b;">
                        <i class="fas fa-file-alt" style="color: #f59e0b; font-size: 1.5rem; margin-bottom: 0.8rem;"></i>
                        <h5 style="font-weight: 700; margin-bottom: 0.3rem;">Normalisasi SE</h5>
                        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.8rem;">Lingkup Publik Instansi</p>
                        <span style="background: #f59e0b; color: white; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; cursor: pointer;" onclick="alert('📥 Download Format Surat')">Download</span>
                    </div>
                </div>
            </div>
            
            <!-- CARD INFORMASI KEMENTERIAN - SESUAI GAMBAR -->
            <div class="panduan-card">
                <h3>
                    <i class="fas fa-building" style="color: #64748b;"></i> 
                    Kementerian Komunikasi dan Digital
                </h3>
                <div style="display: flex; gap: 2rem; align-items: center; flex-wrap: wrap;">
                    <div style="flex: 2;">
                        <p style="margin-bottom: 0.5rem;"><i class="fas fa-map-marker-alt" style="color: #ef4444;"></i> <strong>Alamat:</strong></p>
                        <p style="color: #475569; margin-bottom: 1rem;">Gedung Utama Kementerian Komunikasi dan Digital<br>Lantai 6, Jl. Medan Merdeka Barat No. 9, RT.2/RW.3<br>Gambir, Kecamatan Gambir, Kota Jakarta Pusat<br>Daerah Khusus Ibukota Jakarta 10250</p>
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <span style="background: #f1f5f9; padding: 6px 14px; border-radius: 50px; font-size: 0.9rem;">
                                <i class="fas fa-globe" style="color: #3b82f6;"></i> pse.layanan.go.id
                            </span>
                            <span style="background: #f1f5f9; padding: 6px 14px; border-radius: 50px; font-size: 0.9rem;">
                                <i class="fas fa-phone" style="color: #10b981;"></i> (021) 1234-5678
                            </span>
                            <span style="background: #f1f5f9; padding: 6px 14px; border-radius: 50px; font-size: 0.9rem;">
                                <i class="fas fa-envelope" style="color: #f59e0b;"></i> pse@kominfo.go.id
                            </span>
                        </div>
                    </div>
                    <div style="flex: 1; background: #f8fafc; padding: 1.5rem; border-radius: 16px; text-align: center;">
                        <p style="font-weight: 600; margin-bottom: 1rem;"><i class="fas fa-hashtag" style="color: #3b82f6;"></i> Tagar Resmi:</p>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <span style="background: white; padding: 8px; border-radius: 8px;">#PSELingkupPublik</span>
                            <span style="background: white; padding: 8px; border-radius: 8px;">#PemerintahDigital</span>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 1.5rem; padding: 1rem; background: #f1f5f9; border-radius: 8px; text-align: center; color: #475569;">
                    <i class="fas fa-copyright"></i> 2025 Pendaftaran PSE Lingkup Publik · Kementerian Komunikasi dan Digital
                </div>
            </div>
            
            <!-- CARD 1: LANGKAH-LANGKAH PENDAFTARAN (TETAP) -->
            <div class="panduan-card">
                <h3>
                    <i class="fas fa-rocket" style="color: #3b82f6;"></i> 
                    Langkah-langkah Pendaftaran PSE
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.2rem;">
                    <div style="display: flex; align-items: flex-start; gap: 1rem; background: #f8fafc; padding: 1.2rem; border-radius: 12px; border-left: 4px solid #3b82f6;">
                        <div style="background: linear-gradient(135deg, #3b82f6, #1e40af); min-width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">1</div>
                        <div>
                            <h4 style="color: #0f172a; font-size: 1rem; font-weight: 700; margin-bottom: 0.3rem;">Persiapan Dokumen</h4>
                            <p style="color: #475569; font-size: 0.9rem; line-height: 1.5; margin: 0;">Siapkan profil instansi, deskripsi sistem, dan komitmen keamanan informasi</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 1rem; background: #f8fafc; padding: 1.2rem; border-radius: 12px; border-left: 4px solid #3b82f6;">
                        <div style="background: linear-gradient(135deg, #3b82f6, #1e40af); min-width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">2</div>
                        <div>
                            <h4 style="color: #0f172a; font-size: 1rem; font-weight: 700; margin-bottom: 0.3rem;">Login / Daftar</h4>
                            <p style="color: #475569; font-size: 0.9rem; line-height: 1.5; margin: 0;">Masuk ke portal dengan akun pejabat yang berwenang</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 1rem; background: #f8fafc; padding: 1.2rem; border-radius: 12px; border-left: 4px solid #3b82f6;">
                        <div style="background: linear-gradient(135deg, #3b82f6, #1e40af); min-width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">3</div>
                        <div>
                            <h4 style="color: #0f172a; font-size: 1rem; font-weight: 700; margin-bottom: 0.3rem;">Isi Formulir</h4>
                            <p style="color: #475569; font-size: 0.9rem; line-height: 1.5; margin: 0;">Lengkapi data PSE, URL sistem, dan dokumen pendukung</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 1rem; background: #f8fafc; padding: 1.2rem; border-radius: 12px; border-left: 4px solid #3b82f6;">
                        <div style="background: linear-gradient(135deg, #3b82f6, #1e40af); min-width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">4</div>
                        <div>
                            <h4 style="color: #0f172a; font-size: 1rem; font-weight: 700; margin-bottom: 0.3rem;">Upload Dokumen</h4>
                            <p style="color: #475569; font-size: 0.9rem; line-height: 1.5; margin: 0;">Upload asesmen risiko dan klasifikasi data</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 1rem; background: #f8fafc; padding: 1.2rem; border-radius: 12px; border-left: 4px solid #3b82f6;">
                        <div style="background: linear-gradient(135deg, #3b82f6, #1e40af); min-width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">5</div>
                        <div>
                            <h4 style="color: #0f172a; font-size: 1rem; font-weight: 700; margin-bottom: 0.3rem;">Verifikasi</h4>
                            <p style="color: #475569; font-size: 0.9rem; line-height: 1.5; margin: 0;">Tim DisKominfo akan review dalam 3x24 jam</p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 1rem; background: #f8fafc; padding: 1.2rem; border-radius: 12px; border-left: 4px solid #3b82f6;">
                        <div style="background: linear-gradient(135deg, #3b82f6, #1e40af); min-width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1rem;">6</div>
                        <div>
                            <h4 style="color: #0f172a; font-size: 1rem; font-weight: 700; margin-bottom: 0.3rem;">TDPSE</h4>
                            <p style="color: #475569; font-size: 0.9rem; line-height: 1.5; margin: 0;">Unduh sertifikat TDPSE setelah disetujui</p>
                        </div>
                    </div>
                </div>
                
                <!-- INFO TAMBAHAN -->
                <div style="margin-top: 1.5rem; padding: 1rem; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-info-circle" style="color: #3b82f6; font-size: 1.3rem;"></i>
                    <p style="color: #1e40af; font-size: 0.9rem; font-weight: 500; margin: 0;">
                        <strong>Estimasi waktu:</strong> Seluruh proses verifikasi maksimal 3x24 jam kerja setelah dokumen lengkap dan valid.
                    </p>
                </div>
            </div>
            
            <!-- CARD 2: DOKUMEN YANG DIPERLUKAN (TETAP) -->
            <div class="panduan-card">
                <h3>
                    <i class="fas fa-file-alt" style="color: #10b981;"></i>
                    Dokumen yang Diperlukan
                </h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- DOKUMEN WAJIB -->
                    <div style="background: #f8fafc; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0;">
                        <div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 1.2rem;">
                            <div style="background: #fee2e2; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-exclamation-circle" style="color: #dc2626; font-size: 1.2rem;"></i>
                            </div>
                            <h4 style="color: #0f172a; font-size: 1.1rem; font-weight: 700; margin: 0;">Dokumen Wajib</h4>
                        </div>
                        
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="display: flex; align-items: flex-start; gap: 0.8rem; margin-bottom: 1rem; padding-bottom: 0.8rem; border-bottom: 1px dashed #e2e8f0;">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1rem; margin-top: 2px;"></i>
                                <span style="color: #1e293b; font-size: 0.95rem; line-height: 1.5;"><strong>Profil Instansi/Unit Kerja</strong> - Data lengkap instansi dan struktur organisasi</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.8rem; margin-bottom: 1rem; padding-bottom: 0.8rem; border-bottom: 1px dashed #e2e8f0;">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1rem; margin-top: 2px;"></i>
                                <span style="color: #1e293b; font-size: 0.95rem; line-height: 1.5;"><strong>Dokumen Asesmen Risiko</strong> - Hasil analisis risiko sistem elektronik</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.8rem; margin-bottom: 1rem; padding-bottom: 0.8rem; border-bottom: 1px dashed #e2e8f0;">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1rem; margin-top: 2px;"></i>
                                <span style="color: #1e293b; font-size: 0.95rem; line-height: 1.5;"><strong>Klasifikasi Data</strong> - Kategori dan tingkat kerahasiaan data yang diproses</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.8rem; margin-bottom: 1rem; padding-bottom: 0.8rem; border-bottom: 1px dashed #e2e8f0;">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1rem; margin-top: 2px;"></i>
                                <span style="color: #1e293b; font-size: 0.95rem; line-height: 1.5;"><strong>Profil Pejabat Penanggung Jawab</strong> - Identitas dan SK pengangkatan</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.8rem;">
                                <i class="fas fa-check-circle" style="color: #10b981; font-size: 1rem; margin-top: 2px;"></i>
                                <span style="color: #1e293b; font-size: 0.95rem; line-height: 1.5;"><strong>Surat Pernyataan Komitmen</strong> - Bermaterai cukup</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- DOKUMEN PENDUKUNG -->
                    <div style="background: #f8fafc; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0;">
                        <div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 1.2rem;">
                            <div style="background: #dbeafe; width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-info-circle" style="color: #2563eb; font-size: 1.2rem;"></i>
                            </div>
                            <h4 style="color: #0f172a; font-size: 1.1rem; font-weight: 700; margin: 0;">Dokumen Pendukung</h4>
                        </div>
                        
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="display: flex; align-items: flex-start; gap: 0.8rem; margin-bottom: 1rem; padding-bottom: 0.8rem; border-bottom: 1px dashed #e2e8f0;">
                                <i class="fas fa-file" style="color: #64748b; font-size: 1rem; margin-top: 2px;"></i>
                                <span style="color: #475569; font-size: 0.95rem; line-height: 1.5;"><strong>SK Kepala Daerah/Pejabat</strong> - Dasar hukum pembentukan sistem</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.8rem; margin-bottom: 1rem; padding-bottom: 0.8rem; border-bottom: 1px dashed #e2e8f0;">
                                <i class="fas fa-file" style="color: #64748b; font-size: 1rem; margin-top: 2px;"></i>
                                <span style="color: #475569; font-size: 0.95rem; line-height: 1.5;"><strong>Bukti Kepatuhan Arsitektur SPBE</strong> - Kesesuaian dengan arsitektur SPBE</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.8rem; margin-bottom: 1rem; padding-bottom: 0.8rem; border-bottom: 1px dashed #e2e8f0;">
                                <i class="fas fa-file" style="color: #64748b; font-size: 1rem; margin-top: 2px;"></i>
                                <span style="color: #475569; font-size: 0.95rem; line-height: 1.5;"><strong>Sertifikat Keamanan</strong> - ISO 27001, SNI, atau sertifikat lainnya</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 0.8rem;">
                                <i class="fas fa-file" style="color: #64748b; font-size: 1rem; margin-top: 2px;"></i>
                                <span style="color: #475569; font-size: 0.95rem; line-height: 1.5;"><strong>Rekomendasi Teknis</strong> - Dari instansi terkait (jika ada)</span>
                            </li>
                        </ul>
                        
                        <div style="margin-top: 1.5rem; padding: 1rem; background: #fff7ed; border-radius: 8px;">
                            <p style="color: #9a3412; font-size: 0.85rem; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-lightbulb" style="color: #f59e0b;"></i>
                                <strong>Format file:</strong> PDF, JPG, PNG • Maksimal 100MB per file
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
          
        </div>

        <!-- LAPORAN - MODERNIZED -->
        <div id="page-laporan" class="dashboard-content">
            <div class="dashboard-header" style="border-bottom: none; margin-bottom: 1.5rem;">
                <div>
                    <h2 style="font-size: 1.8rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">Laporan & Statistik</h2>
                    <p style="color: #64748b; font-size: 0.95rem;">Unduh laporan kinerja dan pantau statistik kepatuhan PSE</p>
                </div>
                <div class="user-badge" style="background: white; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <i class="fas fa-user-circle" style="color: #3b82f6;"></i> <span id="laporanUserName" style="color: #334155; font-weight: 600;">-</span>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
                <!-- Card Laporan Bulanan -->
                <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; transition: transform 0.3s ease; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 60px; height: 60px; background: #eff6ff; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <i class="fas fa-calendar-alt" style="color: #3b82f6; font-size: 1.8rem;"></i>
                    </div>
                    <h3 style="color: #1e293b; font-weight: 700; font-size: 1.3rem; margin-bottom: 0.5rem;">Laporan Bulanan</h3>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem;">Rekapitulasi aktivitas pendaftaran dan verifikasi bulanan.</p>
                    
                    <div class="se-form-group" style="margin-bottom: auto;">
                        <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Pilih Periode</label>
                        <select id="laporanBulan" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 10px; background: #f8fafc; font-size: 0.95rem;">
                            <option>Februari 2026</option>
                            <option>Januari 2026</option>
                            <option>Desember 2025</option>
                        </select>
                    </div>
                    
                    <button style="width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 1.5rem; transition: background 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'" onclick="downloadLaporan('bulanan')">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </button>
                </div>
                
                <!-- Card Laporan Tahunan -->
                <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; transition: transform 0.3s ease; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 60px; height: 60px; background: #ecfdf5; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <i class="fas fa-chart-bar" style="color: #10b981; font-size: 1.8rem;"></i>
                    </div>
                    <h3 style="color: #1e293b; font-weight: 700; font-size: 1.3rem; margin-bottom: 0.5rem;">Laporan Tahunan</h3>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem;">Analisis komprehensif data PSE sepanjang tahun.</p>
                    
                    <div class="se-form-group" style="margin-bottom: auto;">
                        <label style="font-weight: 600; color: #475569; font-size: 0.9rem;">Pilih Tahun</label>
                        <select id="laporanTahun" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 10px; background: #f8fafc; font-size: 0.95rem;">
                            <option>2026</option>
                            <option>2025</option>
                            <option>2024</option>
                        </select>
                    </div>
                    
                    <button style="width: 100%; padding: 12px; background: #10b981; color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 1.5rem; transition: background 0.2s;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'" onclick="downloadLaporan('tahunan')">
                        <i class="fas fa-file-excel"></i> Download Excel
                    </button>
                </div>
                
                <!-- Card Statistik Kepatuhan -->
                <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0; transition: transform 0.3s ease; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="width: 60px; height: 60px; background: #fff7ed; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                        <i class="fas fa-shield-alt" style="color: #f59e0b; font-size: 1.8rem;"></i>
                    </div>
                    <h3 style="color: #1e293b; font-weight: 700; font-size: 1.3rem; margin-bottom: 0.5rem;">Statistik Kepatuhan</h3>
                    <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem;">Indikator performa kepatuhan penyelenggaraan sistem.</p>
                    
                    <div style="text-align: center; margin: auto 0; padding: 1.5rem; background: #f8fafc; border-radius: 16px; border: 1px dashed #cbd5e1;">
                        <h2 style="font-size: 3rem; font-weight: 800; color: #10b981; margin: 0; line-height: 1;">98%</h2>
                        <p style="color: #64748b; font-weight: 600; margin-top: 0.5rem;">Tingkat Kepatuhan</p>
                        <div style="width: 100%; height: 6px; background: #e2e8f0; border-radius: 10px; margin-top: 1rem; overflow: hidden;">
                            <div style="width: 98%; height: 100%; background: #10b981; border-radius: 10px;"></div>
                        </div>
                    </div>
                    
                    <button style="width: 100%; padding: 12px; background: white; color: #475569; border: 1px solid #cbd5e1; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 1.5rem; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'; this.style.borderColor='#94a3b8'" onmouseout="this.style.background='white'; this.style.borderColor='#cbd5e1'" onclick="alert('📊 Menampilkan detail statistik kepatuhan')">
                        <i class="fas fa-external-link-alt"></i> Lihat Detail Lengkap
                    </button>
                </div>
            </div>
        </div>

        <!-- PENGATURAN (REDESIGNED) -->
        <div id="page-setting" class="dashboard-content">
            <div class="dashboard-header" style="margin-bottom: 2rem;">
                <div>
                    <h2><i class="fas fa-cog" style="color: #64748b;"></i> Pengaturan Akun</h2>
                    <p style="color: #64748b; font-size: 0.9rem; margin-top: 5px;">Kelola preferensi akun dan tampilan aplikasi Anda</p>
                </div>
            </div>
            
            <div class="settings-grid">
                <!-- TAMPILAN -->
                <div class="setting-card">
                    <div class="setting-header">
                        <div class="icon-box bg-purple-light">
                            <i class="fas fa-palette" style="color: #8b5cf6;"></i>
                        </div>
                        <div>
                            <h3>Tampilan Aplikasi</h3>
                            <p>Sesuaikan tema dan kenyamanan visual</p>
                        </div>
                    </div>
                    <div class="setting-body">
                        <div class="setting-row">
                            <div class="setting-info">
                                <h4>Mode Gelap</h4>
                                <p>Aktifkan tema gelap untuk kenyamanan mata</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="darkModeToggle" onchange="toggleDarkMode()">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="setting-divider"></div>
                        <div class="setting-row">
                            <div class="setting-info">
                                <h4>Ukuran Font</h4>
                                <p>Sesuaikan ukuran teks aplikasi</p>
                            </div>
                            <select id="fontSizeSelect" class="setting-select" onchange="changeFontSize()">
                                <option value="small">Kecil</option>
                                <option value="medium" selected>Sedang</option>
                                <option value="large">Besar</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- NOTIFIKASI -->
                <div class="setting-card">
                    <div class="setting-header">
                        <div class="icon-box bg-blue-light">
                            <i class="fas fa-bell" style="color: #3b82f6;"></i>
                        </div>
                        <div>
                            <h3>Notifikasi</h3>
                            <p>Atur bagaimana Anda ingin menerima info</p>
                        </div>
                    </div>
                    <div class="setting-body">
                        <div class="setting-row">
                            <div class="setting-info">
                                <h4>Email Notifikasi</h4>
                                <p>Terima update status via email</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="emailNotif" checked onchange="saveNotificationSettings()">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="setting-divider"></div>
                        <div class="setting-row">
                            <div class="setting-info">
                                <h4>WhatsApp Notifikasi</h4>
                                <p>Terima pesan via WhatsApp (jika tersedia)</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="waNotif" checked onchange="saveNotificationSettings()">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- KEAMANAN -->
                <div class="setting-card full-width">
                    <div class="setting-header">
                        <div class="icon-box bg-green-light">
                            <i class="fas fa-shield-alt" style="color: #10b981;"></i>
                        </div>
                        <div>
                            <h3>Keamanan & Password</h3>
                            <p>Jaga keamanan akun Anda dengan password kuat</p>
                        </div>
                    </div>
                    <div class="setting-body">
                        <div class="form-grid-2">
                            <div class="se-form-group">
                                <label>Password Saat Ini</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-lock"></i>
                                    <input type="password" id="currentPassword" placeholder="Masukkan password lama">
                                </div>
                            </div>
                            <div class="se-form-group">
                                <label>Password Baru</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-key"></i>
                                    <input type="password" id="newPassword" placeholder="Password baru minimal 8 karakter">
                                </div>
                            </div>
                        </div>
                        <div class="action-row">
                            <button class="btn-se-primary" onclick="updatePassword()">
                                <i class="fas fa-save"></i> Update Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<style>
/* CSS PENGATURAN MODERN */
.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
}

.setting-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
}

.setting-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
}

.setting-card.full-width {
    grid-column: 1 / -1;
}

.setting-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 1rem;
    background: #ffffff;
}

.setting-header h3 {
    margin: 0;
    font-size: 1.1rem;
    color: #1e293b;
    font-weight: 600;
}

.setting-header p {
    margin: 2px 0 0;
    font-size: 0.85rem;
    color: #64748b;
}

.icon-box {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 1.25rem;
}

.bg-purple-light { background: #f3e8ff; }
.bg-blue-light { background: #dbeafe; }
.bg-green-light { background: #d1fae5; }

.setting-body {
    padding: 1.5rem;
}

.setting-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.setting-info h4 {
    margin: 0;
    font-size: 1rem;
    color: #334155;
    font-weight: 500;
}

.setting-info p {
    margin: 2px 0 0;
    font-size: 0.8rem;
    color: #94a3b8;
}

.setting-divider {
    height: 1px;
    background: #f1f5f9;
    margin: 1rem 0;
}

.setting-select {
    padding: 0.5rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    color: #334155;
    outline: none;
    cursor: pointer;
}

/* TOGGLE SWITCH */
.switch {
    position: relative;
    display: inline-block;
    width: 46px;
    height: 24px;
}

.switch input { opacity: 0; width: 0; height: 0; }

.slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #cbd5e1;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px; bottom: 3px;
    background-color: white;
    transition: .4s;
}

.slider.round { border-radius: 34px; }
.slider.round:before { border-radius: 50%; }

input:checked + .slider { background-color: #3b82f6; }
input:checked + .slider:before { transform: translateX(22px); }

/* FORM ELEMENTS */
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.input-with-icon {
    position: relative;
}

.input-with-icon i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.input-with-icon input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    outline: none;
    transition: border-color 0.2s;
}

.input-with-icon input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-se-primary {
    background: #3b82f6;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-se-primary:hover {
    background: #2563eb;
    transform: translateY(-1px);
}

/* DARK MODE STYLES */
body.dark-mode {
    background-color: #0f172a;
    color: #e2e8f0;
}

body.dark-mode .sidebar {
    background-color: #1e293b;
    border-right-color: #334155;
}

body.dark-mode .sidebar-menu li {
    color: #cbd5e1;
}

body.dark-mode .sidebar-menu li:hover {
    background-color: #334155;
}

body.dark-mode .sidebar-menu li.active {
    background-color: #3b82f6;
    color: white;
}

body.dark-mode .setting-card,
body.dark-mode .stat-card, 
body.dark-mode .table-box,
body.dark-mode .dashboard-header,
body.dark-mode .se-form-section,
body.dark-mode .modal-content {
    background-color: #1e293b;
    border-color: #334155;
    color: #e2e8f0;
}

body.dark-mode .setting-header,
body.dark-mode .setting-divider {
    border-color: #334155;
    background-color: #1e293b;
}

body.dark-mode .setting-header h3 { color: #f1f5f9; }
body.dark-mode .setting-info h4 { color: #f1f5f9; }
body.dark-mode h2 { color: #f1f5f9; }

body.dark-mode .input-with-icon input,
body.dark-mode select,
body.dark-mode .se-form-group input,
body.dark-mode .se-form-group select,
body.dark-mode .se-form-group textarea {
    background-color: #0f172a;
    border-color: #334155;
    color: white;
}

body.dark-mode .table th {
    background-color: #0f172a;
    color: #94a3b8;
    border-bottom-color: #334155;
}

body.dark-mode .table td {
    border-bottom-color: #334155;
    color: #cbd5e1;
}
</style>

<script>
// DARK MODE LOGIC
function toggleDarkMode() {
    const isDark = document.getElementById('darkModeToggle').checked;
    if (isDark) {
        document.body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
    } else {
        document.body.classList.remove('dark-mode');
        localStorage.setItem('theme', 'light');
    }
}

// Check saved theme on load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    const toggle = document.getElementById('darkModeToggle');
    
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        if (toggle) toggle.checked = true;
    }
});

function changeFontSize() {
    const size = document.getElementById('fontSizeSelect').value;
    if (size === 'small') document.body.style.fontSize = '14px';
    else if (size === 'large') document.body.style.fontSize = '18px';
    else document.body.style.fontSize = '16px';
}

function saveNotificationSettings() {
    const email = document.getElementById('emailNotif').checked;
    const wa = document.getElementById('waNotif').checked;
    alert(`✅ Pengaturan notifikasi disimpan!\n📧 Email: ${email ? 'Aktif' : 'Nonaktif'}\n📱 WhatsApp: ${wa ? 'Aktif' : 'Nonaktif'}`);
}
</script>

        <!-- HALAMAN EDIT RIWAYAT (UNTUK PEMBAHARUAN) - TAMBAHAN BARU -->
        <div id="page-edit-riwayat" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-edit"></i> Edit / Pembaharuan Pengajuan SE</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="editRiwayatUserName">-</span>
                </div>
            </div>
            
            <div class="se-form-section">
                <form id="formEditRiwayat">
                    <input type="hidden" id="edit_riwayat_id">
                    
                    <div class="se-form-grid">
                        <!-- KOLOM KIRI -->
                        <div>
                            <div class="se-form-group">
                                <label>Instansi</label>
                                <input type="text" id="edit_riwayat_instansi" placeholder="Pemerintah Kota Probolinggo">
                            </div>
                            <div class="se-form-group">
                                <label>Unit Kerja pemilik Sistem Elektronik</label>
                                <select id="edit_riwayat_unitkerja">
                                    <option value="">--Pilih Unit Kerja--</option>
                                    <option>Bagian Umum</option>
                                    <option>Bagian Pemerintahan</option>
                                    <option>Bagian Perekonomian dan Pembangunan</option>
                                    <option>Bagian Hukum</option>
                                    <option>Bagian Kesejahteraan Rakyat</option>
                                    <option>Bagian Organisasi</option>
                                    <option>Bagian Protokol dan Komunikasi Pimpinan</option>
                                    <option>Bagian Pengadaan Barang dan Jasa</option>
                                    <option>Badan Pendapatan, Pengolaan Keuangan dan Aset Daerah</option>
                                    <option>Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah</option>
                                    <option>Badan Penanggulangan Bencana Daerah</option>
                                    <option>Badan Kepegawaian dan Pengembangan SDM</option>
                                    <option>Badan Kesatuan Bangsa dan Politik</option>
                                    <option>Dinas Kependudukan dan Pencatatan Sipil</option>
                                    <option>Dinas Ketahanan Pangan Pertanian dan Perikanan</option>
                                    <option>Dinas Kesehatan, Pengedalian Penduduk, dan Keluarga Berencana</option>
                                    <option>Dinas Koperasi, Usaha Kecil dan Menengah dan Perdagangan</option>
                                    <option>Dinas Perindustrian dan Tenaga Kerja</option>
                                    <option>Dinas Perhubungan</option>
                                    <option>Dinas Lingkungan Hidup</option>
                                    <option>Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu</option>
                                    <option>Dinas Kepemudaan, Olahraga dan Pariwisata</option>
                                    <option>Dinas Sosial, Pemberdayaan Perempuan dan Perlindungan Anak</option>
                                    <option>Dinas Komunikasi dan Informatika</option>
                                    <option>Dinas Perpustakaan dan Kearsipan</option>
                                    <option>Dinas Pendidikan dan Kebudayaan</option>
                                    <option>Dinas Pekerjaan Umum, Penataan Ruang, Perumahan dan Kawasan Permukiman</option>
                                    <option>Kecamatan Mayangan</option>
                                    <option>Kecamatan Wonoasih</option>
                                    <option>Kecamatan Kademangan</option>
                                    <option>Kecamatan Kedopok</option>
                                    <option>Kecamatan Kanigaran</option>
                                    <option>Sekretariat Dewan</option>
                                    <option>RSUD Dokter Mohammad Saleh</option>
                                    <option>RSUD Ar Rozy</option>
                                    <option>Inspektorat</option>
                                    <option>Satuan Polisi Pamong Praja</option>
                                </select>
                            </div>
                            <div class="se-form-group">
                                <label>Nama Sistem Elektronik</label>
                                <input type="text" id="edit_riwayat_nama" placeholder="Contoh: Sistem Informasi Pelayanan Publik">
                            </div>
                            <div class="se-form-group">
                                <label>Versi Sistem Elektronik</label>
                                <input type="text" id="edit_riwayat_versi" placeholder="Contoh: 2.5.1">
                            </div>
                            <div class="se-form-group">
                                <label>Bidang/Sektor Sistem Elektronik</label>
                                <select id="edit_riwayat_bidang">
                                    <option value="">--Pilih Bidang/Sektor--</option>
                                    <option>Layanan Pemerintahan</option>
                                    <option>Layanan Pusat</option>
                                    <option>Layanan Institusi</option>
                                </select>
                            </div>
                            <div class="se-form-group">
                                <label>Narahubung Sistem Elektronik</label>
                                <input type="text" id="edit_riwayat_narahubung">
                            </div>
                            <div class="se-form-group">
                                <label>No. Tipe /HP: Narahubung</label>
                                <input type="text" id="edit_riwayat_telepon">
                            </div>
                        </div>
                        
                        <!-- KOLOM KANAN -->
                        <div>
                            <div class="se-form-group">
                                <label>Uniform Resource Locator (URL): Situ Web</label>
                                <input type="text" id="edit_riwayat_url" placeholder="Contoh: https://layanan.gold">
                            </div>
                            <div class="se-form-group">
                                <label>Sistem Nama Domain (DNS)/Alamat Internet IP Server</label>
                                <input type="text" id="edit_riwayat_dns" placeholder="Contoh: 192.168.1.100 atau layanan gold">
                            </div>
                            <div class="se-form-group">
                                <label>Deskripsi Singkat Fungsi dan Proses Bisnis Sistem Elektronik</label>
                                <textarea id="edit_riwayat_deskripsi" placeholder="Contoh: Sistem ini digunakan untuk mengelola layanan publik secara elektronik, meliputi pendaftaran, verifikasi, dan pelaporan." rows="4"></textarea>
                            </div>
                            
                            <!-- Kategori Sistem Elektronik Berdasarkan Asas Risiko (Edit) -->
                            <div class="se-form-group">
                                <label>Kategori Sistem Elektronik Berdasarkan Asas Risiko</label>
                                <div style="margin-bottom: 10px;">
                                    <select id="edit_riwayat_risiko" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; background: white;">
                                        <option value="">-- Pilih Kategori Risiko --</option>
                                        <option value="Strategis">🏛️ Strategis</option>
                                        <option value="Tinggi">⚠️ Tinggi</option>
                                        <option value="Rendah">✅ Rendah</option>
                                    </select>
                                </div>
                                <div class="upload-group">
                                    <input type="text" id="edit_riwayat_risiko_file" placeholder="Pilih file pendukung..." value="" readonly style="background-color: #f8fafc;">
                                    <input type="file" id="edit_riwayat_risiko_file_input" style="display: none;" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileUpload(this, 'edit_riwayat_risiko_file', 'edit_riwayat_risiko_info')">
                                    <button type="button" class="upload-btn" onclick="document.getElementById('edit_riwayat_risiko_file_input').click()">
                                        <i class="fas fa-folder-open"></i> Pilih File
                                    </button>
                                </div>
                                <div id="edit_riwayat_risiko_info" class="file-info" style="display: none;">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="file-name" id="edit_riwayat_risiko_file_name"></span>
                                    <span class="file-size" id="edit_riwayat_risiko_file_size"></span>
                                    <button type="button" class="upload-btn-small" onclick="gantiFile('edit_riwayat_risiko')">
                                        <i class="fas fa-sync-alt"></i> Ganti
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Klasifikasi Data Sesuai Risiko (Edit) -->
                            <div class="se-form-group">
                                <label>Klasifikasi Data Sesuai Risiko</label>
                                <div style="margin-bottom: 10px;">
                                    <select id="edit_riwayat_klasifikasi" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; background: white;">
                                        <option value="">-- Pilih Klasifikasi Data --</option>
                                        <option value="Terbuka">🌐 Terbuka</option>
                                        <option value="Terbatas">🔒 Terbatas</option>
                                        <option value="Tertutup">🔐 Tertutup</option>
                                    </select>
                                </div>
                                <div class="upload-group">
                                    <input type="text" id="edit_riwayat_klasifikasi_file" placeholder="Pilih file pendukung..." value="" readonly style="background-color: #f8fafc;">
                                    <input type="file" id="edit_riwayat_klasifikasi_file_input" style="display: none;" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileUpload(this, 'edit_riwayat_klasifikasi_file', 'edit_riwayat_klasifikasi_info')">
                                    <button type="button" class="upload-btn" onclick="document.getElementById('edit_riwayat_klasifikasi_file_input').click()">
                                        <i class="fas fa-folder-open"></i> Pilih File
                                    </button>
                                </div>
                                <div id="edit_riwayat_klasifikasi_info" class="file-info" style="display: none;">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="file-name" id="edit_riwayat_klasifikasi_file_name"></span>
                                    <span class="file-size" id="edit_riwayat_klasifikasi_file_size"></span>
                                    <button type="button" class="upload-btn-small" onclick="gantiFile('edit_riwayat_klasifikasi')">
                                        <i class="fas fa-sync-alt"></i> Ganti
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Keterangan Data Pribadi yang Diproses (Edit) - HANYA TEXTAREA -->
                            <div class="se-form-group">
                                <label>Keterangan Data Pribadi yang Diproses</label>
                                <textarea id="edit_riwayat_data_pribadi" placeholder="Contoh: Data pribadi yang diproses meliputi nama, alamat, nomor telepon, email, dan ..." rows="3" style="resize: vertical; width: 100%;"></textarea>
                                <!-- BAGIAN UPLOAD FILE TELAH DIHAPUS -->
                            </div>
                            
                            <!-- Lokasi Pengelolaan/Pemrosesan/Penyimpanan (Edit) - HANYA 2 PILIHAN -->
                            <div class="se-form-group">
                                <label>Lokasi Pengelolaan/Pemrosesan/Penyimpanan</label>
                                <select id="edit_riwayat_lokasi" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; background: white;">
                                    <option value="">-- Pilih Lokasi --</option>
                                    <option value="Dalam Negeri">🇮🇩 Dalam Negeri</option>
                                    <option value="Luar Negeri">🌏 Luar Negeri</option>
                                </select>
                                <!-- BAGIAN UPLOAD FILE TELAH DIHAPUS -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="se-section-divider">Penyelenggara Sistem Elektronik wajib melakukan</div>
                    
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="edit_riwayat_kewajiban1">
                            <label for="edit_riwayat_kewajiban1">Pemenuhan kewajiban untuk memastikan keamanan informasi sesuai dengan ketentuan peraturan perundang-undangan.</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="edit_riwayat_kewajiban2">
                            <label for="edit_riwayat_kewajiban2">Pemenuhan kewajiban untuk menyediakan sistem pengamanan yang mencakup prosedur dan sistem pencegahan dan penanggulangan terhadap ancaman dan serangan yang menimbulkan gangguan, kegagalan, dan kerugian sesuai dengan ketentuan peraturan perundang-undangan.</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="edit_riwayat_kewajiban3">
                            <label for="edit_riwayat_kewajiban3">Pemenuhan kewajiban melakukan pelindungan Data Pribadi sesuai dengan ketentuan peraturan perundang-undangan.</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="edit_riwayat_kewajiban4">
                            <label for="edit_riwayat_kewajiban4">Pemenuhan keamanan elektronik sebagai penyediaan data elektronik nasional dan asisten elektronik sistem pemerintahan berbasis elektronik institusi Pusat dan Pemerintah Daerah sesuai dengan ketentuan peraturan perundang-undangan dalam penyelenggaraan sistem elektronik.</label>
                        </div>
                    </div>
                    
                    <div class="se-form-group" style="margin-top: 1.5rem;">
                        <label>Dokumen Pendukung (Optional)</label>
                        <div class="upload-group">
                            <input type="text" id="edit_riwayat_dokumen" placeholder="Pilih file pendukung..." readonly style="background-color: #f8fafc;">
                            <input type="file" id="edit_riwayat_dokumen_input" style="display: none;" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileUpload(this, 'edit_riwayat_dokumen', 'edit_riwayat_dokumen_info')">
                            <button type="button" class="upload-btn" onclick="document.getElementById('edit_riwayat_dokumen_input').click()">
                                <i class="fas fa-folder-open"></i> Pilih File
                            </button>
                        </div>
                        <div id="edit_riwayat_dokumen_info" class="file-info" style="display: none;">
                            <i class="fas fa-check-circle"></i>
                            <span class="file-name" id="edit_riwayat_dokumen_file_name"></span>
                            <span class="file-size" id="edit_riwayat_dokumen_file_size"></span>
                            <button type="button" class="upload-btn-small" onclick="gantiFile('edit_riwayat_dokumen')">
                                <i class="fas fa-sync-alt"></i> Ganti
                            </button>
                        </div>
                    </div>
                    
                    <!-- Informasi Status -->
                    <div style="background: #f0f9ff; padding: 1rem; border-radius: 8px; margin: 1.5rem 0;">
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                            <div>
                                <label style="font-weight: 600; color: #0f172a; font-size: 0.9rem;">Nomor Pengajuan</label>
                                <p style="color: #1e40af; font-weight: 700;" id="edit_riwayat_nomor">-</p>
                            </div>
                            <div>
                                <label style="font-weight: 600; color: #0f172a; font-size: 0.9rem;">Tanggal Pengajuan</label>
                                <p style="color: #334155;" id="edit_riwayat_tanggal">-</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="se-actions">
                        <button type="button" class="btn-se-secondary" onclick="batalEditRiwayat()">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="button" class="btn-se-draft" onclick="simpanDraftEditRiwayat()">
                            <i class="fas fa-save"></i> Simpan Draft
                        </button>
                        <button type="submit" class="btn-se-success">
                            <i class="fas fa-paper-plane"></i> Kirim Pembaharuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<!-- HALAMAN PUBLIC (BERANDA, CARI, TENTANG, PANDUAN, STATISTIK) -->
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
            <div style="display:flex; justify-content:center;">
                <div id="sertifikatPrint" style="width: 297mm; min-height: 210mm; height: auto; background: white; padding: 10mm 15mm; box-sizing: border-box; border: 10px double #1e40af; outline: 2px solid #3b82f6; outline-offset: -10px; display: flex; flex-direction: column;">
                    <div style="text-align:center; margin-bottom: 5px;">
                        <img src="Logo Diskominfo Solusi.png" alt="Logo" onerror="this.style.display='none'" style="height:100px; margin-bottom:10px;" crossorigin="anonymous">
                        <h2 style="margin:0; font-size:24px; text-transform:uppercase; color:#1e293b;">Dinas Komunikasi dan Informatika</h2>
                        <h3 style="margin:0; font-size:18px; font-weight:normal; color:#334155;">Pemerintah Daerah</h3>
                    </div>
                    <div style="text-align:center; flex:1; display:flex; flex-direction:column; justify-content:flex-start; padding-top:5px;">
                        <div style="font-size:28px; font-weight:bold; text-decoration:underline; margin-bottom:2px; color:#1e40af; letter-spacing:1px;">TANDA DAFTAR PENYELENGGARA SISTEM ELEKTRONIK</div>
                        <div style="font-size:14px; margin-bottom:10px; color:#64748b; font-weight:bold;">Nomor: <span id="sertifikatNomor">PSE-200/2026</span></div>
                        <p style="font-size:18px; margin-bottom:5px;">Diberikan kepada:</p>
                        <h1 id="sertifikatNamaInstansi" style="font-size:32px; margin:5px 0 10px; text-transform:uppercase; color:#0f172a;">PEMERINTAH KOTA PROBOLINGGO</h1>
                        <p style="font-size:18px; margin-bottom:5px;">Atas pendaftaran sistem elektronik:</p>
                        <h2 id="sertifikatNamaSE" style="font-size:26px; margin:5px 0 15px; color:#1e40af; font-style:italic;">"-"</h2>
                        <div style="margin:5px auto; width:90%; text-align:left; font-size:16px; line-height:1.4;">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <td style="vertical-align:top; padding:4px 5px; width:200px; font-weight:bold; color:#334155;">Tanggal Terbit</td>
                                    <td style="vertical-align:top; padding:4px 5px; width:20px; text-align:center;">:</td>
                                    <td style="vertical-align:top; padding:4px 5px;" id="sertifikatTanggal">-</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:top; padding:4px 5px; width:200px; font-weight:bold; color:#334155;">Unit Kerja / Bidang</td>
                                    <td style="vertical-align:top; padding:4px 5px; width:20px; text-align:center;">:</td>
                                    <td style="vertical-align:top; padding:4px 5px;" id="sertifikatUnitKerja">-</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align:top; padding:4px 5px; width:200px; font-weight:bold; color:#334155;">Website / URL</td>
                                    <td style="vertical-align:top; padding:4px 5px; width:20px; text-align:center;">:</td>
                                    <td style="vertical-align:top; padding:4px 5px;" id="sertifikatURL">-</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div style="margin-top:auto; text-align:right; margin-right:40px; padding-bottom:5px;">
                        <div style="display:inline-block; text-align:center; width:300px;">
                            <p>Ditetapkan di: Kota Probolinggo</p>
                            <p>Pada Tanggal: <span id="sertifikatJakartaTanggal">19 Februari 2026</span></p>
                            <p style="margin-top:15px;">Kepala Dinas Komunikasi dan Informatika</p>
                            <div style="font-weight:bold; text-decoration:underline; margin-top:60px; font-size:16px;" id="sertifikatNamaKadis">NAMA KEPALA DINAS</div>
                            <div style="font-size:14px; margin-top:2px;" id="sertifikatNipKadis">NIP. ...................................</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="sertifikat-actions">
               
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
    <div class="close" onclick="closeAuth()">✖</div>
    <h2 id="authTitle">Login Dashboard</h2>
    
    <!-- LOGIN FORM -->
    <form id="loginForm" class="login-form active" action="login.php" method="POST">
        <input type="text" name="username" id="loginUsername" placeholder="Username / Email" required>
        <input type="password" name="password" id="loginPassword" placeholder="Password" required>
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
        <input type="text" name="fullname" id="regFullname" placeholder="Nama Lengkap *" required>
        
        <div class="form-row">
            <div class="input-wrapper">
                <input type="text" name="nip" id="regNIP" placeholder="NIP *" maxlength="18" oninput="validateNIP(this)" onkeypress="return hanyaAngka(event)" required>
                <!-- TIDAK ADA LAGI PESAN ERROR -->
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
                <!-- TIDAK ADA LAGI PESAN ERROR -->
            </div>
        </div>
        
        <div class="form-row">
            <input type="password" name="password" id="regPassword" placeholder="Password *" required>
            <input type="text" name="instansi" id="regInstansi" placeholder="Instansi *" required>
        </div>
        
        <div class="password-requirements">
            <p style="margin-bottom: 0.5rem; font-weight: 600;">Syarat Password:</p>
            <ul>
                <li id="reg-req-length"><i class="fas fa-circle"></i> Minimal 8 karakter</li>
                <li id="reg-req-max"><i class="fas fa-circle"></i> Maksimal 16 karakter</li>
                <li id="reg-req-letter"><i class="fas fa-circle"></i> Mengandung huruf</li>
                <li id="reg-req-number"><i class="fas fa-circle"></i> Mengandung angka</li>
            </ul>
        </div>
        
        <button type="submit" class="btn-register">Daftar Akun</button>
        <div class="switch">
            Sudah punya akun? <span onclick="showLoginForm()">Masuk Sekarang</span>
        </div>
        <div class="switch" style="margin-top: 0.5rem;">
            <span onclick="showForgotPassword()">Lupa Password?</span>
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
            <i class="fas fa-lock"></i> Masukkan kode verifikasi dan password baru Anda.
        </div>
        
        <input type="hidden" id="resetUserId" value="">
        
        <div class="se-form-group">
            <label>Kode Verifikasi</label>
            <input type="text" id="verificationCode" placeholder="Masukkan kode 6 digit" class="otp-input" maxlength="6">
            <div style="font-size: 0.8rem; margin-top: 5px; color: #64748b;">
                <i class="fas fa-clock"></i> Kode berlaku: <span id="timerDisplay" class="timer">05:00</span>
            </div>
        </div>
        
        <div class="se-form-group">
            <label>Password Baru</label>
            <input type="password" id="newResetPassword" placeholder="Minimal 8 karakter">
        </div>
        
        <div class="se-form-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" id="confirmResetPassword" placeholder="Ulangi password baru">
        </div>
        
        <div class="password-requirements">
            <p style="margin-bottom: 0.5rem; font-weight: 600;">Syarat Password:</p>
            <ul>
                <li id="reset-req-length"><i class="fas fa-circle"></i> Minimal 8 karakter</li>
                <li id="reset-req-max"><i class="fas fa-circle"></i> Maksimal 16 karakter</li>
                <li id="reset-req-letter"><i class="fas fa-circle"></i> Mengandung huruf</li>
                <li id="reset-req-number"><i class="fas fa-circle"></i> Mengandung angka</li>
            </ul>
        </div>
        
        <button onclick="resetPassword()" id="resetPasswordBtn">Ubah Password</button>
        <div class="switch" style="margin-top: 1rem;">
            <span onclick="showForgotPassword()">Kirim ulang kode</span> • 
            <span onclick="showLoginForm()">Kembali ke Login</span>
        </div>
    </div>
</div>
</div>

<script>
// ============================================
// DATA GLOBAL DAN PENYIMPANAN PER AKUN
// ============================================
let isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
let currentUser = <?php echo isset($_SESSION['user_id']) ? json_encode($_SESSION) : 'null'; ?>;
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

// Inisialisasi database
function initDatabase() {
    // Tidak perlu inisialisasi localStorage lagi karena data diambil dari server
    console.log('Sistem siap dengan data dari server');
}

// Fungsi untuk memuat data pengajuan (Tidak digunakan lagi karena pakai PHP)
function loadUserData(username) {
    // Legacy function placeholder
}

// Fungsi untuk menyimpan data pengajuan (Tidak digunakan lagi karena pakai PHP)
function saveUserData(username) {
    // Legacy function placeholder
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

// ============================================
// FUNGSI AUTHENTICATION
// ============================================
function showAuth(mode) {
    // Di dashboard user, tidak perlu modal login. Redirect ke index.php
    window.location.href = 'index.php';
}

function closeAuth() {
    document.getElementById('authModal').style.display = 'none';
    showLoginForm();
    clearForms();
    
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
            document.getElementById('reg-req-length').className = pwd.length >= 8 ? 'valid' : 'invalid';
            document.getElementById('reg-req-max').className = pwd.length <= 16 ? 'valid' : 'invalid';
            document.getElementById('reg-req-letter').className = /[a-zA-Z]/.test(pwd) ? 'valid' : 'invalid';
            document.getElementById('reg-req-number').className = /[0-9]/.test(pwd) ? 'valid' : 'invalid';
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
        alert('❌ Lengkapi semua data wajib (bertanda *)');
        return;
    }
    
    // Validasi NIP: maksimal 18 karakter, tanpa spasi, hanya angka
    if (nip.length > 18) {
        alert('❌ NIP maksimal 18 karakter!');
        return;
    }
    
    if (nip.includes(' ')) {
        alert('❌ NIP tidak boleh mengandung spasi!');
        return;
    }
    
    if (!/^\d+$/.test(nip)) {
        alert('❌ NIP hanya boleh berisi angka!');
        return;
    }
    
    // Validasi Email: harus mengandung @
    if (!email.includes('@')) {
        alert('❌ Email harus valid dan mengandung karakter @!');
        return;
    }
    
    // Validasi format email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('❌ Format email tidak valid! Contoh: nama@domain.com');
        return;
    }
    
    if (!validatePassword(password)) {
        alert('❌ Password harus 8-16 karakter dan mengandung huruf dan angka');
        return;
    }

    // Cek apakah username sudah ada
    if (localStorage.getItem('pseUser_' + username)) {
        alert('❌ Username sudah digunakan!');
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
    
    alert('✅ Registrasi berhasil! Silakan login dengan akun baru Anda. Dashboard akan dimulai dari 0.');
    showLoginForm();
    clearForms();
}

function handleLogin() {
    const username = document.getElementById('loginUsername').value;
    const password = document.getElementById('loginPassword').value;

    if (!username || !password) {
        alert('❌ Lengkapi username dan password');
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
            alert('❌ Password salah');
        }
    } else {
        alert('❌ Username tidak ditemukan');
    }
}

function requestResetCode() {
    const username = document.getElementById('resetUsername').value;
    
    if (!username) {
        alert('❌ Masukkan username atau email');
        return;
    }
    
    // Cari user
    let foundUser = demoAccounts.find(acc => acc.username === username || acc.email === username);
    
    if (!foundUser) {
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key.startsWith('pseUser_')) {
                const user = JSON.parse(localStorage.getItem(key));
                if (user.username === username || user.email === username) {
                    foundUser = user;
                    break;
                }
            }
        }
    }
    
    if (foundUser) {
        const resetCode = Math.floor(100000 + Math.random() * 900000).toString();
        const expiry = new Date().getTime() + 5 * 60 * 1000;
        
        resetRequest = {
            userId: foundUser.username,
            code: resetCode,
            expiry: expiry,
            username: foundUser.username
        };
        
        sessionStorage.setItem('pse_reset_request', JSON.stringify(resetRequest));
        
        alert(`🔐 KODE VERIFIKASI ANDA: ${resetCode}\n\nKode berlaku selama 5 menit.`);
        
        document.getElementById('forgotPasswordForm').classList.remove('active');
        document.getElementById('resetPasswordForm').classList.add('active');
        document.getElementById('authTitle').innerText = 'Reset Password';
        document.getElementById('resetUserId').value = foundUser.username;
        
        startResetTimer(expiry);
    } else {
        alert('❌ Username/email tidak ditemukan');
    }
}

function startResetTimer(expiry) {
    const timerDisplay = document.getElementById('timerDisplay');
    
    if (timerInterval) {
        clearInterval(timerInterval);
    }
    
    timerInterval = setInterval(function() {
        const now = new Date().getTime();
        const distance = expiry - now;
        
        if (distance < 0) {
            clearInterval(timerInterval);
            timerDisplay.textContent = '00:00 (Kadaluarsa)';
            document.getElementById('verificationCode').disabled = true;
            document.getElementById('resetPasswordBtn').disabled = true;
            alert('⏰ Kode verifikasi telah kadaluarsa. Silakan minta kode baru.');
            showForgotPassword();
        } else {
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
    }, 1000);
}

function resetPassword() {
    const verificationCode = document.getElementById('verificationCode').value;
    const newPassword = document.getElementById('newResetPassword').value;
    const confirmPassword = document.getElementById('confirmResetPassword').value;
    const username = document.getElementById('resetUserId').value;
    
    if (!verificationCode || !newPassword || !confirmPassword) {
        alert('❌ Lengkapi semua field');
        return;
    }
    
    let request = sessionStorage.getItem('pse_reset_request');
    if (request) {
        request = JSON.parse(request);
    } else {
        request = resetRequest;
    }
    
    if (verificationCode !== request.code) {
        alert('❌ Kode verifikasi salah');
        return;
    }
    
    const now = new Date().getTime();
    if (now > request.expiry) {
        alert('❌ Kode verifikasi telah kadaluarsa');
        showForgotPassword();
        return;
    }
    
    if (!validatePassword(newPassword)) {
        alert('❌ Password harus 8-16 karakter dan mengandung huruf dan angka');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        alert('❌ Konfirmasi password tidak cocok');
        return;
    }
    
    let userUpdated = false;
    
    // Cek di demo accounts
    const demoIndex = demoAccounts.findIndex(acc => acc.username === username);
    if (demoIndex !== -1) {
        demoAccounts[demoIndex].password = newPassword;
        userUpdated = true;
    }
    
    // Cek di localStorage
    const userData = localStorage.getItem('pseUser_' + username);
    if (userData) {
        const user = JSON.parse(userData);
        user.password = newPassword;
        localStorage.setItem('pseUser_' + username, JSON.stringify(user));
        userUpdated = true;
    }
    
    if (userUpdated) {
        alert('✅ Password berhasil diubah! Silakan login dengan password baru Anda.');
        
        sessionStorage.removeItem('pse_reset_request');
        if (timerInterval) {
            clearInterval(timerInterval);
            timerInterval = null;
        }
        
        showLoginForm();
        clearForms();
    } else {
        alert('❌ Terjadi kesalahan. Silakan coba lagi.');
    }
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
    document.getElementById('profil_alamat').value = 'Jl. Raden Wijaya No. 45, Probolinggo';
    document.getElementById('profil_telp').value = user.noHP || '';
    
    // Isi form pendaftaran
    document.getElementById('se_instansi').value = 'Pemerintah Kota Probolinggo';
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
    
    console.log(`✅ Login berhasil untuk ${user.username} dengan ${databasePengajuan.length} pengajuan dan ${databaseSETerdaftar.length} SE terdaftar`);
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
        alert('❌ Silakan login terlebih dahulu!');
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
        jenis: '📝 Pendaftaran',
        status: 'Menunggu Verifikasi',
        statusText: '⏳ Menunggu Verifikasi',
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
        
        pengajuan.status = '✅ Diterima';
        pengajuan.statusText = '✅ Diterima';
        
        const noTandaDaftar = generateNoTandaDaftar();
        
        const seTerdaftarBaru = {
            id: Date.now() + Math.random(),
            instansi: pengajuan.instansi,
            unitKerja: pengajuan.unitKerja || '-',
            namaSE: pengajuan.namaSE,
            pejabat: currentUser.fullname,
            status: '✅ Terbit',
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
        alert('✅ Pengajuan disetujui dan SE berhasil terdaftar!');
    }
}

function tolakPengajuan(id) {
    if (!currentUser) return;
    
    const index = databasePengajuan.findIndex(p => p.id === id);
    if (index !== -1) {
        databasePengajuan[index].status = '❌ Ditolak';
        databasePengajuan[index].statusText = '❌ Ditolak';
        
        saveUserData(currentUser.username);
        loadAllData();
        alert('❌ Pengajuan ditolak!');
    }
}

function hapusPengajuan(id) {
    if (confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')) {
        const formData = new FormData();
        formData.append('id', id);

        fetch('delete_pengajuan.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('🗑️ ' + data.message);
                // Reload halaman untuk memperbarui daftar
                location.reload();
            } else {
                alert('❌ Gagal menghapus: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan saat menghapus data.');
        });
    }
}

function mintaPembaharuan(id) {
    if (!currentUser) return;
    
    const index = databasePengajuan.findIndex(p => p.id === id);
    if (index !== -1) {
        const pengajuan = databasePengajuan[index];
        
        pengajuan.status = '🔄 Permintaan Pembaharuan';
        pengajuan.statusText = '🔄 Permintaan Pembaharuan';
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
        databasePengajuan[index].status = '⛔ Permintaan Penghapusan';
        databasePengajuan[index].statusText = '⛔ Permintaan Penghapusan';
        databasePengajuan[index].jenis = 'Penghapusan';
        
        saveUserData(currentUser.username);
        loadAllData();
        alert('⛔ Permintaan penghapusan telah dikirim!');
    }
}

function hapusSETerdaftar(id) {
    if (confirm('Apakah Anda yakin ingin menghapus SE terdaftar ini?')) {
        const formData = new FormData();
        formData.append('id', id);

        fetch('delete_pengajuan.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('🗑️ ' + data.message);
                location.reload();
            } else {
                alert('❌ Gagal menghapus: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Terjadi kesalahan saat menghapus data.');
        });
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
    const ditolak = databasePengajuan.filter(p => p.status === '❌ Ditolak' || p.status === 'Ditolak').length;
    const dihapus = databaseSETerdaftar.filter(s => s.status === '🗑️ Dihapus').length;
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
        const badgeClass = item.status === '✅ Diterima' ? 'badge-green' : 
                          item.status === '❌ Ditolak' ? 'badge-red' : 'badge-orange';
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
        const badgeClass = item.status === '✅ Diterima' ? 'badge-green' : 
                          item.status === '❌ Ditolak' ? 'badge-red' : 'badge-orange';
        html += `<tr>
            <td>${item.tanggal}</td>
            <td>${item.aktivitas}</td>
            <td><span class="badge ${badgeClass}">${item.status}</span></td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
}

function loadRiwayat() {
    // DISABLING JS LOAD TO USE PHP RENDERED CONTENT
    console.log("loadRiwayat disabled to use PHP content");
    return;
}

function loadListSE() {
    // DISABLING JS LOAD TO USE PHP RENDERED CONTENT
    console.log("loadListSE disabled to use PHP content");
    return;
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
        const badgeClass = item.status === '✅ Diterima' ? 'badge-green' : 
                          item.status === '❌ Ditolak' ? 'badge-red' : 'badge-orange';
        
        let jenisPengajuan = 'Pendaftaran SE';
        if (item.jenis === 'Pembaharuan' || item.status.includes('Pembaharuan')) {
            jenisPengajuan = 'Pembaharuan SE';
        } else if (item.jenis === 'Penghapusan' || item.status.includes('Penghapusan')) {
            jenisPengajuan = 'Penghapusan SE';
        }
        
        html += `<tr>
            <td><button class="icon-btn" onclick="detailPengajuan(${item.id})">📄</button></td>
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
        const badgeClass = item.status === '✅ Diterima' ? 'badge-green' : 
                          item.status === '❌ Ditolak' ? 'badge-red' : 'badge-orange';
        
        let jenisPengajuan = 'Pendaftaran SE';
        if (item.jenis === 'Pembaharuan' || item.status.includes('Pembaharuan')) {
            jenisPengajuan = 'Pembaharuan SE';
        } else if (item.jenis === 'Penghapusan' || item.status.includes('Penghapusan')) {
            jenisPengajuan = 'Penghapusan SE';
        }
        
        html += `<tr>
            <td><button class="icon-btn" onclick="detailPengajuan(${item.id})">📄</button></td>
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
    alert('✅ Draft perubahan berhasil disimpan!');
}

// ============================================
// FUNGSI UPLOAD FILE
// ============================================
function handleFileUpload(input, targetInputId, infoDivId) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileName = file.name;
        const fileSize = (file.size / 1024).toFixed(2);
        
        const MAX_FILE_SIZE = 10 * 1024 * 1024;
        
        if (file.size > MAX_FILE_SIZE) {
            alert('❌ Ukuran file maksimal 100MB! File Anda sebesar ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB.');
            input.value = '';
            return;
        }
        
        // Validasi tipe file diperluas (PDF, Images, Word, Excel)
        const allowedExtensions = ['pdf'];
        const fileExt = fileName.split('.').pop().toLowerCase();
        
        if (!allowedExtensions.includes(fileExt)) {
             alert('❌ Tipe file tidak didukung! Gunakan PDF, Word, Excel, JPG, atau PNG.');
             // input.value = ''; // Jangan hapus, biarkan user ganti sendiri atau PHP handle
             return;
        }
        
        // Update UI
        document.getElementById(targetInputId).value = fileName;
        
        const infoDiv = document.getElementById(infoDivId);
        // Fix ID matching logic
        const baseName = targetInputId.endsWith('_file') ? targetInputId : targetInputId + '_file';
        const fileNameSpan = document.getElementById(baseName + '_name');
        const fileSizeSpan = document.getElementById(baseName + '_size');
        
        if (fileNameSpan) fileNameSpan.textContent = fileName;
        if (fileSizeSpan) fileSizeSpan.textContent = '(' + fileSize + ' KB)';
        
        // Tampilkan info file
        if (infoDiv) infoDiv.style.display = 'flex';
        
        // Sembunyikan tombol upload agar terlihat sudah terisi (opsional, sesuaikan UI)
        const uploadBtn = input.parentElement.querySelector('.upload-btn');
        if (uploadBtn) uploadBtn.style.display = 'none';

        // JANGAN MENGHAPUS INPUT VALUE!
        // input.value = ''; // <--- Baris ini dihapus agar file tetap terkirim
    }
}

function gantiFile(baseId) {
    // Reset UI dan Input
    let inputId = baseId;
    if (!inputId.endsWith('_input')) {
        // Coba tebak ID input file
        if (document.getElementById(baseId + '_input')) inputId = baseId + '_input';
        else if (document.getElementById(baseId + '_file_input')) inputId = baseId + '_file_input';
    }
    
    const fileInput = document.getElementById(inputId);
    if (fileInput) {
        fileInput.value = ''; // Reset file input agar bisa pilih file yang sama
        fileInput.click(); // Buka dialog file
    }
    
    // Reset tampilan info (opsional, atau tunggu file baru dipilih)
    // const infoDiv = document.getElementById(baseId + '_info');
    // if (infoDiv) infoDiv.style.display = 'none';
}

// ============================================
// FUNGSI SERTIFIKAT
// ============================================
function lihatSertifikat(id) {
    const nid = parseInt(id, 10);
    let se = Array.isArray(databaseSETerdaftar) ? databaseSETerdaftar.find(s => parseInt(s.id, 10) === nid) : null;
    if (!se && Array.isArray(databasePengajuan)) {
        se = databasePengajuan.find(s => parseInt(s.id, 10) === nid);
    }
    if (!se) {
        fetch('get_detail_se.php?id=' + nid)
            .then(r => r.json())
            .then(res => {
                if (res && res.success && res.data) {
                    const d = res.data;
                    se = {
                        id: nid,
                        instansi: d.instansi,
                        unitKerja: d.unit_kerja,
                        namaSE: d.nama_se,
                        versi: d.versi_se || d.versi,
                        pejabat: d.fullname,
                        tanggalTerbit: d.tanggal_terbit ? new Date(d.tanggal_terbit).toLocaleDateString('id-ID') : (d.tanggal_pengajuan ? new Date(d.tanggal_pengajuan).toLocaleDateString('id-ID') : ''),
                        noTandaDaftar: d.nomor_tanda_daftar,
                        risiko: d.risiko,
                        klasifikasi: d.klasifikasi_data,
                        lokasi: d.lokasi_data
                    };
                    renderSertifikat(se);
                } else {
                    alert('Data tidak ditemukan!');
                }
            })
            .catch(() => alert('Terjadi kesalahan mengambil data.'));
        return;
    }
    renderSertifikat(se);
}

function renderSertifikat(se) {
    
    const tanggalTerbit = se.tanggalTerbit || se.tanggal || '19/02/2026';
    const parts = tanggalTerbit.split('/');
    let tahun = parseInt(parts[2] || '2026');
    let bulan = parts[1] || '02';
    let hari = parts[0] || '19';
    const masaBerlaku = `${hari}/${bulan}/${tahun + 5}`;
    
    const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const bulanIndex = parseInt(bulan) - 1;
    const tanggalJakarta = `${hari} ${bulanIndo[bulanIndex] || 'Februari'} ${tahun}`;
    
    const setText = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val || '-'; };
    setText('sertifikatNomor', se.noTandaDaftar || 'PSE-XXX/2026');
    setText('sertifikatInstansi', se.instansi || '-');
    setText('sertifikatUnitKerja', se.unitKerja || '-');
    setText('sertifikatNamaSE', se.namaSE || '-');
    setText('sertifikatVersi', se.versi || '');
    setText('sertifikatPejabat', se.pejabat || currentUser?.fullname || '');
    setText('sertifikatTanggal', se.tanggalTerbit || se.tanggal || '19/02/2026');
    setText('sertifikatMasaBerlaku', masaBerlaku);
    setText('sertifikatRisiko', se.risiko || '');
    setText('sertifikatKlasifikasi', se.klasifikasi || '');
    setText('sertifikatLokasi', se.lokasi || '');
    setText('sertifikatJakartaTanggal', tanggalJakarta);
    setText('sertifikatNamaInstansi', ((se.fullname || se.pejabat || (currentUser && currentUser.fullname) || 'Penerima')).toUpperCase());
    setText('sertifikatURL', se.url || '-');
    fetch('get_super_admin.php')
        .then(r => r.json())
        .then(info => {
            if (info && info.success && info.data) {
                const nama = (info.data.fullname || 'Kepala Dinas').toUpperCase();
                const nip = info.data.nip ? ('NIP. ' + info.data.nip) : 'NIP. ...................................';
                setText('sertifikatNamaKadis', nama);
                setText('sertifikatNipKadis', nip);
            } else {
                setText('sertifikatNamaKadis', 'Kepala Dinas');
                setText('sertifikatNipKadis', 'NIP. ...................................');
            }
        })
        .catch(() => {
            setText('sertifikatNamaKadis', 'Kepala Dinas');
            setText('sertifikatNipKadis', 'NIP. ...................................');
        });
    
    document.getElementById('sertifikatModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    window.__sertifikatData = se;
}

function tutupSertifikat() {
    document.getElementById('sertifikatModal').style.display = 'none';
    document.body.style.overflow = '';
}

function cetakSertifikat() {
    window.print();
}

async function downloadSertifikat() {
    const ensureScript = (src, check) => new Promise((resolve, reject) => {
        if (check()) return resolve();
        const s = document.createElement('script');
        s.src = src;
        s.onload = resolve;
        s.onerror = () => reject(new Error('Gagal memuat ' + src));
        document.body.appendChild(s);
    });
    try {
        await ensureScript('https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js', () => typeof window.html2canvas !== 'undefined');
        await ensureScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', () => typeof window.jspdf !== 'undefined');
        const el = document.getElementById('sertifikatPrint');
        if (!el) { alert('Elemen sertifikat tidak ditemukan'); return; }
        const canvas = await html2canvas(el, { scale: 3, useCORS: true, backgroundColor: '#ffffff' });
        const imgData = canvas.toDataURL('image/png');
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('landscape', 'mm', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        const imgProps = pdf.getImageProperties(imgData);
        const margin = 5;
        let imgWidth = pageWidth - margin * 2;
        let imgHeight = imgProps.height * imgWidth / imgProps.width;
        if (imgHeight > pageHeight - margin * 2) {
            imgHeight = pageHeight - margin * 2;
            imgWidth = imgProps.width * imgHeight / imgProps.height;
        }
        const x = (pageWidth - imgWidth) / 2;
        const y = (pageHeight - imgHeight) / 2;
        pdf.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);
        const nomor = window.__sertifikatData?.noTandaDaftar || 'PSE';
        const nama = window.__sertifikatData?.namaSE || 'Sertifikat';
        pdf.save(`Sertifikat-${nomor}-${nama}.pdf`);
    } catch (e) {
        alert('Gagal mengunduh PDF: ' + e.message);
    }
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
function toggleSidebarDesktop() {
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('sidebarIcon');
    
    sidebar.classList.toggle('closed');
    
    if (sidebar.classList.contains('closed')) {
        icon.classList.remove('fa-chevron-left');
        icon.classList.add('fa-chevron-right');
    } else {
        icon.classList.remove('fa-chevron-right');
        icon.classList.add('fa-chevron-left');
    }
}

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


function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const mainContent = document.querySelector('.main-content');
    
    if (window.innerWidth > 991) {
        // Desktop Toggle
        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('expanded');
    } else {
        // Mobile Toggle
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        
        if (sidebar.classList.contains('active')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }
}

function closeMobileMenu() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

const overlay = document.getElementById('overlay');
if (overlay) {
    overlay.addEventListener('click', closeMobileMenu);
}

// ============================================
// FUNGSI FORM PENDAFTARAN SE
// ============================================
function showPendaftaranSE() {
    // Di dashboard user, user pasti sudah login
    
    // Reset form terlebih dahulu agar bersih saat dibuka baru
    const form = document.getElementById('formPendaftaranSE');
    if (form) form.reset();
    
    // Kembalikan visibilitas tombol ajukan (jika sebelumnya disembunyikan)
    const btnAjukan = document.getElementById('btnAjukanPengajuan');
    if (btnAjukan) btnAjukan.style.display = 'inline-block';

    document.querySelectorAll('.sidebar li').forEach(li => li.classList.remove('active'));
    // Note: Menu sidebar pendaftaran disembunyikan (display:none), tapi class active tetap bisa ditambahkan untuk logika internal jika perlu,
    // atau kita highlight menu dashboard/list tergantung konteks. 
    // Untuk saat ini biarkan logic sidebar active di pendaftaran (meski hidden) agar content switcher bekerja.
    const menuPendaftaran = document.querySelector('.sidebar li[data-target="page-pendaftaran"]');
    if (menuPendaftaran) menuPendaftaran.classList.add('active');
    
    document.querySelectorAll('.dashboard-content').forEach(c => c.classList.remove('active'));
    document.getElementById('page-pendaftaran').classList.add('active');
    
    // Scroll ke atas
    window.scrollTo(0, 0);
}

function resetFormSE(e) {
    if (e) e.preventDefault();
    
    if (confirm('Apakah Anda yakin ingin mereset form?')) {
        document.getElementById('formPendaftaranSE').reset();
        
        // Auto-fill user data if available from PHP session injection
        if (typeof currentUser !== 'undefined' && currentUser) {
            document.getElementById('se_instansi').value = 'Pemerintah Kota Probolinggo';
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
    // Di dashboard user, user pasti sudah login
    
    // Gunakan key yang lebih umum jika currentUser tidak terdeteksi (fallback)
    const username = (typeof currentUser !== 'undefined' && currentUser) ? currentUser.username : 'user_session';
    
    // Helper to safely get value
    const getVal = (id) => {
        const el = document.getElementById(id);
        return el ? el.value : '';
    };

    const draftData = {
        instansi: getVal('se_instansi'),
        unitKerja: getVal('se_unitkerja'),
        namaSE: getVal('se_nama'),
        versi: getVal('se_versi'),
        bidang: getVal('se_bidang'),
        narahubung: getVal('se_narahubung'),
        telepon: getVal('se_telepon'),
        url: getVal('se_url'),
        dns: getVal('se_dns'),
        deskripsi: getVal('se_deskripsi'),
        risiko: getVal('se_risiko'),
        klasifikasi: getVal('se_klasifikasi'),
        dataPribadi: getVal('se_data_pribadi'),
        lokasi: getVal('se_lokasi'),
        timestamp: new Date().toISOString()
    };
    
    localStorage.setItem('pse_draft_' + username, JSON.stringify(draftData));
    
    const fd = new FormData();
    fd.append('instansi', draftData.instansi);
    fd.append('unit_kerja', draftData.unitKerja);
    fd.append('nama_se', draftData.namaSE || getVal('se_nama'));
    fd.append('versi', draftData.versi);
    fd.append('bidang', draftData.bidang);
    fd.append('narahubung', draftData.narahubung);
    fd.append('telepon', draftData.telepon);
    fd.append('url', draftData.url);
    fd.append('dns', draftData.dns);
    fd.append('deskripsi', draftData.deskripsi);
    fd.append('risiko', draftData.risiko);
    fd.append('klasifikasi', draftData.klasifikasi);
    fd.append('data_pribadi', draftData.dataPribadi);
    fd.append('lokasi', draftData.lokasi);
    
    fetch('save_draft_pengajuan.php', { method: 'POST', body: fd })
        .then(r => r.text())
        .then(text => {
            let res = {};
            try { res = JSON.parse(text); } catch(e) { res = { success: false, message: text }; }
            if (res.success) {
                alert('✅ ' + res.message);
                document.querySelectorAll('.sidebar li').forEach(li => li.classList.remove('active'));
                document.querySelector('.sidebar li[data-target="page-riwayat"]').classList.add('active');
                document.querySelectorAll('.dashboard-content').forEach(c => c.classList.remove('active'));
                document.getElementById('page-riwayat').classList.add('active');
                const tbody = document.getElementById('riwayatBody');
                if (tbody && res.data) {
                    const d = res.data;
                    const id = d.id;
                    const statusText = d.status || 'Menunggu';
                    const statusClass = (statusText === 'Ditolak') ? 'badge-red' : (statusText === 'Terbit' || statusText === 'Diterima') ? 'badge-green' : 'badge-orange';
                    const statusIcon = (statusText === 'Ditolak') ? 'fa-times-circle' : (statusText === 'Terbit' || statusText === 'Diterima') ? 'fa-check-circle' : 'fa-clock';
                    const namaSe = d.nama_se || draftData.namaSE || '-';
                    const tanggal = d.tanggal_pengajuan ? new Date(d.tanggal_pengajuan).toLocaleString('id-ID') : new Date().toLocaleString('id-ID');
                    const canDelete = (statusText === 'Menunggu' || statusText === 'Dalam Pembaharuan' || statusText === 'Ditolak');
                    const rowHtml = "<tr style='border-bottom: 1px solid #f1f5f9;'>" +
                        "<td style='padding: 16px;'>" +
                        "<div style='display: flex; gap: 8px;'>" +
                        "<button onclick='detailPengajuan(" + id + ")' style='background: #eff6ff; color: #3b82f6; border: none; padding: 8px; border-radius: 8px; cursor: pointer;' title='Lihat Detail'><i class='fas fa-eye'></i></button>" +
                        "<button onclick='editPengajuan(" + id + ")' style='background: #f1f5f9; color: #334155; border: none; padding: 8px; border-radius: 8px; cursor: pointer;' title='Edit Pengajuan'><i class='fas fa-pencil-alt'></i></button>" +
                        (canDelete ? "<button onclick='deletePengajuan(" + id + ")' style='background: #fef2f2; color: #ef4444; border: none; padding: 8px; border-radius: 8px; cursor: pointer;' title='Batalkan/Hapus'><i class='fas fa-trash-alt'></i></button>" : "") +
                        "</div></td>" +
                        "<td style='padding: 16px;'><span style='background: #f1f5f9; color: #475569; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;'><i class='fas fa-file-import'></i> Pendaftaran</span></td>" +
                        "<td style='padding: 16px;'><span class='badge " + statusClass + "' style='display: inline-flex; align-items: center; gap: 5px;'><i class='fas " + statusIcon + "'></i> " + statusText + "</span></td>" +
                        "<td style='padding: 16px; font-weight: 500; color: #1e293b;'>" + namaSe + "</td>" +
                        "<td style='padding: 16px; color: #64748b;'>" + tanggal + "</td>" +
                        "</tr>";
                    tbody.insertAdjacentHTML('afterbegin', rowHtml);
                    const info = document.getElementById('riwayatInfo');
                    if (info) info.textContent = 'Data terbaru ditambahkan';
                }
            } else {
                alert('❌ ' + (res.message || 'Gagal menyimpan draft'));
            }
        })
        .catch(err => alert('❌ Terjadi kesalahan saat menyimpan draft: ' + err.message));
}

function loadDraft() {
    // Di dashboard user, user pasti sudah login. Pengecekan currentUser dihapus/disederhanakan
    
    // Gunakan key yang lebih umum jika currentUser tidak terdeteksi (fallback)
    const username = (typeof currentUser !== 'undefined' && currentUser) ? currentUser.username : 'user_session';
    const draftKey = 'pse_draft_' + username;
    const draft = localStorage.getItem(draftKey);
    
    if (draft) {
        try {
            const draftData = JSON.parse(draft);
            
            if (confirm('Draft ditemukan. Muat draft terakhir?')) {
                // Helper to safely set value
                const setVal = (id, val) => {
                    const el = document.getElementById(id);
                    if(el) el.value = val || '';
                };

                setVal('se_instansi', draftData.instansi);
                setVal('se_unit_kerja', draftData.unitKerja); // Sesuaikan ID elemen
                setVal('se_nama_se', draftData.namaSE);       // Sesuaikan ID elemen
                setVal('se_versi', draftData.versi);
                setVal('se_bidang', draftData.bidang);
                setVal('se_narahubung', draftData.narahubung);
                setVal('se_telepon', draftData.telepon);
                setVal('se_url', draftData.url);
                setVal('se_dns', draftData.dns);
                setVal('se_deskripsi', draftData.deskripsi);
                setVal('se_risiko', draftData.risiko);
                setVal('se_klasifikasi', draftData.klasifikasi);
                setVal('se_data_pribadi', draftData.dataPribadi);
                setVal('se_lokasi', draftData.lokasi);
                // File upload cannot be set programmatically for security reasons
                
                alert('✅ Draft berhasil dimuat!');
            }
        } catch (e) {
            console.error("Error parsing draft:", e);
            alert('❌ Gagal memuat draft (data rusak).');
        }
    } else {
        alert('ℹ️ Tidak ada draft tersimpan untuk akun ini.');
    }
}

function ajukanPengajuan() {
    // Di dashboard user, user pasti sudah login
    
    // Validasi checkbox kepatuhan
    const checkboxes = document.querySelectorAll('#page-pendaftaran input[type="checkbox"]:checked');
    if (checkboxes.length !== 4) {
        alert('❌ Harap centang SEMUA (4) pernyataan kepatuhan!');
        return;
    }
    
    // Helper to safely get value
    const getVal = (id) => {
        const el = document.getElementById(id);
        return el ? el.value : '';
    };

    // Validasi semua field wajib
    const requiredIds = [
        'se_instansi',
        'se_unitkerja',
        'se_nama',
        'se_versi',
        'se_bidang',
        'se_narahubung',
        'se_telepon',
        'se_url',
        'se_dns',
        'se_deskripsi',
        'se_risiko',
        'se_klasifikasi',
        'se_data_pribadi',
        'se_lokasi'
    ];
    for (let i = 0; i < requiredIds.length; i++) {
        const id = requiredIds[i];
        const el = document.getElementById(id);
        const val = el ? (el.value || '').trim() : '';
        if (!val) {
            alert('❌ Harap lengkapi semua data pada formulir sebelum mengirim pengajuan.');
            if (el && typeof el.focus === 'function') el.focus();
            return;
        }
    }
    // Validasi berkas wajib
    const fileRisiko = document.getElementById('se_risiko_file_input');
    const fileKlasifikasi = document.getElementById('se_klasifikasi_file_input');
    const filePendukung = document.getElementById('se_dokumen_input');
    if (!fileRisiko || fileRisiko.files.length === 0) {
        alert('❌ Harap unggah dokumen asesmen risiko.');
        return;
    }
    if (!fileKlasifikasi || fileKlasifikasi.files.length === 0) {
        alert('❌ Harap unggah dokumen klasifikasi data.');
        return;
    }
    // Dokumen pendukung bersifat opsional, tidak wajib diunggah
    
    // Submit form secara native (karena kita pakai PHP)
    const form = document.getElementById('formPendaftaranSE');
    if (form) {
        if(confirm('Apakah semua data sudah lengkap dan benar?')) {
            form.submit();
        }
    } else {
        alert('❌ Form tidak ditemukan!');
    }
}

// ============================================
// FUNGSI DETAIL DAN FILTER
// ============================================
function detailPengajuan(id) {
    // Tampilkan modal dengan loading state
    const modal = document.getElementById('modalDetailPengajuan');
    const modalBody = document.getElementById('modalDetailBody');
    
    modalBody.innerHTML = `
        <div style="text-align: center; padding: 2rem;">
            <i class="fas fa-spinner fa-spin fa-2x" style="color: #3b82f6;"></i>
            <p style="margin-top: 1rem; color: #64748b;">Memuat data...</p>
        </div>
    `;
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Prevent background scroll

    fetch('get_detail_se.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const d = data.data;
                
                // Helper untuk item detail
                const detailItem = (label, value) => `
                    <div class="detail-item">
                        <span class="detail-label">${label}</span>
                        <span class="detail-value">${value || '-'}</span>
                    </div>
                `;

                modalBody.innerHTML = `
                    <div class="detail-grid">
                        ${detailItem('Nomor Tanda Daftar', d.no_tanda_daftar)}
                        ${detailItem('Tanggal Pengajuan', d.tanggal_formatted)}
                        ${detailItem('Nama Sistem Elektronik', d.nama_se)}
                        ${detailItem('Instansi', d.instansi)}
                        ${detailItem('Bidang', d.bidang)}
                        ${detailItem('Narahubung', d.fullname)}
                        ${detailItem('Kontak (HP/WA)', d.no_hp)}
                        ${detailItem('Kategori Risiko', d.kategori_risiko)}
                        ${detailItem('Klasifikasi Data', d.klasifikasi_data)}
                        ${detailItem('Lokasi Server', d.lokasi_server)}
                        ${detailItem('Status Pengajuan', `<span class="badge ${d.status === 'Terbit' ? 'badge-green' : (d.status === 'Ditolak' ? 'badge-red' : 'badge-orange')}">${d.status}</span>`)}
                        ${detailItem('URL Sistem', d.url ? `<a href="${d.url}" target="_blank" style="color: #3b82f6; text-decoration: none;">${d.url} <i class="fas fa-external-link-alt"></i></a>` : '-')}
                        
                        <!-- Dokumen Pendukung -->
                        ${detailItem('Dokumen & Berkas', `
                            <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 5px;">
                                ${d.dokumen_pendukung ? `<a href="${d.dokumen_pendukung}" target="_blank" style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: #eff6ff; color: #3b82f6; border: 1px solid #dbeafe; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 500;"><i class="fas fa-file-pdf"></i> Dokumen Utama</a>` : ''}
                                ${d.file_risiko ? `<a href="${d.file_risiko}" target="_blank" style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 500;"><i class="fas fa-shield-alt"></i> Analisis Risiko</a>` : ''}
                                ${d.file_klasifikasi ? `<a href="${d.file_klasifikasi}" target="_blank" style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 500;"><i class="fas fa-file-contract"></i> Klasifikasi Data</a>` : ''}
                                ${!d.dokumen_pendukung && !d.file_risiko && !d.file_klasifikasi ? '<span style="color: #94a3b8; font-style: italic;">Tidak ada dokumen yang diupload</span>' : ''}
                            </div>
                        `)}
                    </div>
                `;
            } else {
                modalBody.innerHTML = `
                    <div style="text-align: center; color: #ef4444; padding: 2rem;">
                        <i class="fas fa-exclamation-circle fa-2x"></i>
                        <p style="margin-top: 1rem;">Gagal mengambil data: ${data.message}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            modalBody.innerHTML = `
                <div style="text-align: center; color: #ef4444; padding: 2rem;">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                    <p style="margin-top: 1rem;">Terjadi kesalahan saat mengambil data.</p>
                </div>
            `;
        });
}

function editPengajuan(id) {
    fetch('get_detail_se.php?id=' + id)
        .then(response => response.json())
        .then(res => {
            if (!res.success) { alert('❌ Data tidak ditemukan'); return; }
            const d = res.data || {};
            document.querySelectorAll('.sidebar li').forEach(li => li.classList.remove('active'));
            const menuPendaftaran = document.querySelector('.sidebar li[data-target="page-pendaftaran"]');
            if (menuPendaftaran) menuPendaftaran.classList.add('active');
            document.querySelectorAll('.dashboard-content').forEach(c => c.classList.remove('active'));
            document.getElementById('page-pendaftaran').classList.add('active');
            const setVal = (id, val) => { const el = document.getElementById(id); if (el) el.value = val || ''; };
            setVal('se_instansi', d.instansi || 'Pemerintah Kota Probolinggo');
            setVal('se_unitkerja', d.unit_kerja || '');
            setVal('se_nama', d.nama_se || '');
            setVal('se_versi', d.versi_se || d.versi || '');
            setVal('se_bidang', d.bidang_se || d.bidang || '');
            setVal('se_narahubung', d.fullname || '');
            setVal('se_telepon', d.no_hp || '');
            setVal('se_url', d.url || '');
            setVal('se_dns', d.ip_server || d.dns || '');
            setVal('se_deskripsi', d.deskripsi || '');
            setVal('se_risiko', d.risiko || '');
            setVal('se_klasifikasi', d.klasifikasi_data || '');
            setVal('se_data_pribadi', d.data_pribadi || '');
            setVal('se_lokasi', d.lokasi_data || '');
            window.scrollTo(0, 0);
        })
        .catch(()=>alert('❌ Gagal memuat data pengajuan'));
}

function deletePengajuan(id) {
    if (!confirm('Yakin ingin menghapus pengajuan ini?')) return;
    const fd = new FormData(); fd.append('id', id);
    fetch('delete_pengajuan.php', { method:'POST', body: fd })
        .then(r=>r.json())
        .then(res=>{
            if (res.success) {
                alert('✅ ' + res.message);
                location.reload();
            } else {
                alert('❌ ' + (res.message || 'Gagal menghapus'));
            }
        })
        .catch(()=>alert('❌ Terjadi kesalahan saat menghapus'));
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
            filtered = filtered.filter(item => item.status === '⏳ Menunggu Sertifikat');
        } else if (statusFilter === '✅ Terbit') {
            filtered = filtered.filter(item => item.status === '✅ Terbit');
        } else if (statusFilter === '❌ Ditolak') {
            filtered = filtered.filter(item => item.status === '❌ Ditolak');
        } else if (statusFilter === '🗑️ Dihapus') {
            filtered = filtered.filter(item => item.status === '🗑️ Dihapus');
        } else if (statusFilter === '🔄 Permintaan Pembaharuan') {
            filtered = filtered.filter(item => item.status.includes('Pembaharuan'));
        } else if (statusFilter === '⛔ Permintaan Penghapusan') {
            filtered = filtered.filter(item => item.status.includes('Penghapusan'));
        }
    }
    
    const tbody = document.getElementById('listSEBody');
    if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Tidak ada data yang cocok</td></tr>';
        document.getElementById('listSEInfo').innerHTML = '👁️ View 0 dari 0';
        return;
    }
    
    let html = '';
    filtered.forEach(item => {
        const badgeClass = item.status === '✅ Terbit' ? 'badge-green' : 
                          item.status === '❌ Ditolak' ? 'badge-red' : 
                          item.status === '🔄 Dalam Pembaharuan' ? 'badge-orange' : 'badge-blue';
        
        html += `<tr>
            <td>
                <div style="display: flex; gap: 5px;">
                    <button class="icon-btn" onclick="lihatSertifikat(${item.id})" title="Lihat Tanda Daftar PSE" style="background-color: #3b82f6; color: white;"><i class="fas fa-certificate"></i></button>
                    <button class="icon-btn icon-btn-danger" onclick="hapusSETerdaftar(${item.id})" title="Hapus">🗑️</button>
                </div>
            </td>
            <td>${item.instansi || '-'} / ${item.unitKerja || '-'}</td>
            <td>${item.namaSE || '-'} / ${item.pejabat || '-'}</td>
            <td><span class="badge ${badgeClass}">${item.status || '✅ Terbit'}</span></td>
            <td>${item.tanggalTerbit || item.tanggal || '-'}</td>
            <td>${item.noTandaDaftar || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
    document.getElementById('listSEInfo').innerHTML = `👁️ View 1 - ${filtered.length} dari ${filtered.length}`;
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
        if (statusFilter === '⏳ Menunggu Verifikasi') {
            filtered = filtered.filter(item => item.status === 'Menunggu Verifikasi');
        } else if (statusFilter === '✅ Diterima') {
            filtered = filtered.filter(item => item.status === '✅ Diterima');
        } else if (statusFilter === '❌ Ditolak') {
            filtered = filtered.filter(item => item.status === '❌ Ditolak');
        } else if (statusFilter === '🗑️ Dihapus') {
            filtered = filtered.filter(item => item.status === '🗑️ Dihapus');
        } else if (statusFilter === '🔄 Pembaharuan') {
            filtered = filtered.filter(item => item.status.includes('Pembaharuan'));
        } else if (statusFilter === '⛔ Penghapusan') {
            filtered = filtered.filter(item => item.status.includes('Penghapusan'));
        }
    }
    
    const tbody = document.getElementById('riwayatBody');
    if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Tidak ada data yang cocok</td></tr>';
        document.getElementById('riwayatInfo').innerHTML = '👁️ View 0 dari 0';
        return;
    }
    
    let html = '';
    filtered.forEach(item => {
        const badgeClass = item.status === '✅ Diterima' ? 'badge-green' : 
                          item.status === '❌ Ditolak' ? 'badge-red' : 'badge-orange';
        
        let jenisPengajuan = '📝 Pendaftaran';
        if (item.jenis === 'Pembaharuan' || item.status.includes('Pembaharuan')) {
            jenisPengajuan = '🔄 Pembaharuan';
        } else if (item.jenis === 'Penghapusan' || item.status.includes('Penghapusan')) {
            jenisPengajuan = '⛔ Penghapusan';
        }
        
        html += `<tr>
            <td>
                <div style="display: flex; gap: 5px;">
                    <button class="icon-btn" onclick="detailPengajuan(${item.id})">📄</button>
                    <button class="icon-btn icon-btn-success" onclick="approvePengajuan(${item.id})">✅</button>
                    <button class="icon-btn icon-btn-danger" onclick="tolakPengajuan(${item.id})">❌</button>
                    <button class="icon-btn icon-btn-warning" onclick="mintaPembaharuan(${item.id})">🔄</button>
                    <button class="icon-btn icon-btn-danger" onclick="mintaPenghapusan(${item.id})">⛔</button>
                    <button class="icon-btn icon-btn-secondary" onclick="hapusPengajuan(${item.id})">🗑️</button>
                </div>
            </td>
            <td><span class="badge ${badgeClass}">${jenisPengajuan}</span></td>
            <td><span class="badge ${badgeClass}">${item.statusText || item.status}</span></td>
            <td>${item.namaSE || '-'}</td>
            <td>${item.tanggalPengajuan || item.tanggal || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
    document.getElementById('riwayatInfo').innerHTML = `👁️ View 1 - ${filtered.length} dari ${filtered.length}`;
}

// ============================================
// FUNGSI PUBLIC
// ============================================
function cariPublicPSE() {
    const keyword = document.getElementById('cariPublicInput').value.toLowerCase();
    
    if (!keyword) {
        alert('🔍 Masukkan kata kunci pencarian');
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
        
        alert('✅ Profil berhasil diupdate!');
    } else {
        alert('❌ Silakan login terlebih dahulu!');
    }
}

// ============================================
// FUNGSI LAPORAN
// ============================================
function downloadLaporan(jenis) {
    if (jenis === 'bulanan') {
        const bulan = document.getElementById('laporanBulan').value;
        alert(`📥 Download laporan bulanan: ${bulan} (PDF)`);
    } else if (jenis === 'tahunan') {
        const tahun = document.getElementById('laporanTahun').value;
        alert(`📥 Download laporan tahunan: ${tahun} (Excel)`);
    }
}

// ============================================
// FUNGSI PENGATURAN
// ============================================
function updatePassword() {
    if (!currentUser) {
        alert('❌ Silakan login terlebih dahulu!');
        return;
    }
    
    const currentPassword = document.getElementById('currentPassword').value;
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (!currentPassword || !newPassword || !confirmPassword) {
        alert('❌ Lengkapi semua field password');
        return;
    }
    
    if (currentUser.password && currentUser.password !== currentPassword) {
        const isDemoAccount = demoAccounts.some(acc => acc.username === currentUser.username);
        if (isDemoAccount) {
            if (!confirm('⚠️ Ini adalah akun demo. Password tidak akan benar-benar berubah. Lanjutkan simulasi?')) {
                return;
            }
        } else {
            alert('❌ Password saat ini salah');
            return;
        }
    }
    
    if (!validatePassword(newPassword)) {
        alert('❌ Password baru harus 8-16 karakter dan mengandung huruf dan angka');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        alert('❌ Konfirmasi password tidak cocok');
        return;
    }
    
    if (currentUser.password) {
        currentUser.password = newPassword;
        localStorage.setItem('pseUser_' + currentUser.username, JSON.stringify(currentUser));
        alert('✅ Password berhasil diubah!');
    } else {
        alert('✅ (Demo) Password berhasil diubah!');
    }
    
    document.getElementById('currentPassword').value = '';
    document.getElementById('newPassword').value = '';
    document.getElementById('confirmPassword').value = '';
}

function saveNotificationSettings() {
    const emailNotif = document.getElementById('emailNotif').checked;
    const smsNotif = document.getElementById('smsNotif').checked;
    
    alert(`✅ Pengaturan notifikasi disimpan!\n📧 Email: ${emailNotif ? 'Aktif' : 'Nonaktif'}\n📱 SMS: ${smsNotif ? 'Aktif' : 'Nonaktif'}`);
}

function saveDisplaySettings() {
    const theme = document.getElementById('themeMode').value;
    const fontSize = document.getElementById('fontSize').value;
    
    alert(`✅ Pengaturan tampilan disimpan!\n🎨 Tema: ${theme}\n📏 Ukuran Font: ${fontSize}`);
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
    
    // Auto-check semua kewajiban jika checkbox terakhir dicentang (tetap bisa diubah manual)
    const seC1 = document.getElementById('kewajiban1');
    const seC2 = document.getElementById('kewajiban2');
    const seC3 = document.getElementById('kewajiban3');
    const seC4 = document.getElementById('kewajiban4');
    if (seC4) {
        seC4.addEventListener('change', function() {
            if (seC4.checked) {
                if (seC1) seC1.checked = true;
                if (seC2) seC2.checked = true;
                if (seC3) seC3.checked = true;
            }
        });
    }
    
    const edC1 = document.getElementById('edit_riwayat_kewajiban1');
    const edC2 = document.getElementById('edit_riwayat_kewajiban2');
    const edC3 = document.getElementById('edit_riwayat_kewajiban3');
    const edC4 = document.getElementById('edit_riwayat_kewajiban4');
    if (edC4) {
        edC4.addEventListener('change', function() {
            if (edC4.checked) {
                if (edC1) edC1.checked = true;
                if (edC2) edC2.checked = true;
                if (edC3) edC3.checked = true;
            }
        });
    }
    
    const formEditRiwayat = document.getElementById('formEditRiwayat');
    if (formEditRiwayat) {
        formEditRiwayat.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!currentUser) {
                alert('❌ Silakan login terlebih dahulu!');
                return;
            }
            
            const checkboxes = document.querySelectorAll('#page-edit-riwayat input[type="checkbox"]:checked');
            if (checkboxes.length !== 4) {
                alert('❌ Harap centang SEMUA (4) pernyataan kepatuhan!');
                return;
            }
            
            const namaSE = document.getElementById('edit_riwayat_nama').value;
            if (!namaSE) {
                alert('❌ Nama Sistem Elektronik harus diisi!');
                return;
            }
            
            alert('✅ Perubahan berhasil dikirim! Data akan diperbarui setelah diverifikasi.');
            
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
                alert('❌ Anda sudah login. Silakan logout terlebih dahulu untuk mengakses halaman public.');
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
    if (formActions && !formActions.querySelector('.btn-se-draft')) {
        const loadBtn = document.createElement('button');
        loadBtn.type = 'button';
        loadBtn.className = 'btn-se-draft';
        loadBtn.onclick = saveDraft;
        loadBtn.innerHTML = '<i class="fas fa-save"></i> Simpan Draft';
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
    console.log('✅ Portal PSE - PHP Mode Active');
};
</script>

<!-- PHP Data Injection -->
<script>
<?php if($is_logged_in): ?>
    // Inject PHP data into JS variables for charts and details
    // PENTING: Gunakan json_encode agar tipe data terjaga (null tetap null, angka tetap angka)
    const rawUserData = <?php echo json_encode($user_data); ?>;
    console.log("Debug User Data from DB:", rawUserData);

    currentUser = {
        username: rawUserData ? rawUserData.username : "",
        fullname: rawUserData ? rawUserData.fullname : "",
        role: rawUserData ? rawUserData.role : "",
        nip: rawUserData ? rawUserData.nip : "",
        jabatan: rawUserData ? rawUserData.jabatan : "",
        instansi: rawUserData ? rawUserData.instansi : "",
        email: rawUserData ? rawUserData.email : "",
        no_hp: rawUserData ? rawUserData.no_hp : ""
    };

    // FUNGSI LOAD PROFILE DATA (ADDED & IMPROVED)
    function loadProfileData() {
        if (!currentUser) return;
        console.log('Loading profile data:', currentUser);

        // Helper function to safe set text
        const setText = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.innerText = val && val !== '' ? val : '-';
        };

        // Helper function to safe set value
        const setValue = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.value = val && val !== '' ? val : '';
        };

        // Update Tampilan Profil Kiri
        const initials = currentUser.fullname ? currentUser.fullname.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase() : '-';
        if (document.getElementById('profilAvatar')) document.getElementById('profilAvatar').innerText = initials;
        
        setText('profilNama', currentUser.fullname);
        
        // Role logic
        let roleDisplay = 'User Terdaftar';
        if (currentUser.role === 'admin') roleDisplay = 'Admin';
        else if (currentUser.role === 'super_admin') roleDisplay = 'Super Admin';
        setText('profilRole', roleDisplay);
        
        setText('profilNIPDisplay', currentUser.nip);
        setText('profilInstansiDisplay', currentUser.instansi);
        setText('profilJabatanDisplay', currentUser.jabatan);

        // Update Form Detail Kanan (Read Only)
        setValue('profil_nama', currentUser.fullname);
        setValue('profil_nip', currentUser.nip);
        setValue('profil_jabatan', currentUser.jabatan);
        setValue('profil_telp', currentUser.no_hp);
        setValue('profil_email', currentUser.email);
    }

    // Call loadProfileData immediately when script loads
    loadProfileData();
    
    // Override dengan data profil pejabat dari admin jika tersedia
    function fetchPejabatProfile() {
        fetch('pejabat_get_for_user.php')
            .then(r => r.json())
            .then(res => {
                if (res && res.success && res.data) {
                    const p = res.data;
                    const setText = (id, val) => { const el = document.getElementById(id); if (el) el.innerText = val && val !== '' ? val : '-'; };
                    const setValue = (id, val) => { const el = document.getElementById(id); if (el) el.value = val && val !== '' ? val : ''; };
                    setText('profilNama', p.fullname);
                    if (document.getElementById('profilAvatar')) document.getElementById('profilAvatar').innerText = (p.fullname||'-').charAt(0).toUpperCase();
                    setText('profilNIPDisplay', p.nip);
                    setText('profilInstansiDisplay', p.instansi);
                    setText('profilJabatanDisplay', p.jabatan);
                    setValue('profil_nama', p.fullname);
                    setValue('profil_nip', p.nip);
                    setValue('profil_jabatan', p.jabatan);
                    setValue('profil_telp', p.no_hp);
                    setValue('profil_email', p.email);
                }
            })
            .catch(() => {});
    }
    fetchPejabatProfile();
    
    // Also call it when DOM is fully ready to be safe
    document.addEventListener('DOMContentLoaded', function() {
        loadProfileData();
    });

    // Populate databasePengajuan from PHP
    databasePengajuan = <?php 
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
        // Ambil data yang sudah Terbit atau Diterima
        $q = mysqli_query($koneksi, "SELECT * FROM layanan_se WHERE user_id='$uid' AND (status='Diterima' OR status='Terbit')");
        while($r = mysqli_fetch_assoc($q)) {
            $r['namaSE'] = $r['nama_se'];
            // Pastikan tanggal terbit ada, jika tidak pakai tanggal pengajuan
            $r['tanggalTerbit'] = !empty($r['tanggal_terbit']) ? date('d F Y', strtotime($r['tanggal_terbit'])) : date('d F Y', strtotime($r['tanggal_pengajuan']));
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

<!-- MODAL DETAIL PENGAJUAN (NEW) -->
<div id="modalDetailPengajuan" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-file-contract" style="color: #3b82f6;"></i> Detail Pengajuan</h3>
            <button onclick="closeModalDetail()" class="close-modal">&times;</button>
        </div>
        <div class="modal-body" id="modalDetailBody">
            <!-- Konten detail akan diisi via JS -->
            <div style="text-align: center; padding: 2rem;">
                <i class="fas fa-spinner fa-spin fa-2x" style="color: #3b82f6;"></i>
                <p style="margin-top: 1rem; color: #64748b;">Memuat data...</p>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeModalDetail()" class="btn-close-modal">Tutup</button>
        </div>
    </div>
</div>

<style>
/* CSS Modal Detail */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    backdrop-filter: blur(4px);
    animation: fadeIn 0.2s ease-out;
}

.modal-content {
    background: white;
    width: 90%;
    max-width: 650px;
    border-radius: 16px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    animation: scaleIn 0.2s ease-out;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.modal-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8fafc;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #94a3b8;
    transition: 0.2s;
    line-height: 1;
}

.close-modal:hover { color: #ef4444; }

.modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    background: #ffffff;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
    background: #f8fafc;
}

.btn-close-modal {
    padding: 0.6rem 1.5rem;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.9rem;
    transition: 0.2s;
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
}

.btn-close-modal:hover { background: #2563eb; transform: translateY(-1px); }

.detail-grid {
    display: grid;
    gap: 1rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px dashed #f1f5f9;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
}

.detail-value {
    font-size: 0.95rem;
    color: #334155;
    font-weight: 500;
    line-height: 1.5;
}

@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes scaleIn { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
</style>

<script>
function closeModalDetail() {
    document.getElementById('modalDetailPengajuan').style.display = 'none';
    document.body.style.overflow = ''; // Restore scroll
}

// Tutup modal jika klik di luar konten
document.getElementById('modalDetailPengajuan').addEventListener('click', function(e) {
    if (e.target === this) closeModalDetail();
});
</script>

</body>
</html>
