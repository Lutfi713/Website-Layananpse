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
    height: fit-content;
    position: sticky;
    top: 2rem;
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

.role-badge {
    color: white;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    margin-left: 10px;
    text-transform: uppercase;
}

.role-badge-super-admin {
    background: #ef4444;
}

.role-badge-admin-opd {
    background: #f59e0b;
}

.role-badge-opd {
    background: #10b981;
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

<!-- CONTENT WRAPPER UTAMA -->
<div class="app-wrapper" id="appWrapper" style="display: none;">
    <!-- SIDEBAR - SEMUA MENU DARI CODING KEDUA -->
    <aside class="sidebar" id="sidebar">
        <h3>
            <i class="fas fa-shield-alt"></i> Menu PSE
        </h3>
        <ul>
            <li data-target="page-dashboard" class="active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </li>
            <li data-target="page-pendaftaran">
                <i class="fas fa-file-signature"></i> Pendaftaran SE
            </li>
            <li data-target="page-list">
                <i class="fas fa-list"></i> List SE Terdaftar
            </li>
            <li data-target="page-riwayat">
                <i class="fas fa-history"></i> Riwayat Pengajuan
            </li>
            <li data-target="page-profil">
                <i class="fas fa-user-tie"></i> Profil Pejabat
            </li>
            <li data-target="page-riwayat-pejabat">
                <i class="fas fa-clock"></i> Riwayat Pengajuan Pejabat
            </li>
            <li data-target="page-panduan-pengguna">
                <i class="fas fa-book-open"></i> Panduan Pengguna
            </li>
            <li data-target="page-laporan">
                <i class="fas fa-chart-pie"></i> Laporan
            </li>
            <li data-target="page-setting">
                <i class="fas fa-cog"></i> Pengaturan
            </li>
            <!-- TAMBAHAN MENU EDIT RIWAYAT -->
            <li data-target="page-edit-riwayat">
                <i class="fas fa-edit"></i> Edit Pengajuan
            </li>
            <!-- MENU UNTUK MELIHAT SEMUA DATA (ADMIN OPD & SUPER ADMIN) -->
            <li data-target="page-all-data" class="admin-opd-only" style="display: none;">
                <i class="fas fa-database"></i> Semua Data PSE
            </li>
            <!-- MENU KHUSUS SUPER ADMIN -->
            <li data-target="page-admin-users" class="super-admin-only" style="display: none;">
                <i class="fas fa-users-cog"></i> Kelola Pengguna
            </li>
        </ul>
    </aside>

    <!-- MAIN CONTENT - SEMUA HALAMAN DASHBOARD -->
    <main class="main-content">
        <!-- DASHBOARD -->
        <div id="page-dashboard" class="dashboard-content active">
            <div class="dashboard-header">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                <div class="user-badge" id="dashboardUser">
                    <i class="fas fa-user-circle"></i> <span id="dashboardUserName">-</span>
                    <span id="dashboardRole" class="role-badge"></span>
                </div>
            </div>
            
            <div class="stats-cards">
                <div class="stat-card-dash">
                    <h3 id="statPengajuan">0</h3>
                    <p>Pengajuan</p>
                </div>
                <div class="stat-card-dash">
                    <h3 id="statTerdaftar">0</h3>
                    <p>Terdaftar</p>
                </div>
                <div class="stat-card-dash">
                    <h3 id="statDitolak">0</h3>
                    <p>Ditolak</p>
                </div>
                <div class="stat-card-dash">
                    <h3 id="statDihapus">0</h3>
                    <p>Dihapus</p>
                </div>
                <div class="stat-card-dash">
                    <h3 id="statPembaharuan">0</h3>
                    <p>Permintaan Pembaharuan</p>
                </div>
                <div class="stat-card-dash">
                    <h3 id="statPenghapusan">0</h3>
                    <p>Permintaan Penghapusan</p>
                </div>
            </div>
            
            <!-- GRAFIK STATISTIK -->
            <div class="card" style="background: white; color: #1e293b; padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
                <h3 style="color: #1e40af; margin-bottom: 1rem;"><i class="fas fa-chart-bar"></i> Statistik Pengajuan per Bulan</h3>
                <canvas id="dashboardChart" height="200"></canvas>
            </div>
            
            <!-- TABEL RINGKASAN PENGAJUAN TERBARU -->
            <div class="card" style="background: white; color: #1e293b; padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
                <h3 style="color: #1e40af; margin-bottom: 1rem;"><i class="fas fa-file-alt"></i> Ringkasan Pengajuan Terbaru</h3>
                <div class="table-container">
                    <table class="table" id="ringkasanPengajuanTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama SE</th>
                                <th>Instansi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="ringkasanPengajuanBody">
                            <tr>
                                <td colspan="4" style="text-align: center;">Belum ada pengajuan</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- TABEL RINGKASAN SE TERDAFTAR TERBARU -->
            <div class="card" style="background: white; color: #1e293b; padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem;">
                <h3 style="color: #1e40af; margin-bottom: 1rem;"><i class="fas fa-list"></i> SE Terdaftar Terbaru</h3>
                <div class="table-container">
                    <table class="table" id="ringkasanSETable">
                        <thead>
                            <tr>
                                <th>Tanggal Terbit</th>
                                <th>Nama SE</th>
                                <th>Instansi</th>
                                <th>No. Tanda Daftar</th>
                            </tr>
                        </thead>
                        <tbody id="ringkasanSEBody">
                            <tr>
                                <td colspan="4" style="text-align: center;">Belum ada SE terdaftar</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- AKTIVITAS TERBARU -->
            <div class="card" style="background: white; color: #1e293b; padding: 1.5rem; border-radius: 16px;">
                <h3 style="color: #1e40af; margin-bottom: 1rem;"><i class="fas fa-clock"></i> Aktivitas Terbaru</h3>
                <div class="table-container">
                    <table class="table" id="aktivitasTerbaruTable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Aktivitas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="aktivitasTerbaruBody">
                            <tr>
                                <td colspan="3" style="text-align: center;">Belum ada aktivitas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PENDAFTARAN SE - FORM DENGAN TOMOL SESUAI GAMBAR -->
        <div id="page-pendaftaran" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-file-signature"></i> Pendaftaran Sistem Elektronik</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="pendaftaranUserName">-</span>
                    <span id="pendaftaranRole" class="role-badge"></span>
                </div>
            </div>
            
            <div class="se-form-section">
                <form id="formPendaftaranSE">
                    <div class="se-form-grid">
                        <!-- KOLOM KIRI -->
                        <div>
                            <div class="se-form-group">
                                <label>Instansi</label>
                                <input type="text" id="se_instansi" value="" placeholder="Pemerintah Kota Probolinggo">
                            </div>
                            <div class="se-form-group">
                                <label>Unit Kerja pemilik Sistem Elektronik</label>
                                <!-- DROPDOWN UNIT KERJA DENGAN 41 DAFTAR OPD/BAGIAN/KECAMATAN -->
                                <select id="se_unitkerja">
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
                                <input type="text" id="se_nama" placeholder="Contoh: Sistem Informasi Pelayanan Publik">
                            </div>
                            <div class="se-form-group">
                                <label>Versi Sistem Elektronik</label>
                                <input type="text" id="se_versi" placeholder="Contoh: 2.5.1">
                            </div>
                            <div class="se-form-group">
                                <label>Bidang/Sektor Sistem Elektronik</label>
                                <!-- DROPDOWN BIDANG SEKTOR DENGAN 3 PILIHAN BARU -->
                                <select id="se_bidang">
                                    <option value="">--Pilih Bidang/Sektor--</option>
                                    <option>Layanan Pemerintahan</option>
                                    <option>Layanan Pusat</option>
                                    <option>Layanan Institusi</option>
                                </select>
                            </div>
                            <div class="se-form-group">
                                <label>Narahubung Sistem Elektronik</label>
                                <input type="text" id="se_narahubung" placeholder="Contoh: Budi Santoso">
                            </div>
                            <div class="se-form-group">
                                <label>No. Tipe /HP: Narahubung</label>
                                <input type="text" id="se_telepon" placeholder="Contoh: 08123456789">
                            </div>
                        </div>
                        
                        <!-- KOLOM KANAN -->
                        <div>
                            <div class="se-form-group">
                                <label>Uniform Resource Locator (URL): Situ Web</label>
                                <input type="text" id="se_url" placeholder="Contoh: https://layanan.gold">
                            </div>
                            <div class="se-form-group">
                                <label>Sistem Nama Domain (DNS)/Alamat Internet IP Server</label>
                                <input type="text" id="se_dns" placeholder="Contoh: 192.168.1.100 atau layanan gold">
                            </div>
                            <div class="se-form-group">
                                <label>Deskripsi Singkat Fungsi dan Proses Bisnis Sistem Elektronik</label>
                                <textarea id="se_deskripsi" placeholder="Contoh: Sistem ini digunakan untuk mengelola layanan publik secara elektronik, meliputi pendaftaran, verifikasi, dan pelaporan." rows="4"></textarea>
                            </div>
                            
                            <!-- Kategori Sistem Elektronik Berdasarkan Asas Risiko -->
                            <div class="se-form-group">
                                <label>Kategori Sistem Elektronik Berdasarkan Asas Risiko</label>
                                <div style="margin-bottom: 10px;">
                                    <select id="se_risiko" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; background: white;">
                                        <option value="">-- Pilih Kategori Risiko --</option>
                                        <option value="Strategis">🏛️ Strategis</option>
                                        <option value="Tinggi">⚠️ Tinggi</option>
                                        <option value="Rendah">✅ Rendah</option>
                                    </select>
                                </div>
                                
                                <!-- Bagian Upload dengan info file yang bisa diganti -->
                                <div class="upload-group">
                                    <input type="text" id="se_risiko_file" placeholder="Pilih file pendukung..." value="" readonly style="background-color: #f8fafc;">
                                    <input type="file" id="se_risiko_file_input" style="display: none;" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileUpload(this, 'se_risiko_file', 'se_risiko_info')">
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
                                    <select id="se_klasifikasi" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; background: white;">
                                        <option value="">-- Pilih Klasifikasi Data --</option>
                                        <option value="Terbuka">🌐 Terbuka</option>
                                        <option value="Terbatas">🔒 Terbatas</option>
                                        <option value="Tertutup">🔐 Tertutup</option>
                                    </select>
                                </div>
                                
                                <!-- Bagian Upload dengan info file yang bisa diganti -->
                                <div class="upload-group">
                                    <input type="text" id="se_klasifikasi_file" placeholder="Pilih file pendukung..." value="" readonly style="background-color: #f8fafc;">
                                    <input type="file" id="se_klasifikasi_file_input" style="display: none;" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileUpload(this, 'se_klasifikasi_file', 'se_klasifikasi_info')">
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
                                <textarea id="se_data_pribadi" placeholder="Contoh: Data pribadi yang diproses meliputi nama, alamat, nomor telepon, email, dan ..." rows="3" style="resize: vertical; width: 100%;"></textarea>
                                <!-- BAGIAN UPLOAD FILE TELAH DIHAPUS -->
                            </div>
                            
                            <!-- Lokasi Pengelolaan/Pemrosesan/Penyimpanan - HANYA 2 PILIHAN: DALAM NEGERI / LUAR NEGERI -->
                            <div class="se-form-group">
                                <label>Lokasi Pengelolaan/Pemrosesan/Penyimpanan</label>
                                <select id="se_lokasi" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; background: white;">
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
                            <input type="file" id="se_dokumen_input" style="display: none;" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileUpload(this, 'se_dokumen', 'se_dokumen_info')">
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
                    
                    <div class="se-actions">
                        <button type="reset" class="btn-se-reset" onclick="resetFormSE(event)">
                            <i class="fas fa-undo-alt"></i> Reset
                        </button>
                        
                        <!-- BUTTON AJUKAN PENGAJUAN (MUNCUL SETELAH SIMPAN DIKLIK) - AWALNYA DISEMBUNYIKAN -->
                        <button type="button" class="btn-se-ajukan" id="btnAjukanPengajuan" style="display: none;" onclick="ajukanPengajuan()">
                            <i class="fas fa-paper-plane"></i> Ajukan Pengajuan
                        </button>
                        
                        <button type="button" class="btn-se-draft" onclick="saveDraft()">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- LIST SE TERDAFTAR - DENGAN BUTTON DETAIL DAN HAPUS -->
        <div id="page-list" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-list"></i> List SE Terdaftar</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="listUserName">-</span>
                    <span id="listRole" class="role-badge"></span>
                </div>
            </div>
            
            <div class="filter-box">
                <input type="text" id="filterNamaSE" placeholder="🔍 Masukan Nama Sistem Elektronik">
                <input type="text" id="filterInstansi" placeholder="🏢 Masukan Instansi">
                <select id="filterStatus">
                    <option>Semua Status</option>
                    <option>Menunggu Penerbitan Sertifikat</option>
                    <option>✅ Terbit</option>
                    <option>❌ Ditolak</option>
                    <option>🗑️ Dihapus</option>
                    <option>🔄 Permintaan Pembaharuan</option>
                    <option>⛔ Permintaan Penghapusan</option>
                </select>
                <button class="btn-search" onclick="filterListSE()">🔎 Cari</button>
                <button class="btn-add" onclick="showPendaftaranSE()">➕ Tambah SE</button>
            </div>
            
            <div class="table-box">
                <table class="table" id="listSETable">
                    <thead>
                        <tr>
                            <th>📋 Aksi</th>
                            <th>🏢 Nama Instansi / Unit Kerja</th>
                            <th>💻 Sistem Elektronik / Pejabat</th>
                            <th>📊 Status</th>
                            <th>📅 Tanggal</th>
                            <th>🆔 No. Tanda Daftar</th>
                        </tr>
                    </thead>
                    <tbody id="listSEBody">
                        <!-- DATA HANYA AKAN MUNCUL SETELAH ADA PENGAJUAN YANG DISETUJUI -->
                    </tbody>
                </table>
                <div class="table-footer" style="display: none;" id="listSEFooter">
                    <div id="listSEInfo">👁️ View 0 dari 0</div>
                    <div class="pagination" id="listSEPagination">
                        <button onclick="changePage('list', 'first')">First</button>
                        <button onclick="changePage('list', 'prev')">Prev</button>
                        <button class="active" onclick="changePage('list', 1)">1</button>
                        <button onclick="changePage('list', 'next')">Next</button>
                        <button onclick="changePage('list', 'last')">Last</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIWAYAT PENGAJUAN - TANPA BUTTON STATUS -->
        <div id="page-riwayat" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-history"></i> Riwayat Pengajuan SE</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="riwayatUserName">-</span>
                    <span id="riwayatRole" class="role-badge"></span>
                </div>
            </div>
            
            <!-- BUTTON STATUS TELAH DIHAPUS SESUAI PERMINTAAN -->
            
            <div class="filter-box">
                <input type="text" id="filterRiwayatNama" placeholder="🔍 Nama Sistem Elektronik">
                <input type="text" id="filterRiwayatInstansi" placeholder="🏢 Instansi">
                <select id="filterRiwayatStatus">
                    <option>Semua Status</option>
                    <option>⏳ Menunggu Verifikasi</option>
                    <option>✅ Diterima</option>
                    <option>❌ Ditolak</option>
                    <option>🗑️ Dihapus</option>
                    <option>🔄 Pembaharuan</option>
                    <option>⛔ Penghapusan</option>
                </select>
                <button class="btn-search" onclick="filterRiwayat()">🔎 Cari</button>
                <button class="btn-add" onclick="showPendaftaranSE()">➕ Daftar Baru</button>
            </div>
            
            <div class="table-box">
                <table class="table" id="riwayatTable">
                    <thead>
                        <tr>
                            <th>📋 Aksi</th>
                            <th>📄 Jenis Pengajuan</th>
                            <th>📊 Status</th>
                            <th>💻 Nama SE</th>
                            <th>📅 Tanggal Pengajuan</th>
                        </tr>
                    </thead>
                    <tbody id="riwayatBody">
                        <tr>
                            <td colspan="5">
                                <div class="info-box">
                                    <i class="fas fa-history"></i>
                                    <h4>Belum Ada Riwayat Pengajuan</h4>
                                    <p>Anda belum melakukan pengajuan SE. Silakan lakukan pendaftaran terlebih dahulu.</p>
                                    <button class="btn-add" onclick="showPendaftaranSE()">
                                        <i class="fas fa-plus"></i> Daftar SE Sekarang
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-footer" style="display: none;" id="riwayatFooter">
                    <div id="riwayatInfo">👁️ View 0 dari 0</div>
                    <div class="pagination" id="riwayatPagination">
                        <button onclick="changePage('riwayat', 'first')">First</button>
                        <button onclick="changePage('riwayat', 'prev')">Prev</button>
                        <button class="active" onclick="changePage('riwayat', 1)">1</button>
                        <button onclick="changePage('riwayat', 'next')">Next</button>
                        <button onclick="changePage('riwayat', 'last')">Last</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- PROFIL PEJABAT -->
        <div id="page-profil" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-user-tie"></i> Profil Pejabat</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="profilUserName">-</span>
                    <span id="profilRole" class="role-badge"></span>
                </div>
            </div>
            
            <div class="profil-card">
                <div class="profil-avatar" id="profilAvatar">-</div>
                <div class="profil-info">
                    <h3 id="profilNama">-</h3>
                    <p><i class="fas fa-id-card"></i> NIP: -</p>
                    <p><i class="fas fa-briefcase"></i> Jabatan: -</p>
                    <p><i class="fas fa-building"></i> Instansi: -</p>
                    <p><i class="fas fa-envelope"></i> Email: -</p>
                    <p><i class="fas fa-phone"></i> Telepon: -</p>
                </div>
            </div>
            
            <form>
                <div class="se-form-grid" style="background: white; padding: 1.5rem; border-radius: 16px;">
                    <div>
                        <div class="se-form-group">
                            <label>👤 Nama Lengkap</label>
                            <input type="text" id="profil_nama" value="">
                        </div>
                        <div class="se-form-group">
                            <label>🆔 NIP/NIK</label>
                            <input type="text" id="profil_nip" value="" maxlength="18" oninput="validateNIP(this)" onkeypress="return hanyaAngka(event)">
                            <!-- TIDAK ADA LAGI PESAN ERROR -->
                        </div>
                        <div class="se-form-group">
                            <label>💼 Jabatan</label>
                            <input type="text" id="profil_jabatan" value="">
                        </div>
                    </div>
                    <div>
                        <div class="se-form-group">
                            <label>📍 Alamat Kantor</label>
                            <textarea id="profil_alamat"></textarea>
                        </div>
                        <div class="se-form-group">
                            <label>📧 Email Resmi</label>
                            <input type="email" id="profil_email" value="" oninput="validateEmail(this)">
                            <!-- TIDAK ADA LAGI PESAN ERROR -->
                        </div>
                        <div class="se-form-group">
                            <label>📞 No. Telepon</label>
                            <input type="text" id="profil_telp" value="">
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;">
                    <button class="btn-se-success" onclick="updateProfile(); return false;">
                        <i class="fas fa-save"></i> Update Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- RIWAYAT PENGAJUAN PEJABAT -->
        <div id="page-riwayat-pejabat" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-clock"></i> Riwayat Pengajuan Pejabat</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="riwayatPejabatUserName">-</span>
                    <span id="riwayatPejabatRole" class="role-badge"></span>
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
                    <span id="panduanRole" class="role-badge"></span>
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
            
            <!-- CARD JUKNIS DAN FORMAT - DIPERJELAS TULISANNYA -->
            <div class="panduan-card">
                <h3>
                    <i class="fas fa-file-pdf" style="color: #ef4444;"></i> 
                    Juknis & Format Dokumen PSE
                </h3>
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                    <!-- Dokumen Panduan -->
                    <div style="background: #f8fafc; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0;">
                        <h4 style="color: #1e40af; margin-bottom: 1.2rem; font-size: 1.2rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-file-alt" style="color: #3b82f6; font-size: 1.3rem;"></i> 
                            <span style="border-bottom: 2px solid #3b82f6; padding-bottom: 3px;">Dokumen Panduan</span>
                        </h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding: 0.8rem; background: white; border-radius: 8px; transition: all 0.3s; border-left: 4px solid #ef4444; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <i class="fas fa-file-pdf" style="color: #ef4444; font-size: 1.3rem;"></i>
                                <span style="flex: 1; font-weight: 600; color: #0f172a; font-size: 0.95rem;">JUKNIS PSE LINGKUP PUBLIK</span>
                                <i class="fas fa-download" style="color: #3b82f6; cursor: pointer; font-size: 1.1rem;" onclick="alert('📥 Download JUKNIS PSE LINGKUP PUBLIK')"></i>
                            </li>
                            <li style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding: 0.8rem; background: white; border-radius: 8px; transition: all 0.3s; border-left: 4px solid #ef4444; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <i class="fas fa-file-pdf" style="color: #ef4444; font-size: 1.3rem;"></i>
                                <span style="flex: 1; font-weight: 600; color: #0f172a; font-size: 0.95rem;">JUKNIS KLASIFIKASI DATA SE</span>
                                <i class="fas fa-download" style="color: #3b82f6; cursor: pointer; font-size: 1.1rem;" onclick="alert('📥 Download JUKNIS KLASIFIKASI DATA SE')"></i>
                            </li>
                            <li style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding: 0.8rem; background: white; border-radius: 8px; transition: all 0.3s; border-left: 4px solid #ef4444; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <i class="fas fa-file-pdf" style="color: #ef4444; font-size: 1.3rem;"></i>
                                <span style="flex: 1; font-weight: 600; color: #0f172a; font-size: 0.95rem;">FORMAT KATEGORI SISTEM ELEKTRONIK</span>
                                <i class="fas fa-download" style="color: #3b82f6; cursor: pointer; font-size: 1.1rem;" onclick="alert('📥 Download FORMAT KATEGORI SISTEM ELEKTRONIK')"></i>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Format Surat & SOP -->
                    <div style="background: #f8fafc; border-radius: 16px; padding: 1.5rem; border: 1px solid #e2e8f0;">
                        <h4 style="color: #1e40af; margin-bottom: 1.2rem; font-size: 1.2rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-file-signature" style="color: #3b82f6; font-size: 1.3rem;"></i>
                            <span style="border-bottom: 2px solid #3b82f6; padding-bottom: 3px;">Format Surat & SOP</span>
                        </h4>
                        <ul style="list-style: none; padding: 0;">
                            <li style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding: 0.8rem; background: white; border-radius: 8px; transition: all 0.3s; border-left: 4px solid #10b981; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <i class="fas fa-file-word" style="color: #2b5797; font-size: 1.3rem;"></i>
                                <div style="flex: 1;">
                                    <span style="font-weight: 600; color: #0f172a; font-size: 0.95rem; display: block;">SOP Pendaftaran PSE Lingkup Publik</span>
                                    <span style="font-size: 0.8rem; color: #64748b; font-style: italic;">Ungkap Publik</span>
                                </div>
                                <i class="fas fa-download" style="color: #3b82f6; cursor: pointer; font-size: 1.1rem;" onclick="alert('📥 Download SOP Pendaftaran PSE')"></i>
                            </li>
                            <li style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding: 0.8rem; background: white; border-radius: 8px; transition: all 0.3s; border-left: 4px solid #10b981; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <i class="fas fa-file-word" style="color: #2b5797; font-size: 1.3rem;"></i>
                                <span style="flex: 1; font-weight: 600; color: #0f172a; font-size: 0.95rem;">Format Surat Tugas Pejabat Pendaftar</span>
                                <i class="fas fa-download" style="color: #3b82f6; cursor: pointer; font-size: 1.1rem;" onclick="alert('📥 Download Format Surat Tugas')"></i>
                            </li>
                            <li style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; padding: 0.8rem; background: white; border-radius: 8px; transition: all 0.3s; border-left: 4px solid #10b981; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                <i class="fas fa-file-word" style="color: #2b5797; font-size: 1.3rem;"></i>
                                <span style="flex: 1; font-weight: 600; color: #0f172a; font-size: 0.95rem;">Format Surat Permohonan Pemutusan Akses</span>
                                <i class="fas fa-download" style="color: #3b82f6; cursor: pointer; font-size: 1.1rem;" onclick="alert('📥 Download Format Surat Pemutusan Akses')"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
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
            
            <!-- CARD 3: VIDEO TUTORIAL (TETAP) -->
            <div class="panduan-card">
                <h3>
                    <i class="fas fa-video" style="color: #ef4444;"></i>
                    Video Tutorial
                </h3>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                    <div style="background: linear-gradient(145deg, #ffffff, #f8fafc); border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                        <div style="background: linear-gradient(135deg, #1e293b, #0f172a); padding: 2rem 1rem; text-align: center; position: relative;">
                            <i class="fas fa-play-circle" style="font-size: 3.5rem; color: #3b82f6; opacity: 0.9;"></i>
                            <div style="position: absolute; top: 10px; right: 10px; background: rgba(239, 68, 68, 0.9); color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">5:24</div>
                        </div>
                        <div style="padding: 1.5rem 1.2rem;">
                            <h4 style="color: #0f172a; font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem;">🎬 Cara Mendaftar PSE</h4>
                            <p style="color: #64748b; font-size: 0.8rem; margin-bottom: 1rem;">Langkah lengkap pengisian formulir pendaftaran</p>
                            <button onclick="alert('🎬 Memutar video tutorial: Cara Mendaftar PSE')" style="width: 100%; padding: 0.7rem; background: #3b82f6; border: none; border-radius: 8px; color: white; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; transition: all 0.3s;">
                                <i class="fas fa-play"></i> Putar Video
                            </button>
                        </div>
                    </div>
                    
                    <div style="background: linear-gradient(145deg, #ffffff, #f8fafc); border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                        <div style="background: linear-gradient(135deg, #1e293b, #0f172a); padding: 2rem 1rem; text-align: center; position: relative;">
                            <i class="fas fa-file-upload" style="font-size: 3.5rem; color: #10b981; opacity: 0.9;"></i>
                            <div style="position: absolute; top: 10px; right: 10px; background: rgba(239, 68, 68, 0.9); color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">3:12</div>
                        </div>
                        <div style="padding: 1.5rem 1.2rem;">
                            <h4 style="color: #0f172a; font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem;">📎 Upload Dokumen</h4>
                            <p style="color: #64748b; font-size: 0.8rem; margin-bottom: 1rem;">Cara mengupload dokumen persyaratan</p>
                            <button onclick="alert('🎬 Memutar video tutorial: Upload Dokumen')" style="width: 100%; padding: 0.7rem; background: #3b82f6; border: none; border-radius: 8px; color: white; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; transition: all 0.3s;">
                                <i class="fas fa-play"></i> Putar Video
                            </button>
                        </div>
                    </div>
                    
                    <div style="background: linear-gradient(145deg, #ffffff, #f8fafc); border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                        <div style="background: linear-gradient(135deg, #1e293b, #0f172a); padding: 2rem 1rem; text-align: center; position: relative;">
                            <i class="fas fa-download" style="font-size: 3.5rem; color: #f59e0b; opacity: 0.9;"></i>
                            <div style="position: absolute; top: 10px; right: 10px; background: rgba(239, 68, 68, 0.9); color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">2:45</div>
                        </div>
                        <div style="padding: 1.5rem 1.2rem;">
                            <h4 style="color: #0f172a; font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem;">⬇️ Unduh TDPSE</h4>
                            <p style="color: #64748b; font-size: 0.8rem; margin-bottom: 1rem;">Cara mengunduh sertifikat TDPSE</p>
                            <button onclick="alert('🎬 Memutar video tutorial: Unduh TDPSE')" style="width: 100%; padding: 0.7rem; background: #3b82f6; border: none; border-radius: 8px; color: white; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; transition: all 0.3s;">
                                <i class="fas fa-play"></i> Putar Video
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- LINK BANTUAN -->
                <div style="margin-top: 2rem; padding: 1.2rem; background: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-headset" style="color: #3b82f6; font-size: 1.5rem;"></i>
                        <div>
                            <p style="color: #0f172a; font-size: 0.95rem; font-weight: 600; margin: 0;">Butuh bantuan lebih lanjut?</p>
                            <p style="color: #475569; font-size: 0.85rem; margin: 0;">Hubungi Helpdesk PSE di (0335) 421234 atau pse@probolinggokota.go.id</p>
                        </div>
                    </div>
                    <a href="#" onclick="showPendaftaranSE(); return false;" style="background: linear-gradient(135deg, #3b82f6, #1e40af); color: white; padding: 10px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                        <i class="fas fa-file-signature"></i> Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>

        <!-- LAPORAN -->
        <div id="page-laporan" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-chart-pie"></i> Laporan</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="laporanUserName">-</span>
                    <span id="laporanRole" class="role-badge"></span>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <div style="background: white; padding: 1.8rem; border-radius: 16px;">
                    <h3 style="color: #1e40af; margin-bottom: 1rem;">📊 Laporan Bulanan</h3>
                    <div class="se-form-group">
                        <label>Pilih Bulan</label>
                        <select id="laporanBulan" style="width: 100%;">
                            <option>Februari 2026</option>
                            <option>Januari 2026</option>
                            <option>Desember 2025</option>
                        </select>
                    </div>
                    <button class="btn-se-success" style="width: 100%; margin-top: 1rem;" onclick="downloadLaporan('bulanan')">
                        <i class="fas fa-download"></i> Download PDF
                    </button>
                </div>
                
                <div style="background: white; padding: 1.8rem; border-radius: 16px;">
                    <h3 style="color: #1e40af; margin-bottom: 1rem;">📋 Laporan Tahunan</h3>
                    <div class="se-form-group">
                        <label>Pilih Tahun</label>
                        <select id="laporanTahun" style="width: 100%;">
                            <option>2026</option>
                            <option>2025</option>
                            <option>2024</option>
                        </select>
                    </div>
                    <button class="btn-se-success" style="width: 100%; margin-top: 1rem;" onclick="downloadLaporan('tahunan')">
                        <i class="fas fa-file-excel"></i> Download Excel
                    </button>
                </div>
                
                <div style="background: white; padding: 1.8rem; border-radius: 16px;">
                    <h3 style="color: #1e40af; margin-bottom: 1rem;">📈 Statistik Kepatuhan</h3>
                    <div style="text-align: center;">
                        <h2 style="font-size: 2.5rem; color: #10b981; margin: 1rem 0;">98%</h2>
                        <p style="color: #64748b;">Tingkat Kepatuhan PSE</p>
                    </div>
                    <button class="btn-se-secondary" style="width: 100%; margin-top: 1rem;" onclick="alert('📊 Menampilkan detail statistik kepatuhan')">
                        <i class="fas fa-chart-line"></i> Lihat Detail
                    </button>
                </div>
            </div>
        </div>

        <!-- PENGATURAN -->
        <div id="page-setting" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-cog"></i> Pengaturan</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="settingUserName">-</span>
                    <span id="settingRole" class="role-badge"></span>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">
                <div class="setting-group">
                    <h3><i class="fas fa-lock"></i> Keamanan Akun</h3>
                    <div class="se-form-group">
                        <label>Password Saat Ini</label>
                        <input type="password" id="currentPassword" placeholder="Masukkan password saat ini">
                    </div>
                    <div class="se-form-group">
                        <label>Password Baru</label>
                        <input type="password" id="newPassword" placeholder="Minimal 8 karakter, kombinasi huruf dan angka">
                    </div>
                    <div class="se-form-group">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" id="confirmPassword" placeholder="Ulangi password baru">
                    </div>
                    <div class="password-requirements">
                        <p style="margin-bottom: 0.5rem; font-weight: 600;">Syarat Password Baru:</p>
                        <ul>
                            <li id="req-length"><i class="fas fa-circle"></i> Minimal 8 karakter</li>
                            <li id="req-max"><i class="fas fa-circle"></i> Maksimal 16 karakter</li>
                            <li id="req-letter"><i class="fas fa-circle"></i> Mengandung huruf</li>
                            <li id="req-number"><i class="fas fa-circle"></i> Mengandung angka</li>
                        </ul>
                    </div>
                    <button class="btn-se-success" style="width: 100%;" onclick="updatePassword()">
                        <i class="fas fa-key"></i> Ubah Password
                    </button>
                </div>
                
                <div class="setting-group">
                    <h3><i class="fas fa-bell"></i> Notifikasi</h3>
                    <div style="background: #f8fafc; padding: 1.2rem; border-radius: 12px; margin-bottom: 1rem;">
                        <label style="display: flex; align-items: center; margin-bottom: 1rem; cursor: pointer;">
                            <input type="checkbox" id="emailNotif" checked style="width: 18px; height: 18px; margin-right: 12px; accent-color: #3b82f6;">
                            <span style="font-weight: 500;">📧 Email Notifikasi</span>
                        </label>
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input type="checkbox" id="smsNotif" checked style="width: 18px; height: 18px; margin-right: 12px; accent-color: #3b82f6;">
                            <span style="font-weight: 500;">📱 SMS Notifikasi</span>
                        </label>
                    </div>
                    <button class="btn-se-success" style="width: 100%;" onclick="saveNotificationSettings()">
                        <i class="fas fa-save"></i> Simpan Pengaturan
                    </button>
                </div>
                
                <div class="setting-group">
                    <h3><i class="fas fa-palette"></i> Tampilan</h3>
                    <div style="background: #f8fafc; padding: 1.2rem; border-radius: 12px;">
                        <div class="se-form-group">
                            <label>Mode Tema</label>
                            <select id="themeMode">
                                <option>Terang (Default)</option>
                                <option>Gelap</option>
                                <option>Sesuai Sistem</option>
                            </select>
                        </div>
                        <div class="se-form-group">
                            <label>Ukuran Font</label>
                            <select id="fontSize">
                                <option>Sedang (Default)</option>
                                <option>Kecil</option>
                                <option>Besar</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn-se-success" style="width: 100%; margin-top: 1rem;" onclick="saveDisplaySettings()">
                        <i class="fas fa-save"></i> Simpan Tampilan
                    </button>
                </div>
            </div>
        </div>

        <!-- HALAMAN EDIT RIWAYAT (UNTUK PEMBAHARUAN) - TAMBAHAN BARU -->
        <div id="page-edit-riwayat" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-edit"></i> Edit / Pembaharuan Pengajuan SE</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="editRiwayatUserName">-</span>
                    <span id="editRiwayatRole" class="role-badge"></span>
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

        <!-- ============================================ -->
        <!-- HALAMAN SEMUA DATA PSE (UNTUK ADMIN OPD & SUPER ADMIN) -->
        <!-- ============================================ -->
        <div id="page-all-data" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-database"></i> Semua Data PSE</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="allDataUserName">-</span>
                    <span id="allDataRole" class="role-badge"></span>
                </div>
            </div>
            
            <div class="alert alert-info" style="background: #e8f4fd; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border-left: 4px solid #3b82f6;">
                <i class="fas fa-info-circle"></i> Anda dapat melihat SEMUA data PSE dari seluruh OPD/Unit Kerja. 
                <span id="roleSpecificMessage">(Mode Read-Only)</span>
            </div>
            
            <div class="filter-box">
                <input type="text" id="filterAllNamaSE" placeholder="🔍 Nama Sistem Elektronik">
                <input type="text" id="filterAllInstansi" placeholder="🏢 Instansi/Unit Kerja">
                <input type="text" id="filterAllPejabat" placeholder="👤 Pejabat">
                <select id="filterAllStatus">
                    <option>Semua Status</option>
                    <option>✅ Terbit</option>
                    <option>⏳ Menunggu Verifikasi</option>
                    <option>❌ Ditolak</option>
                    <option>🗑️ Dihapus</option>
                    <option>🔄 Pembaharuan</option>
                </select>
                <button class="btn-search" onclick="filterAllData()">🔎 Cari</button>
                <button class="btn-add" onclick="exportAllData()">📥 Export Excel</button>
            </div>
            
            <div class="table-box">
                <table class="table" id="allDataTable">
                    <thead>
                        <tr>
                            <th>📋 Aksi</th>
                            <th>👤 Pejabat</th>
                            <th>🏢 Instansi / Unit Kerja</th>
                            <th>💻 Sistem Elektronik</th>
                            <th>📊 Status</th>
                            <th>📅 Tanggal</th>
                            <th>🆔 No. Tanda Daftar</th>
                        </tr>
                    </thead>
                    <tbody id="allDataBody">
                        <tr>
                            <td colspan="7" style="text-align: center;">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-footer">
                    <div id="allDataInfo">Total: 0 data</div>
                    <div class="pagination" id="allDataPagination">
                        <button onclick="changePageAll('first')">First</button>
                        <button onclick="changePageAll('prev')">Prev</button>
                        <button class="active" onclick="changePageAll(1)">1</button>
                        <button onclick="changePageAll('next')">Next</button>
                        <button onclick="changePageAll('last')">Last</button>
                    </div>
                </div>
            </div>
            
            <!-- STATISTIK GLOBAL -->
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-top: 2rem;">
                <div style="background: white; padding: 1.5rem; border-radius: 12px; text-align: center;">
                    <h3 style="color: #1e40af; font-size: 2rem;" id="statTotalOPD">0</h3>
                    <p style="color: #64748b;">Total OPD/Unit</p>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 12px; text-align: center;">
                    <h3 style="color: #10b981; font-size: 2rem;" id="statTotalSE">0</h3>
                    <p style="color: #64748b;">Total SE Terdaftar</p>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 12px; text-align: center;">
                    <h3 style="color: #f59e0b; font-size: 2rem;" id="statTotalPengajuan">0</h3>
                    <p style="color: #64748b;">Total Pengajuan</p>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 12px; text-align: center;">
                    <h3 style="color: #ef4444; font-size: 2rem;" id="statMenunggu">0</h3>
                    <p style="color: #64748b;">Menunggu Verifikasi</p>
                </div>
            </div>
            
            <!-- GRAFIK PER OPD -->
            <div class="card" style="background: white; margin-top: 2rem; padding: 1.5rem;">
                <h3 style="color: #1e40af; margin-bottom: 1rem;">📊 Statistik per OPD</h3>
                <canvas id="allDataChart" height="200"></canvas>
            </div>
        </div>

        <!-- KELOLA PENGGUNA (SUPER ADMIN ONLY) -->
        <div id="page-admin-users" class="dashboard-content">
            <div class="dashboard-header">
                <h2><i class="fas fa-users-cog"></i> Kelola Pengguna</h2>
                <div class="user-badge">
                    <i class="fas fa-user-circle"></i> <span id="adminUsersUserName">-</span>
                    <span id="adminUsersRole" class="role-badge role-badge-super-admin">SUPER ADMIN</span>
                </div>
            </div>
            
            <div class="filter-box">
                <input type="text" id="filterUserNama" placeholder="🔍 Nama Pengguna">
                <input type="text" id="filterUserInstansi" placeholder="🏢 Instansi">
                <select id="filterUserRole">
                    <option>Semua Role</option>
                    <option>Super Admin</option>
                    <option>Admin OPD</option>
                    <option>User Biasa</option>
                </select>
                <button class="btn-search" onclick="filterUsers()">🔎 Cari</button>
                <button class="btn-add" onclick="showTambahUser()">➕ Tambah Pengguna</button>
            </div>
            
            <div class="table-box">
                <table class="table" id="usersTable">
                    <thead>
                        <tr>
                            <th>📋 Aksi</th>
                            <th>👤 Username</th>
                            <th>👤 Nama Lengkap</th>
                            <th>🏢 Instansi</th>
                            <th>📧 Email</th>
                            <th>📊 Role</th>
                            <th>📅 Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody id="usersBody">
                        <tr>
                            <td colspan="7" style="text-align: center;">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-footer">
                    <div id="usersInfo">Total: 0 pengguna</div>
                </div>
            </div>
            
            <!-- FORM TAMBAH/EDIT USER -->
            <div id="userFormContainer" style="display: none; margin-top: 2rem; background: white; padding: 2rem; border-radius: 16px;">
                <h3 style="color: #1e40af; margin-bottom: 1.5rem;" id="userFormTitle">Tambah Pengguna Baru</h3>
                <input type="hidden" id="editUsername">
                
                <div class="se-form-grid">
                    <div>
                        <div class="se-form-group">
                            <label>Username *</label>
                            <input type="text" id="userUsername" placeholder="Username">
                        </div>
                        <div class="se-form-group">
                            <label>Nama Lengkap *</label>
                            <input type="text" id="userFullname" placeholder="Nama Lengkap">
                        </div>
                        <div class="se-form-group">
                            <label>NIP *</label>
                            <input type="text" id="userNIP" placeholder="NIP">
                        </div>
                        <div class="se-form-group">
                            <label>Jabatan *</label>
                            <input type="text" id="userJabatan" placeholder="Jabatan">
                        </div>
                    </div>
                    <div>
                        <div class="se-form-group">
                            <label>Instansi *</label>
                            <input type="text" id="userInstansi" placeholder="Instansi">
                        </div>
                        <div class="se-form-group">
                            <label>Email *</label>
                            <input type="email" id="userEmail" placeholder="Email">
                        </div>
                        <div class="se-form-group">
                            <label>No. HP *</label>
                            <input type="text" id="userNoHP" placeholder="No. HP">
                        </div>
                        <div class="se-form-group">
                            <label>Role *</label>
                            <select id="userRole">
                                <option value="user">User Biasa (Hanya data sendiri)</option>
                                <option value="admin_opd">Admin OPD (Bisa lihat semua data)</option>
                                <option value="super_admin">Super Admin (Full akses)</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="se-form-group" id="passwordField">
                    <label>Password *</label>
                    <input type="password" id="userPassword" placeholder="Minimal 8 karakter">
                </div>
                
                <div class="se-actions">
                    <button class="btn-se-secondary" onclick="batalTambahUser()">Batal</button>
                    <button class="btn-se-success" onclick="simpanUser()">Simpan Pengguna</button>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- HALAMAN PUBLIC (BERANDA, CARI, TENTANG, PANDUAN, STATISTIK) -->
<div class="content-wrapper" id="publicWrapper">
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
                <i class="fas fa-info-circle"></i> Total 125 PSE terdaftar • Terakhir diperbarui: 13 Februari 2026
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
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">• Permenkominfo No. 5 Tahun 2020</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">• UU No. 11 Tahun 2008 (ITE)</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">• UU No. 27 Tahun 2022 (PDP)</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">• Perwal Probolinggo No. 12/2023</li>
                    </ul>
                </div>
                <div>
                    <h4 style="color: white; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-building" style="color: #3b82f6;"></i> Pengelola
                    </h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">• Dinas Komunikasi dan Informatika</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">• Bidang Aplikasi Informatika</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">• Seksi Tata Kelola PSE</li>
                        <li style="color: #e2e8f0; margin-bottom: 0.8rem;">• Jl. Raden Wijaya No. 45, Probolinggo</li>
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
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ Nama lengkap instansi</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ Alamat kantor pusat</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ NIP/NIK penanggung jawab</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ SK pengangkatan pejabat</li>
                        </ul>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fas fa-server" style="font-size: 2rem; color: #10b981; margin-bottom: 1rem;"></i>
                        <h5 style="color: white; font-size: 1.2rem; margin-bottom: 1rem;">Data Sistem Elektronik</h5>
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ Nama dan versi sistem</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ URL/domain aktif</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ IP server/lokasi hosting</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ Deskripsi fungsi sistem</li>
                        </ul>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1);">
                        <i class="fas fa-shield" style="font-size: 2rem; color: #f59e0b; margin-bottom: 1rem;"></i>
                        <h5 style="color: white; font-size: 1.2rem; margin-bottom: 1rem;">Dokumen Keamanan</h5>
                        <ul style="list-style: none; padding: 0;">
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ Hasil asesmen risiko</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ Klasifikasi data</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ Kebijakan keamanan</li>
                            <li style="color: #e2e8f0; margin-bottom: 0.8rem;">✓ SOP penanganan insiden</li>
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
                        <p style="color: #e2e8f0;">PDF, JPG, PNG dengan maksimal ukuran file 100MB per dokumen.</p>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); border-radius: 16px; padding: 1.5rem;">
                        <h5 style="color: white; font-weight: 600; margin-bottom: 0.8rem;">Masa berlaku TDPSE?</h5>
                        <p style="color: #e2e8f0;">Tanda Daftar PSE berlaku selama 5 tahun dan dapat diperpanjang.</p>
                    </div>
                </div>
            </div>

            <!-- VIDEO TUTORIAL -->
            <div id="video" style="margin-bottom: 2rem; scroll-margin-top: 2rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-video" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h4 style="color: white; font-size: 1.8rem; font-weight: 600; margin: 0;">Video Tutorial</h4>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                    <div style="background: rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden;">
                        <div style="background: linear-gradient(135deg, #1e293b, #0f172a); padding: 2rem; text-align: center;">
                            <i class="fas fa-play-circle" style="font-size: 4rem; color: #3b82f6;"></i>
                        </div>
                        <div style="padding: 1.5rem;">
                            <h5 style="color: white; font-weight: 600; margin-bottom: 0.5rem;">Cara Mendaftar PSE</h5>
                            <p style="color: #94a3b8; font-size: 0.9rem;">Durasi: 5:24 menit</p>
                            <button onclick="alert('🎬 Memutar video tutorial...')" style="width: 100%; padding: 0.8rem; background: #3b82f6; border: none; border-radius: 8px; color: white; font-weight: 600; margin-top: 0.5rem; cursor: pointer;">
                                <i class="fas fa-play"></i> Putar Video
                            </button>
                        </div>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden;">
                        <div style="background: linear-gradient(135deg, #1e293b, #0f172a); padding: 2rem; text-align: center;">
                            <i class="fas fa-file-upload" style="font-size: 4rem; color: #10b981;"></i>
                        </div>
                        <div style="padding: 1.5rem;">
                            <h5 style="color: white; font-weight: 600; margin-bottom: 0.5rem;">Upload Dokumen</h5>
                            <p style="color: #94a3b8; font-size: 0.9rem;">Durasi: 3:12 menit</p>
                            <button onclick="alert('🎬 Memutar video tutorial...')" style="width: 100%; padding: 0.8rem; background: #3b82f6; border: none; border-radius: 8px; color: white; font-weight: 600; margin-top: 0.5rem; cursor: pointer;">
                                <i class="fas fa-play"></i> Putar Video
                            </button>
                        </div>
                    </div>
                    <div style="background: rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden;">
                        <div style="background: linear-gradient(135deg, #1e293b, #0f172a); padding: 2rem; text-align: center;">
                            <i class="fas fa-download" style="font-size: 4rem; color: #f59e0b;"></i>
                        </div>
                        <div style="padding: 1.5rem;">
                            <h5 style="color: white; font-weight: 600; margin-bottom: 0.5rem;">Unduh TDPSE</h5>
                            <p style="color: #94a3b8; font-size: 0.9rem;">Durasi: 2:45 menit</p>
                            <button onclick="alert('🎬 Memutar video tutorial...')" style="width: 100%; padding: 0.8rem; background: #3b82f6; border: none; border-radius: 8px; color: white; font-weight: 600; margin-top: 0.5rem; cursor: pointer;">
                                <i class="fas fa-play"></i> Putar Video
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div style="display: flex; gap: 1.5rem; justify-content: center; margin-top: 3rem;">
                <a href="#" onclick="showAuth('login'); return false;" style="background: linear-gradient(135deg, #3b82f6, #1e40af); color: white; padding: 16px 36px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.8rem;">
                    <i class="fas fa-rocket"></i> Mulai Pendaftaran
                </a>
                <a href="#" onclick="alert('📥 Download Panduan PDF'); return false;" style="background: rgba(255,255,255,0.1); color: white; padding: 16px 36px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.8rem; border: 1px solid rgba(255,255,255,0.2);">
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
                                <p style="color: white; font-size: 1.8rem; font-weight: 700;">125</p>
                            </div>
                            <div>
                                <p style="color: #94a3b8;">Aktif</p>
                                <p style="color: #10b981; font-size: 1.8rem; font-weight: 700;">118</p>
                            </div>
                            <div>
                                <p style="color: #94a3b8;">Non-aktif</p>
                                <p style="color: #ef4444; font-size: 1.8rem; font-weight: 700;">7</p>
                            </div>
                            <div>
                                <p style="color: #94a3b8;">Kepatuhan</p>
                                <p style="color: #3b82f6; font-size: 1.8rem; font-weight: 700;">94.4%</p>
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
                    <i class="fas fa-chart-line"></i> Data diperbarui setiap hari • Update terakhir: 13 Februari 2026
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
    <div class="close" onclick="closeAuth()">✖</div>
    <h2 id="authTitle">Login Dashboard</h2>
    
    <!-- LOGIN FORM -->
    <div id="loginForm" class="login-form active">
        <input type="text" id="loginUsername" placeholder="Username / Email">
        <input type="password" id="loginPassword" placeholder="Password">
        <div class="reset-link">
            <span onclick="showForgotPassword()">Lupa Password?</span>
        </div>
        <button onclick="handleLogin()">Masuk</button>
        <div class="switch">
            Belum punya akun? <span onclick="showRegister()">Daftar Sekarang</span>
        </div>
    </div>

    <!-- REGISTER FORM (UNTUK USER BIASA) -->
    <div id="registerForm" class="register-form">
        <input type="text" id="regFullname" placeholder="Nama Lengkap *">
        
        <div class="form-row">
            <div class="input-wrapper">
                <input type="text" id="regNIP" placeholder="NIP *" maxlength="18" oninput="validateNIP(this)" onkeypress="return hanyaAngka(event)">
            </div>
            <input type="text" id="regJabatan" placeholder="Jabatan *">
        </div>
        
        <div class="form-row">
            <input type="text" id="regPangkat" placeholder="Pangkat / Golongan">
            <input type="text" id="regNoHP" placeholder="No. HP *">
        </div>
        
        <div class="form-row">
            <input type="text" id="regUsername" placeholder="Username *">
            <div class="input-wrapper">
                <input type="email" id="regEmail" placeholder="Email Instansi *" oninput="validateEmail(this)">
            </div>
        </div>
        
        <div class="form-row">
            <input type="password" id="regPassword" placeholder="Password *">
            <input type="text" id="regInstansi" placeholder="Instansi *">
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
        
        <button class="btn-register" onclick="handleRegister()">Daftar Akun</button>
        <div class="switch">
            Sudah punya akun? <span onclick="showLoginForm()">Masuk Sekarang</span>
        </div>
        <div class="switch" style="margin-top: 0.5rem;">
            <span onclick="showForgotPassword()">Lupa Password?</span>
        </div>
    </div>

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

// Data untuk admin (semua user)
let allUsers = [];
let allPengajuan = [];
let allSETerdaftar = [];

// Akun demo (Super Admin, Admin OPD, User Biasa)
const demoAccounts = [
    { 
        username: 'superadmin', 
        password: 'admin123', 
        fullname: 'Super Administrator', 
        nip: '197801011998031001', 
        jabatan: 'Super Admin', 
        pangkat: 'Pembina', 
        noHP: '08123456789', 
        instansi: 'Pemerintah Kota Probolinggo', 
        email: 'superadmin@probolinggokota.go.id', 
        role: 'super_admin' 
    },
    { 
        username: 'adminopd', 
        password: 'admin123', 
        fullname: 'Admin OPD', 
        nip: '197801011998031002', 
        jabatan: 'Admin OPD', 
        pangkat: 'Penata', 
        noHP: '08123456788', 
        instansi: 'Diskominfo Probolinggo', 
        email: 'adminopd@probolinggokota.go.id', 
        role: 'admin_opd' 
    },
    { 
        username: 'fitrianingsih', 
        password: '123456', 
        fullname: 'FITRIANINGSIH', 
        nip: '197801011998031001', 
        jabatan: 'Kepala Dinas', 
        pangkat: 'Pembina Utama Muda', 
        noHP: '08123456789', 
        instansi: 'Diskominfo Probolinggo', 
        email: 'fitrianingsih@probolinggokota.go.id', 
        role: 'user' 
    },
    { 
        username: 'budi', 
        password: '123456', 
        fullname: 'Budi Santoso', 
        nip: '198502102010011002', 
        jabatan: 'Kepala Bagian', 
        pangkat: 'Penata', 
        noHP: '081298765432', 
        instansi: 'Bappeda Probolinggo', 
        email: 'budi@probolinggokota.go.id', 
        role: 'user' 
    },
    { 
        username: 'siti', 
        password: '123456', 
        fullname: 'Siti Aminah', 
        nip: '197903152005012003', 
        jabatan: 'Sekretaris', 
        pangkat: 'Penata Tingkat I', 
        noHP: '081234567890', 
        instansi: 'Dinas Pendidikan', 
        email: 'siti@probolinggokota.go.id', 
        role: 'user' 
    }
];

// Inisialisasi database
function initDatabase() {
    console.log('Inisialisasi sistem dengan 3 level role');
    
    // Simpan akun demo jika belum ada
    demoAccounts.forEach(account => {
        const userKey = 'pseUser_' + account.username;
        if (!localStorage.getItem(userKey)) {
            localStorage.setItem(userKey, JSON.stringify(account));
            
            // Inisialisasi data kosong untuk akun demo jika belum ada
            if (!localStorage.getItem('pse_pengajuan_' + account.username)) {
                localStorage.setItem('pse_pengajuan_' + account.username, JSON.stringify([]));
            }
            if (!localStorage.getItem('pse_terdaftar_' + account.username)) {
                localStorage.setItem('pse_terdaftar_' + account.username, JSON.stringify([]));
            }
        }
    });
    
    // Buat beberapa data contoh untuk user biasa
    createSampleData();
}

// Buat data contoh untuk beberapa user
function createSampleData() {
    const userList = ['budi', 'siti', 'fitrianingsih'];
    
    userList.forEach(username => {
        const pengajuanKey = 'pse_pengajuan_' + username;
        const terdaftarKey = 'pse_terdaftar_' + username;
        
        let pengajuan = JSON.parse(localStorage.getItem(pengajuanKey)) || [];
        let terdaftar = JSON.parse(localStorage.getItem(terdaftarKey)) || [];
        
        // Jika masih kosong, buat data contoh
        if (pengajuan.length === 0) {
            const user = demoAccounts.find(a => a.username === username);
            if (user) {
                const now = new Date();
                const tanggal = now.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
                
                // Buat 2-3 pengajuan contoh
                for (let i = 1; i <= 3; i++) {
                    const statuses = ['Menunggu Verifikasi', '✅ Diterima', '❌ Ditolak'];
                    const status = statuses[Math.floor(Math.random() * statuses.length)];
                    
                    pengajuan.push({
                        id: Date.now() - i * 1000000,
                        nomorPengajuan: 'P-' + Math.floor(Math.random() * 9000 + 1000),
                        tanggalPengajuan: tanggal + ' 09:' + (10 + i) + '0',
                        tanggal: tanggal,
                        jenis: '📝 Pendaftaran',
                        status: status,
                        statusText: status === 'Menunggu Verifikasi' ? '⏳ Menunggu Verifikasi' : 
                                   status === '✅ Diterima' ? '✅ Diterima' : '❌ Ditolak',
                        instansi: user.instansi,
                        unitKerja: user.instansi,
                        namaSE: 'Sistem ' + (i === 1 ? 'Informasi Pelayanan' : i === 2 ? 'Manajemen Kepegawaian' : 'E-Office'),
                        versi: '1.' + i + '.0',
                        bidang: 'Layanan Pemerintahan',
                        narahubung: user.fullname,
                        telepon: user.noHP,
                        url: 'https://' + username + '.probolinggokota.go.id',
                        dns: '192.168.1.' + (100 + i),
                        deskripsi: 'Sistem untuk pelayanan publik',
                        risiko: i === 1 ? 'Strategis' : i === 2 ? 'Tinggi' : 'Rendah',
                        klasifikasi: i === 1 ? 'Terbatas' : 'Terbuka',
                        dataPribadi: 'Data masyarakat',
                        lokasi: 'Dalam Negeri',
                        dokumen: 'dokumen.pdf',
                        pengaju: username
                    });
                    
                    // Jika status diterima, tambahkan ke daftar terdaftar
                    if (status === '✅ Diterima') {
                        terdaftar.push({
                            id: Date.now() - i * 900000,
                            instansi: user.instansi,
                            unitKerja: user.instansi,
                            namaSE: 'Sistem ' + (i === 1 ? 'Informasi Pelayanan' : i === 2 ? 'Manajemen Kepegawaian' : 'E-Office'),
                            pejabat: user.fullname,
                            status: '✅ Terbit',
                            tanggalTerbit: tanggal,
                            tanggal: tanggal,
                            noTandaDaftar: 'PSE-' + (100 + i) + '/' + now.getFullYear(),
                            versi: '1.' + i + '.0',
                            bidang: 'Layanan Pemerintahan',
                            url: 'https://' + username + '.probolinggokota.go.id',
                            dns: '192.168.1.' + (100 + i),
                            deskripsi: 'Sistem untuk pelayanan publik',
                            risiko: i === 1 ? 'Strategis' : i === 2 ? 'Tinggi' : 'Rendah',
                            klasifikasi: i === 1 ? 'Terbatas' : 'Terbuka',
                            dataPribadi: 'Data masyarakat',
                            lokasi: 'Dalam Negeri',
                            dokumen: 'dokumen.pdf'
                        });
                    }
                }
                
                localStorage.setItem(pengajuanKey, JSON.stringify(pengajuan));
                localStorage.setItem(terdaftarKey, JSON.stringify(terdaftar));
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

// Fungsi untuk memuat semua data (untuk admin OPD dan super admin)
function loadAllUsersData() {
    allUsers = [];
    allPengajuan = [];
    allSETerdaftar = [];
    
    // Kumpulkan semua user dari localStorage
    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key && key.startsWith('pseUser_')) {
            const username = key.replace('pseUser_', '');
            const userData = JSON.parse(localStorage.getItem(key));
            allUsers.push(userData);
            
            // Kumpulkan pengajuan user ini
            const pengajuan = JSON.parse(localStorage.getItem('pse_pengajuan_' + username)) || [];
            const terdaftar = JSON.parse(localStorage.getItem('pse_terdaftar_' + username)) || [];
            
            // Tambahkan informasi user ke setiap item
            pengajuan.forEach(p => {
                p._username = username;
                p._userFullname = userData.fullname;
                p._userInstansi = userData.instansi;
            });
            
            terdaftar.forEach(t => {
                t._username = username;
                t._userFullname = userData.fullname;
                t._userInstansi = userData.instansi;
            });
            
            allPengajuan = allPengajuan.concat(pengajuan);
            allSETerdaftar = allSETerdaftar.concat(terdaftar);
        }
    }
    
    // Urutkan berdasarkan tanggal terbaru
    allPengajuan.sort((a, b) => new Date(b.tanggalPengajuan || b.tanggal) - new Date(a.tanggalPengajuan || a.tanggal));
    allSETerdaftar.sort((a, b) => new Date(b.tanggalTerbit || b.tanggal) - new Date(a.tanggalTerbit || a.tanggal));
    
    console.log(`Total data: ${allUsers.length} users, ${allPengajuan.length} pengajuan, ${allSETerdaftar.length} SE terdaftar`);
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
    document.getElementById('authModal').style.display = 'flex';
    
    document.getElementById('loginForm').classList.remove('active');
    document.getElementById('registerForm').classList.remove('active');
    document.getElementById('forgotPasswordForm').classList.remove('active');
    document.getElementById('resetPasswordForm').classList.remove('active');
    
    if (mode === 'register') {
        document.getElementById('registerForm').classList.add('active');
        document.getElementById('authTitle').innerText = 'Daftar Akun Baru (User Biasa)';
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
    document.getElementById('authTitle').innerText = 'Daftar Akun Baru (User Biasa)';
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
        role: 'user', // Default role untuk registrasi biasa adalah user biasa
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
    
    // Pastikan role ada
    if (!user.role) {
        user.role = 'user';
    }
    
    // Load data spesifik untuk user ini
    loadUserData(user.username);
    
    // Update role badge di semua tempat
    let roleText = '';
    let roleClass = '';
    
    if (user.role === 'super_admin') {
        roleText = 'SUPER ADMIN';
        roleClass = 'role-badge-super-admin';
    } else if (user.role === 'admin_opd') {
        roleText = 'ADMIN OPD';
        roleClass = 'role-badge-admin-opd';
    } else {
        roleText = 'USER';
        roleClass = 'role-badge-opd';
    }
    
    document.querySelectorAll('.role-badge').forEach(el => {
        if (el) {
            el.textContent = roleText;
            el.className = 'role-badge ' + roleClass;
        }
    });
    
    // Update pesan spesifik role di halaman semua data
    const roleSpecificMessage = document.getElementById('roleSpecificMessage');
    if (roleSpecificMessage) {
        if (user.role === 'super_admin') {
            roleSpecificMessage.innerHTML = '(Full Access - Bisa Kelola Pengguna)';
        } else if (user.role === 'admin_opd') {
            roleSpecificMessage.innerHTML = '(Mode Read-Only - Hanya Melihat)';
        } else {
            roleSpecificMessage.innerHTML = '(Anda tidak memiliki akses ke halaman ini)';
        }
    }
    
    // Update semua element yang menampilkan nama user
    document.querySelectorAll('#dashboardUserName, #pendaftaranUserName, #listUserName, #riwayatUserName, #profilUserName, #riwayatPejabatUserName, #panduanUserName, #laporanUserName, #settingUserName, #editRiwayatUserName, #allDataUserName, #adminUsersUserName').forEach(el => {
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
    document.getElementById('se_instansi').value = '';
    document.getElementById('se_narahubung').value = user.fullname || '';
    document.getElementById('se_telepon').value = user.noHP || '';
    
    // Update tombol login
    const loginBtn = document.getElementById('loginBtn');
    loginBtn.innerHTML = `<i class="fas fa-sign-out-alt"></i> Logout ${user.fullname} (${roleText})`;
    loginBtn.className = 'btn-login btn-logout';
    loginBtn.onclick = logout;
    
    // Tampilkan/menu berdasarkan role
    if (user.role === 'super_admin') {
        document.querySelectorAll('.admin-opd-only, .super-admin-only').forEach(el => {
            el.style.display = 'flex';
        });
    } else if (user.role === 'admin_opd') {
        document.querySelectorAll('.admin-opd-only').forEach(el => {
            el.style.display = 'flex';
        });
        document.querySelectorAll('.super-admin-only').forEach(el => {
            el.style.display = 'none';
        });
    } else {
        document.querySelectorAll('.admin-opd-only, .super-admin-only').forEach(el => {
            el.style.display = 'none';
        });
    }
    
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
    
    console.log(`✅ Login berhasil untuk ${user.username} (${user.role}) dengan ${databasePengajuan.length} pengajuan dan ${databaseSETerdaftar.length} SE terdaftar`);
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
    
    // Sembunyikan menu khusus
    document.querySelectorAll('.admin-opd-only, .super-admin-only').forEach(el => {
        el.style.display = 'none';
    });
    
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
    if (!currentUser) return;
    
    if (confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')) {
        const index = databasePengajuan.findIndex(p => p.id === id);
        if (index !== -1) {
            databasePengajuan.splice(index, 1);
            saveUserData(currentUser.username);
            loadAllData();
            alert('🗑️ Pengajuan berhasil dihapus!');
        }
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
    if (!currentUser) return;
    
    if (confirm('Apakah Anda yakin ingin menghapus SE terdaftar ini?')) {
        const index = databaseSETerdaftar.findIndex(s => s.id === id);
        if (index !== -1) {
            databaseSETerdaftar.splice(index, 1);
            saveUserData(currentUser.username);
            loadAllData();
            alert('🗑️ SE terdaftar berhasil dihapus!');
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
    
    // Jika admin OPD atau super admin, load data global
    if (currentUser.role === 'admin_opd' || currentUser.role === 'super_admin') {
        loadAllUsersData();
        loadAllDataTable();
        loadAdminStats();
    }
    
    // Jika super admin, load users table
    if (currentUser.role === 'super_admin') {
        loadUsersTable();
    }
    
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
    const tbody = document.getElementById('riwayatBody');
    if (!tbody) return;
    
    if (databasePengajuan.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5"><div class="info-box">
            <i class="fas fa-history"></i>
            <h4>Belum Ada Riwayat Pengajuan</h4>
            <p>Anda belum melakukan pengajuan SE. Silakan lakukan pendaftaran terlebih dahulu.</p>
            <button class="btn-add" onclick="showPendaftaranSE()">Daftar SE Sekarang</button>
        </div></td></tr>`;
        document.getElementById('riwayatInfo').innerHTML = '👁️ View 0 dari 0';
        return;
    }
    
    const start = (currentRiwayatPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedData = databasePengajuan.slice(start, end);
    
    let html = '';
    paginatedData.forEach((item) => {
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
                <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                    <button class="icon-btn" onclick="detailPengajuan(${item.id})" title="Detail">📄</button>
                    <button class="icon-btn icon-btn-success" onclick="approvePengajuan(${item.id})" title="Setujui">✅</button>
                    <button class="icon-btn icon-btn-danger" onclick="tolakPengajuan(${item.id})" title="Tolak">❌</button>
                    <button class="icon-btn icon-btn-warning" onclick="mintaPembaharuan(${item.id})" title="Minta Pembaharuan">🔄</button>
                    <button class="icon-btn icon-btn-danger" onclick="mintaPenghapusan(${item.id})" title="Minta Penghapusan">⛔</button>
                    <button class="icon-btn icon-btn-secondary" onclick="hapusPengajuan(${item.id})" title="Hapus">🗑️</button>
                </div>
            </td>
            <td><span class="badge ${badgeClass}">${jenisPengajuan}</span></td>
            <td><span class="badge ${badgeClass}">${item.statusText || item.status}</span></td>
            <td>${item.namaSE || '-'}</td>
            <td>${item.tanggalPengajuan || item.tanggal || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
    document.getElementById('riwayatInfo').innerHTML = `👁️ View ${start+1}-${Math.min(end, databasePengajuan.length)} dari ${databasePengajuan.length}`;
    
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
        document.getElementById('listSEInfo').innerHTML = '👁️ View 0 dari 0';
        
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
        const badgeClass = item.status === '✅ Terbit' ? 'badge-green' : 
                          item.status === '❌ Ditolak' ? 'badge-red' : 
                          item.status === '🔄 Dalam Pembaharuan' ? 'badge-orange' : 'badge-blue';
        
        html += `<tr>
            <td>
                <div style="display: flex; gap: 5px;">
                    <button class="icon-btn" onclick="detailSE(${item.id})" title="Lihat Sertifikat">📄</button>
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
    document.getElementById('listSEInfo').innerHTML = `👁️ View ${start+1}-${Math.min(end, databaseSETerdaftar.length)} dari ${databaseSETerdaftar.length}`;
    
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
// FUNGSI ADMIN - SEMUA DATA PSE (UNTUK ADMIN OPD & SUPER ADMIN)
// ============================================
let currentAllPage = 1;
const allItemsPerPage = 10;

function loadAllDataTable() {
    const tbody = document.getElementById('allDataBody');
    if (!tbody) return;
    
    loadAllUsersData();
    
    if (allSETerdaftar.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Belum ada data PSE terdaftar</td></tr>';
        document.getElementById('allDataInfo').innerHTML = 'Total: 0 data';
        return;
    }
    
    const start = (currentAllPage - 1) * allItemsPerPage;
    const end = start + allItemsPerPage;
    const paginatedData = allSETerdaftar.slice(start, end);
    
    let html = '';
    paginatedData.forEach((item, index) => {
        const badgeClass = 'badge-green';
        
        html += `<tr>
            <td>
                <div style="display: flex; gap: 5px;">
                    <button class="icon-btn" onclick="detailSEAdmin(${item.id}, '${item._username}')" title="Lihat Sertifikat">📄</button>
                </div>
            </td>
            <td><strong>${item._userFullname || item.pejabat || '-'}</strong></td>
            <td>${item.instansi || '-'} / ${item.unitKerja || '-'}</td>
            <td>${item.namaSE || '-'} (v${item.versi || '1.0'})</td>
            <td><span class="badge ${badgeClass}">${item.status || '✅ Terbit'}</span></td>
            <td>${item.tanggalTerbit || item.tanggal || '-'}</td>
            <td>${item.noTandaDaftar || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
    document.getElementById('allDataInfo').innerHTML = `Total: ${allSETerdaftar.length} data (Menampilkan ${start+1}-${Math.min(end, allSETerdaftar.length)})`;
    updatePaginationAll();
}

function updatePaginationAll() {
    const totalPages = Math.ceil(allSETerdaftar.length / allItemsPerPage);
    const paginationDiv = document.getElementById('allDataPagination');
    if (!paginationDiv) return;
    
    let html = '';
    html += `<button onclick="changePageAll('first')" ${currentAllPage === 1 ? 'disabled' : ''}>First</button>`;
    html += `<button onclick="changePageAll('prev')" ${currentAllPage === 1 ? 'disabled' : ''}>Prev</button>`;
    
    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentAllPage - 1 && i <= currentAllPage + 1)) {
            html += `<button onclick="changePageAll(${i})" class="${currentAllPage === i ? 'active' : ''}">${i}</button>`;
        } else if (i === currentAllPage - 2 || i === currentAllPage + 2) {
            html += `<button disabled>...</button>`;
        }
    }
    
    html += `<button onclick="changePageAll('next')" ${currentAllPage === totalPages ? 'disabled' : ''}>Next</button>`;
    html += `<button onclick="changePageAll('last')" ${currentAllPage === totalPages ? 'disabled' : ''}>Last</button>`;
    
    paginationDiv.innerHTML = html;
}

function changePageAll(action) {
    const totalPages = Math.ceil(allSETerdaftar.length / allItemsPerPage);
    
    if (action === 'first') currentAllPage = 1;
    else if (action === 'last') currentAllPage = totalPages;
    else if (action === 'prev') currentAllPage = Math.max(1, currentAllPage - 1);
    else if (action === 'next') currentAllPage = Math.min(totalPages, currentAllPage + 1);
    else currentAllPage = action;
    
    loadAllDataTable();
}

function filterAllData() {
    const namaFilter = document.getElementById('filterAllNamaSE').value.toLowerCase();
    const instansiFilter = document.getElementById('filterAllInstansi').value.toLowerCase();
    const pejabatFilter = document.getElementById('filterAllPejabat').value.toLowerCase();
    const statusFilter = document.getElementById('filterAllStatus').value;
    
    let filtered = allSETerdaftar;
    
    if (namaFilter) {
        filtered = filtered.filter(item => item.namaSE?.toLowerCase().includes(namaFilter));
    }
    if (instansiFilter) {
        filtered = filtered.filter(item => item.instansi?.toLowerCase().includes(instansiFilter));
    }
    if (pejabatFilter) {
        filtered = filtered.filter(item => (item._userFullname || item.pejabat)?.toLowerCase().includes(pejabatFilter));
    }
    if (statusFilter && statusFilter !== 'Semua Status') {
        filtered = filtered.filter(item => item.status?.includes(statusFilter.replace('✅', '').replace('⏳', '').trim()));
    }
    
    const tbody = document.getElementById('allDataBody');
    if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Tidak ada data yang cocok</td></tr>';
        document.getElementById('allDataInfo').innerHTML = 'Total: 0 data';
        return;
    }
    
    let html = '';
    filtered.slice(0, 20).forEach((item) => {
        const badgeClass = 'badge-green';
        
        html += `<tr>
            <td>
                <div style="display: flex; gap: 5px;">
                    <button class="icon-btn" onclick="detailSEAdmin(${item.id}, '${item._username}')" title="Lihat Sertifikat">📄</button>
                </div>
            </td>
            <td><strong>${item._userFullname || item.pejabat || '-'}</strong></td>
            <td>${item.instansi || '-'} / ${item.unitKerja || '-'}</td>
            <td>${item.namaSE || '-'} (v${item.versi || '1.0'})</td>
            <td><span class="badge ${badgeClass}">${item.status || '✅ Terbit'}</span></td>
            <td>${item.tanggalTerbit || item.tanggal || '-'}</td>
            <td>${item.noTandaDaftar || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
    document.getElementById('allDataInfo').innerHTML = `Total: ${filtered.length} data (Menampilkan ${Math.min(20, filtered.length)} data)`;
}

function detailSEAdmin(id, username) {
    // Load data user tertentu
    const terdaftarKey = 'pse_terdaftar_' + username;
    const userData = JSON.parse(localStorage.getItem(terdaftarKey)) || [];
    const se = userData.find(s => s.id === id);
    
    if (se) {
        const tempCurrentUser = currentUser;
        currentUser = { username: username, fullname: se._userFullname || se.pejabat };
        lihatSertifikat(id);
        currentUser = tempCurrentUser;
    } else {
        alert('Data tidak ditemukan!');
    }
}

function exportAllData() {
    alert('📥 Export semua data PSE ke Excel (simulasi)');
}

function loadAdminStats() {
    loadAllUsersData();
    
    // Hitung statistik
    const uniqueInstansi = new Set();
    allUsers.forEach(u => uniqueInstansi.add(u.instansi));
    
    const totalMenunggu = allPengajuan.filter(p => p.status === 'Menunggu Verifikasi' || p.status === '⏳ Menunggu Verifikasi').length;
    
    document.getElementById('statTotalOPD').innerHTML = uniqueInstansi.size;
    document.getElementById('statTotalSE').innerHTML = allSETerdaftar.length;
    document.getElementById('statTotalPengajuan').innerHTML = allPengajuan.length;
    document.getElementById('statMenunggu').innerHTML = totalMenunggu;
    
    // Buat chart admin
    const canvas = document.getElementById('allDataChart');
    if (!canvas) return;
    
    const existingChart = Chart.getChart(canvas);
    if (existingChart) {
        existingChart.destroy();
    }
    
    // Hitung per instansi
    const instansiCount = {};
    allSETerdaftar.forEach(item => {
        const instansi = item.instansi || 'Lainnya';
        instansiCount[instansi] = (instansiCount[instansi] || 0) + 1;
    });
    
    const labels = Object.keys(instansiCount).slice(0, 5);
    const data = Object.values(instansiCount).slice(0, 5);
    
    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah SE Terdaftar',
                data: data,
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

// ============================================
// FUNGSI SUPER ADMIN - KELOLA PENGGUNA
// ============================================
function loadUsersTable() {
    const tbody = document.getElementById('usersBody');
    if (!tbody) return;
    
    loadAllUsersData();
    
    if (allUsers.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Belum ada pengguna</td></tr>';
        document.getElementById('usersInfo').innerHTML = 'Total: 0 pengguna';
        return;
    }
    
    let html = '';
    allUsers.forEach((user, index) => {
        let roleText = '';
        let roleClass = '';
        
        if (user.role === 'super_admin') {
            roleText = 'Super Admin';
            roleClass = 'badge-purple';
        } else if (user.role === 'admin_opd') {
            roleText = 'Admin OPD';
            roleClass = 'badge-orange';
        } else {
            roleText = 'User Biasa';
            roleClass = 'badge-green';
        }
        
        html += `<tr>
            <td>
                <div style="display: flex; gap: 5px;">
                    <button class="icon-btn icon-btn-warning" onclick="editUser('${user.username}')" title="Edit">✏️</button>
                    <button class="icon-btn icon-btn-danger" onclick="hapusUser('${user.username}')" title="Hapus">🗑️</button>
                </div>
            </td>
            <td><strong>${user.username}</strong></td>
            <td>${user.fullname}</td>
            <td>${user.instansi || '-'}</td>
            <td>${user.email || '-'}</td>
            <td><span class="badge ${roleClass}">${roleText}</span></td>
            <td>${user.joined || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
    document.getElementById('usersInfo').innerHTML = `Total: ${allUsers.length} pengguna`;
}

function filterUsers() {
    const namaFilter = document.getElementById('filterUserNama').value.toLowerCase();
    const instansiFilter = document.getElementById('filterUserInstansi').value.toLowerCase();
    const roleFilter = document.getElementById('filterUserRole').value;
    
    loadAllUsersData();
    
    let filtered = allUsers;
    
    if (namaFilter) {
        filtered = filtered.filter(user => user.fullname?.toLowerCase().includes(namaFilter) || user.username?.toLowerCase().includes(namaFilter));
    }
    if (instansiFilter) {
        filtered = filtered.filter(user => user.instansi?.toLowerCase().includes(instansiFilter));
    }
    if (roleFilter && roleFilter !== 'Semua Role') {
        let role = '';
        if (roleFilter === 'Super Admin') role = 'super_admin';
        else if (roleFilter === 'Admin OPD') role = 'admin_opd';
        else if (roleFilter === 'User Biasa') role = 'user';
        
        filtered = filtered.filter(user => user.role === role);
    }
    
    const tbody = document.getElementById('usersBody');
    if (filtered.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Tidak ada data yang cocok</td></tr>';
        document.getElementById('usersInfo').innerHTML = 'Total: 0 pengguna';
        return;
    }
    
    let html = '';
    filtered.forEach((user) => {
        let roleText = '';
        let roleClass = '';
        
        if (user.role === 'super_admin') {
            roleText = 'Super Admin';
            roleClass = 'badge-purple';
        } else if (user.role === 'admin_opd') {
            roleText = 'Admin OPD';
            roleClass = 'badge-orange';
        } else {
            roleText = 'User Biasa';
            roleClass = 'badge-green';
        }
        
        html += `<tr>
            <td>
                <div style="display: flex; gap: 5px;">
                    <button class="icon-btn icon-btn-warning" onclick="editUser('${user.username}')" title="Edit">✏️</button>
                    <button class="icon-btn icon-btn-danger" onclick="hapusUser('${user.username}')" title="Hapus">🗑️</button>
                </div>
            </td>
            <td><strong>${user.username}</strong></td>
            <td>${user.fullname}</td>
            <td>${user.instansi || '-'}</td>
            <td>${user.email || '-'}</td>
            <td><span class="badge ${roleClass}">${roleText}</span></td>
            <td>${user.joined || '-'}</td>
        </tr>`;
    });
    
    tbody.innerHTML = html;
    document.getElementById('usersInfo').innerHTML = `Total: ${filtered.length} pengguna`;
}

function showTambahUser() {
    document.getElementById('userFormContainer').style.display = 'block';
    document.getElementById('userFormTitle').innerText = 'Tambah Pengguna Baru';
    document.getElementById('editUsername').value = '';
    document.getElementById('userUsername').value = '';
    document.getElementById('userFullname').value = '';
    document.getElementById('userNIP').value = '';
    document.getElementById('userJabatan').value = '';
    document.getElementById('userInstansi').value = '';
    document.getElementById('userEmail').value = '';
    document.getElementById('userNoHP').value = '';
    document.getElementById('userRole').value = 'user';
    document.getElementById('passwordField').style.display = 'block';
    document.getElementById('userPassword').value = '';
}

function editUser(username) {
    const userData = localStorage.getItem('pseUser_' + username);
    if (!userData) {
        alert('User tidak ditemukan!');
        return;
    }
    
    const user = JSON.parse(userData);
    
    document.getElementById('userFormContainer').style.display = 'block';
    document.getElementById('userFormTitle').innerText = 'Edit Pengguna';
    document.getElementById('editUsername').value = username;
    document.getElementById('userUsername').value = user.username;
    document.getElementById('userFullname').value = user.fullname || '';
    document.getElementById('userNIP').value = user.nip || '';
    document.getElementById('userJabatan').value = user.jabatan || '';
    document.getElementById('userInstansi').value = user.instansi || '';
    document.getElementById('userEmail').value = user.email || '';
    document.getElementById('userNoHP').value = user.noHP || '';
    document.getElementById('userRole').value = user.role || 'user';
    document.getElementById('passwordField').style.display = 'none';
}

function batalTambahUser() {
    document.getElementById('userFormContainer').style.display = 'none';
}

function simpanUser() {
    const username = document.getElementById('userUsername').value;
    const fullname = document.getElementById('userFullname').value;
    const nip = document.getElementById('userNIP').value;
    const jabatan = document.getElementById('userJabatan').value;
    const instansi = document.getElementById('userInstansi').value;
    const email = document.getElementById('userEmail').value;
    const noHP = document.getElementById('userNoHP').value;
    const role = document.getElementById('userRole').value;
    const editUsername = document.getElementById('editUsername').value;
    
    if (!username || !fullname || !nip || !jabatan || !instansi || !email || !noHP) {
        alert('❌ Lengkapi semua data!');
        return;
    }
    
    // Jika tambah baru
    if (!editUsername) {
        const password = document.getElementById('userPassword').value;
        
        if (!password) {
            alert('❌ Password harus diisi untuk user baru!');
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
            username,
            fullname,
            nip,
            jabatan,
            instansi,
            email,
            noHP,
            role,
            password,
            joined: new Date().toLocaleDateString('id-ID')
        };
        
        localStorage.setItem('pseUser_' + username, JSON.stringify(userData));
        localStorage.setItem('pse_pengajuan_' + username, JSON.stringify([]));
        localStorage.setItem('pse_terdaftar_' + username, JSON.stringify([]));
        
        alert('✅ Pengguna berhasil ditambahkan!');
    } else {
        // Edit user
        const existingUser = JSON.parse(localStorage.getItem('pseUser_' + editUsername));
        
        const userData = {
            ...existingUser,
            username,
            fullname,
            nip,
            jabatan,
            instansi,
            email,
            noHP,
            role
        };
        
        // Jika username berubah, hapus data lama
        if (editUsername !== username) {
            localStorage.removeItem('pseUser_' + editUsername);
            
            // Pindahkan data pengajuan
            const pengajuan = localStorage.getItem('pse_pengajuan_' + editUsername);
            const terdaftar = localStorage.getItem('pse_terdaftar_' + editUsername);
            
            if (pengajuan) localStorage.setItem('pse_pengajuan_' + username, pengajuan);
            if (terdaftar) localStorage.setItem('pse_terdaftar_' + username, terdaftar);
            
            localStorage.removeItem('pse_pengajuan_' + editUsername);
            localStorage.removeItem('pse_terdaftar_' + editUsername);
        }
        
        localStorage.setItem('pseUser_' + username, JSON.stringify(userData));
        alert('✅ Pengguna berhasil diupdate!');
    }
    
    document.getElementById('userFormContainer').style.display = 'none';
    loadUsersTable();
}

function hapusUser(username) {
    if (username === currentUser?.username) {
        alert('❌ Tidak dapat menghapus akun sendiri!');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin menghapus user ${username}? Semua data pengguna ini akan ikut terhapus.`)) {
        localStorage.removeItem('pseUser_' + username);
        localStorage.removeItem('pse_pengajuan_' + username);
        localStorage.removeItem('pse_terdaftar_' + username);
        
        alert('✅ User berhasil dihapus!');
        loadUsersTable();
    }
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
        
        const MAX_FILE_SIZE = 100 * 1024 * 1024;
        
        if (file.size > MAX_FILE_SIZE) {
            alert('❌ Ukuran file maksimal 100MB! File Anda sebesar ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB.');
            input.value = '';
            return;
        }
        
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('❌ Tipe file harus PDF, JPG, atau PNG!');
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
            
            alert(`✅ File "${fileName}" berhasil diupload! (${fileSize} KB)`);
            
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
    alert('📥 Download sertifikat dalam format PDF (simulasi)');
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
        if (targetId === 'page-all-data' && (currentUser?.role === 'admin_opd' || currentUser?.role === 'super_admin')) {
            loadAllDataTable();
            loadAdminStats();
        }
        if (targetId === 'page-admin-users' && currentUser?.role === 'super_admin') {
            loadUsersTable();
        }
        
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
        alert('❌ Silakan login terlebih dahulu!');
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
        alert('❌ Silakan login terlebih dahulu!');
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
        alert('❌ Silakan login terlebih dahulu!');
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
    
    alert('✅ Draft berhasil disimpan! Silakan lengkapi data dan klik "Ajukan Pengajuan" untuk mengirim.');
}

function loadDraft() {
    if (!currentUser) {
        alert('❌ Silakan login terlebih dahulu!');
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
            
            alert('✅ Draft berhasil dimuat!');
        }
    } else {
        alert('Tidak ada draft tersimpan');
    }
}

function ajukanPengajuan() {
    if (!isLoggedIn || !currentUser) {
        alert('❌ Silakan login terlebih dahulu!');
        return;
    }
    
    const checkboxes = document.querySelectorAll('#page-pendaftaran input[type="checkbox"]:checked');
    
    if (checkboxes.length !== 4) {
        alert('❌ Harap centang SEMUA (4) pernyataan kepatuhan!');
        return;
    }
    
    const namaSE = document.getElementById('se_nama').value;
    if (!namaSE) {
        alert('❌ Nama Sistem Elektronik harus diisi!');
        return;
    }
    
    const bidang = document.getElementById('se_bidang').value;
    if (!bidang || bidang === '') {
        alert('❌ Bidang/Sektor harus dipilih!');
        return;
    }

    const unitKerja = document.getElementById('se_unitkerja').value;
    if (!unitKerja || unitKerja === '') {
        alert('❌ Unit Kerja harus dipilih!');
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
    btn.innerHTML = '⏳ Mengirim...';
    btn.disabled = true;
    
    setTimeout(() => {
        simpanPengajuan(dataPengajuan);
        
        alert('🎉 Pengajuan berhasil dikirim! Silakan cek di menu Riwayat Pengajuan.');
        
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
        let pesan = `📋 DETAIL PENGAJUAN\n\n`;
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
                    <button class="icon-btn" onclick="detailSE(${item.id})" title="Lihat Sertifikat">📄</button>
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
        
        document.querySelectorAll('#dashboardUserName, #pendaftaranUserName, #listUserName, #riwayatUserName, #profilUserName, #riwayatPejabatUserName, #panduanUserName, #laporanUserName, #settingUserName, #editRiwayatUserName, #allDataUserName, #adminUsersUserName').forEach(el => {
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
    initDatabase();
    
    document.getElementById('publicWrapper').style.display = 'block';
    document.getElementById('appWrapper').style.display = 'none';
    
    console.log('✅ Portal PSE siap digunakan dengan 3 level role!');
    console.log('📝 Super Admin: superadmin / admin123');
    console.log('📝 Admin OPD: adminopd / admin123');
    console.log('📝 User Biasa: fitrianingsih / 123456, budi / 123456, siti / 123456');
};
</script>

</body>
</html>