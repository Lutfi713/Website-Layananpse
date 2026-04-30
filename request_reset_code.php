<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include 'koneksi.php';
include_once 'email_sender.php';
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        exit();
    }

    $identifier = isset($_POST['identifier']) ? mysqli_real_escape_string($koneksi, $_POST['identifier']) : '';
    if (empty($identifier)) {
        echo json_encode(['success' => false, 'message' => 'Masukkan username atau email']);
        exit();
    }

    $q = mysqli_query($koneksi, "SELECT id, username, email FROM users WHERE username='$identifier' OR email='$identifier' LIMIT 1");
    if (!$q || mysqli_num_rows($q) === 0) {
        echo json_encode(['success' => false, 'message' => 'Username/email tidak ditemukan']);
        exit();
    }
    $user = mysqli_fetch_assoc($q);

    $createTable = "CREATE TABLE IF NOT EXISTS password_resets (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        code VARCHAR(10) NOT NULL,
        expires_at DATETIME NOT NULL,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX (user_id),
        INDEX (code)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    mysqli_query($koneksi, $createTable);

    $code = strval(mt_rand(100000, 999999));
    $expires = date('Y-m-d H:i:s', time() + 10 * 60);
    $ins = mysqli_query($koneksi, "INSERT INTO password_resets (user_id, code, expires_at) VALUES ('{$user['id']}', '$code', '$expires')");
    if (!$ins) {
        echo json_encode(['success' => false, 'message' => 'Gagal membuat kode: ' . mysqli_error($koneksi)]);
        exit();
    }

    $emailSent = false;
    if (!empty($user['email'])) {
        $subject = 'Kode Verifikasi Reset Password - PSE Diskominfo';
        $html = "
        <div style=\"font-family: Arial, sans-serif; background:#f8fafc; padding:24px;\">
          <div style=\"max-width:640px; margin:0 auto; background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;\">
            <div style=\"background:#1e40af; color:#ffffff; padding:16px 20px; font-weight:600;\">PSE Diskominfo • Reset Password</div>
            <div style=\"padding:20px; color:#111827; line-height:1.6;\">
              <p style=\"margin:0 0 8px;\">Halo,</p>
              <p style=\"margin:0 0 16px;\">Gunakan kode verifikasi berikut untuk melanjutkan proses reset password Anda:</p>
              <div style=\"text-align:center; margin:12px 0 18px;\">
                <div style=\"display:inline-block; font-size:28px; letter-spacing:6px; font-weight:700; color:#1f2937; background:#f3f4f6; border:1px dashed #9ca3af; border-radius:8px; padding:12px 18px;\">$code</div>
              </div>
              <div style=\"background:#ecfdf5; border-left:4px solid #10b981; padding:12px 14px; border-radius:8px; color:#065f46; margin-bottom:16px;\">
                Berlaku hingga: <strong>$expires</strong>
              </div>
              <p style=\"margin:0 0 8px; font-size:14px; color:#4b5563;\">Jika Anda tidak meminta reset password, abaikan email ini.</p>
            </div>
            <div style=\"background:#f9fafb; color:#6b7280; font-size:12px; padding:12px 20px;\">© PSE Diskominfo</div>
          </div>
        </div>";
        $sendRes = send_email($user['email'], $subject, $html);
        $emailSent = $sendRes['success'];
    }
    echo json_encode([
        'success' => true,
        'message' => 'Kode verifikasi dibuat',
        'code' => $code,
        'expiry' => $expires,
        'username' => $user['username'],
        'email_sent' => $emailSent,
        'email_to' => $user['email']
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server Error']);
}
?>
