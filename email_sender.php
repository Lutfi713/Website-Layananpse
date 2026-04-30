<?php
include_once __DIR__ . '/email_config.php';

// Autoload PHPMailer jika tersedia via Composer
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
}

function email_log($context, $data = []) {
    try {
        $line = '[' . date('Y-m-d H:i:s') . '] ' . $context;
        if (!empty($data)) $line .= ' | ' . json_encode($data);
        $line .= PHP_EOL;
        @file_put_contents(__DIR__ . '/email.log', $line, FILE_APPEND);
    } catch (\Throwable $e) {
        // ignore
    }
}

function send_email_sendgrid($to, $subject, $html, $text = '') {
    if (!EMAIL_ENABLED || empty(SENDGRID_API_KEY)) {
        email_log('sendgrid_disabled_or_missing_key');
        return ['success' => false, 'message' => 'Email API belum dikonfigurasi'];
    }
    $payload = [
        'personalizations' => [[ 'to' => [[ 'email' => $to ]] ]],
        'from' => [ 'email' => EMAIL_FROM, 'name' => EMAIL_FROM_NAME ],
        'subject' => $subject,
        'content' => [
            [ 'type' => 'text/plain', 'value' => $text ?: strip_tags($html) ],
            [ 'type' => 'text/html', 'value' => $html ]
        ]
    ];
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => SENDGRID_ENDPOINT,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . SENDGRID_API_KEY,
            'Content-Type: application/json'
        ],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);
    if ($err) {
        email_log('sendgrid_curl_error', ['error' => $err, 'http' => $httpCode]);
        return ['success' => false, 'message' => 'cURL error: ' . $err, 'http' => $httpCode, 'response' => $response];
    }
    // SendGrid returns 202 Accepted for successful send
    if ($httpCode >= 200 && $httpCode < 300) {
        email_log('sendgrid_success', ['to' => $to, 'subject' => $subject]);
        return ['success' => true];
    }
    email_log('sendgrid_error', ['http' => $httpCode, 'response' => $response]);
    return ['success' => false, 'message' => 'SendGrid error', 'http' => $httpCode, 'response' => $response];
}

function send_email_smtp($to, $subject, $html, $text = '') {
    if (!SMTP_ENABLED) {
        email_log('smtp_disabled');
        return ['success' => false, 'message' => 'SMTP belum diaktifkan'];
    }
    if (class_exists('\\PHPMailer\\PHPMailer\\PHPMailer')) {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = (SMTP_SECURE === 'tls') ? \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS : \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = SMTP_PORT;
            $mail->setFrom(SMTP_FROM ?: EMAIL_FROM, SMTP_FROM_NAME ?: EMAIL_FROM_NAME);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $html;
            $mail->AltBody = $text ?: strip_tags($html);
            $mail->send();
            email_log('smtp_success', ['to' => $to, 'subject' => $subject, 'host' => SMTP_HOST]);
            return ['success' => true];
        } catch (\Exception $e) {
            email_log('smtp_exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    } else {
        $headers = [];
        $from = SMTP_FROM ?: EMAIL_FROM;
        $fromName = SMTP_FROM_NAME ?: EMAIL_FROM_NAME;
        $headers[] = 'From: ' . $fromName . ' <' . $from . '>';
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
        $ok = mail($to, $subject, $html, implode("\r\n", $headers));
        email_log('smtp_mail_function', ['to' => $to, 'subject' => $subject, 'result' => $ok]);
        return ['success' => $ok, 'message' => $ok ? 'sent' : 'mail() failed'];
    }
}

function send_email($to, $subject, $html, $text = '') {
    if (SMTP_ENABLED) {
        $r = send_email_smtp($to, $subject, $html, $text);
        if ($r['success']) return $r;
    }
    if (EMAIL_ENABLED) {
        return send_email_sendgrid($to, $subject, $html, $text);
    }
    email_log('no_provider_enabled');
    return ['success' => false, 'message' => 'Tidak ada provider email aktif'];
}
