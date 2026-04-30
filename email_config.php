<?php
// Konfigurasi pengiriman email
// Jangan menaruh API key/kredensial sensitif di repository. Pakai environment variable.

// Loader sederhana untuk file .env (opsional)
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        $pos = strpos($line, '=');
        if ($pos !== false) {
            $key = trim(substr($line, 0, $pos));
            $val = trim(substr($line, $pos + 1));
            $val = trim($val, "'\""); // hapus quote jika ada
            if ($key !== '') {
                putenv("$key=$val");
            }
        }
    }
}

function envv($key, $default = null) {
    $v = getenv($key);
    return ($v === false || $v === null || $v === '') ? $default : $v;
}

function env_bool($key, $default = false) {
    $v = strtolower((string)envv($key, $default ? 'true' : 'false'));
    return in_array($v, ['1','true','on','yes'], true);
}

// Identitas pengirim default
define('EMAIL_FROM', envv('APP_EMAIL_FROM', 'no-reply@yourdomain.test'));
define('EMAIL_FROM_NAME', envv('APP_EMAIL_FROM_NAME', 'PSE Diskominfo'));

// SendGrid API
define('EMAIL_ENABLED', env_bool('APP_EMAIL_ENABLED', false));
define('SENDGRID_API_KEY', envv('APP_SENDGRID_API_KEY', ''));
define('SENDGRID_ENDPOINT', envv('APP_SENDGRID_ENDPOINT', 'https://api.sendgrid.com/v3/mail/send'));

// SMTP (mis. Gmail)
define('SMTP_ENABLED', env_bool('APP_SMTP_ENABLED', false));
define('SMTP_HOST', envv('APP_SMTP_HOST', 'smtp.gmail.com'));
define('SMTP_PORT', (int)envv('APP_SMTP_PORT', 587));
define('SMTP_SECURE', envv('APP_SMTP_SECURE', 'tls')); // tls atau smtps
define('SMTP_USER', envv('APP_SMTP_USER', ''));
define('SMTP_PASS', envv('APP_SMTP_PASS', ''));        // App Password Gmail 16 digit
define('SMTP_FROM', envv('APP_SMTP_FROM', ''));        // sebaiknya sama dengan SMTP_USER
define('SMTP_FROM_NAME', envv('APP_SMTP_FROM_NAME', 'PSE Diskominfo'));
