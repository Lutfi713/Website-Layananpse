<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Note: For production, use password_verify($password, $user['password'])
        // For this demo with provided dummy data, we compare plain text
        if ($password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['nip'] = $user['nip'];
            $_SESSION['jabatan'] = $user['jabatan'];
            $_SESSION['instansi'] = $user['instansi'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['no_hp'] = $user['no_hp'];

            if ($user['role'] === 'admin' || $user['role'] === 'super_admin') {
                $welcome = $user['role'] === 'super_admin' ? 'Super Admin' : 'Admin';
                echo "<script>alert('✅ Login $welcome berhasil! Selamat datang, " . $user['fullname'] . "'); window.location.href='dashboard.php';</script>";
            } else {
                echo "<script>alert('✅ Login berhasil! Selamat datang, " . $user['fullname'] . "'); window.location.href='user_dashboard.php';</script>";
            }
        } else {
            echo "<script>alert('❌ Password salah!'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('❌ Username atau Email tidak ditemukan!'); window.location.href='index.php';</script>";
    }
} else {
    // Jika diakses langsung tanpa POST, redirect ke halaman utama
    header("Location: index.php");
    exit();
}
?>
