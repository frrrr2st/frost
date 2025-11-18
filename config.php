<?php

define('TELEGRAM_BOT_TOKEN', '7576845140:AAE-whi7nFI_AhpAK_bxNAlQ4QYZAkr-NN0');
define('TELEGRAM_CHAT_ID', '-4939754888');

define('ADMIN_PASSWORD', 'BTS!Errachidia#2024'); // change to your own strong password
define('DATA_FILE', __DIR__ . '/data/submissions.json'); // flat-file storage
define('TALENT_DATA_FILE', __DIR__ . '/data/talent_submissions.json');

// Ensure data files/directories exist
foreach ([DATA_FILE, TALENT_DATA_FILE] as $filePath) {
    if (!file_exists($filePath)) {
        @mkdir(dirname($filePath), 0755, true);
        file_put_contents($filePath, "[]");
    }
}

function sendTelegram($text) {
    if (!TELEGRAM_BOT_TOKEN || !TELEGRAM_CHAT_ID) return false;
    $url = 'https://api.telegram.org/bot' . TELEGRAM_BOT_TOKEN . '/sendMessage';
    $payload = [
        'chat_id' => TELEGRAM_CHAT_ID,
        'text' => $text,
        'parse_mode' => 'HTML',
        'disable_web_page_preview' => true,
    ];
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_POSTFIELDS     => $payload,
    ]);
    $res    = curl_exec($ch);
    $err    = curl_error($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($status >= 200 && $status < 300 && $res !== false) return true;
    error_log('Telegram send error: ' . $err . ' (HTTP ' . $status . ')');
    return false;
}

function sendTelegramAttachment(string $filePath, string $mime = '', string $caption = ''): bool {
    if (!TELEGRAM_BOT_TOKEN || !TELEGRAM_CHAT_ID) return false;
    if (!is_file($filePath)) return false;

    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $imageExts = ['jpg','jpeg','png','gif','webp'];
    $videoExts = ['mp4','mov','m4v','avi'];

    $attempts = [];
    if (in_array($ext, $imageExts, true)) {
        $attempts[] = ['endpoint' => 'sendPhoto', 'field' => 'photo'];
    } elseif (in_array($ext, $videoExts, true)) {
        $attempts[] = ['endpoint' => 'sendVideo', 'field' => 'video'];
    }
    $attempts[] = ['endpoint' => 'sendDocument', 'field' => 'document'];

    foreach ($attempts as $idx => $cfg) {
        if (telegramUploadFile($cfg['endpoint'], $cfg['field'], $filePath, $mime, $caption)) {
            return true;
        }
        // keep trying fallback endpoints (photo/video -> document)
    }

    error_log('Telegram file send error: all endpoints failed for ' . basename($filePath));
    return false;
}

function telegramUploadFile(string $endpoint, string $field, string $filePath, string $mime, string $caption): bool {
    $url = 'https://api.telegram.org/bot' . TELEGRAM_BOT_TOKEN . '/' . $endpoint;
    $file = new CURLFile($filePath, $mime ?: null, basename($filePath));
    $payload = [
        'chat_id' => TELEGRAM_CHAT_ID,
        $field    => $file,
        'caption' => $caption,
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_POSTFIELDS     => $payload,
    ]);
    $res    = curl_exec($ch);
    $err    = curl_error($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($status >= 200 && $status < 300 && $res !== false) return true;
    error_log("Telegram {$endpoint} error: {$err} (HTTP {$status})");
    return false;
}

function saveJsonEntry(string $filePath, array $entry) {
    $fp = fopen($filePath, 'c+'); 
    if (!$fp) return false;
    try {
        if (!flock($fp, LOCK_EX)) { fclose($fp); return false; }
        $size = filesize($filePath);
        if ($size === 0) {
            $data = [];
        } else {
            $raw = stream_get_contents($fp);
            $data = json_decode($raw ?: '[]', true);
            if (!is_array($data)) $data = [];
        }
        $data[] = $entry;
        ftruncate($fp, 0);
        rewind($fp);
        $ok = fwrite($fp, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT)) !== false;
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
        return $ok;
    } catch (Throwable $e) {
        @fclose($fp);
        error_log('saveJsonEntry error: ' . $e->getMessage());
        return false;
    }
}

function saveSubmission(array $entry) {
    return saveJsonEntry(DATA_FILE, $entry);
}

function saveTalentSubmission(array $entry) {
    return saveJsonEntry(TALENT_DATA_FILE, $entry);
}
