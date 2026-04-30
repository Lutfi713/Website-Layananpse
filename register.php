<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($koneksi, $_POST['fullname']);
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $pangkat = mysqli_real_escape_string($koneksi, $_POST['pangkat']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $instansi = mysqli_real_escape_string($koneksi, $_POST['instansi']);

    // Cek username/email/nip duplikat
    $check = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' OR email='$email' OR nip='$nip'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('❌ Username, Email, atau NIP sudah terdaftar!'); window.location.href='index.php';</script>";
        exit;
    }

    $query = "INSERT INTO users (fullname, nip, jabatan, pangkat, no_hp, username, email, password, instansi) 
              VALUES ('$fullname', '$nip', '$jabatan', '$pangkat', '$no_hp', '$username', '$email', '$password', '$instansi')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('✅ Registrasi berhasil! Silakan login.'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('❌ Gagal mendaftar: " . mysqli_error($koneksi) . "'); window.location.href='index.php';</script>";
    }
} else {
    // Jika diakses langsung tanpa POST, redirect ke halaman utama
    header("Location: index.php");
    exit();
}
?>
