<?php
require __DIR__ . '/config.php';

function post($key) {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : '';
}

function redirectTalent(string $query) {
    header('Location: talent.php?' . $query);
    exit;
}

if (post('website') !== '') {
    redirectTalent('error=Spam%20bloqu%C3%A9');
}

$entry = [
    'name'         => post('name'),
    'email'        => post('email'),
    'phone'        => post('phone'),
    'talent_type'  => post('talent_type'),
    'experience'   => post('experience'),
    'description'  => post('description'),
    'stage_ready'  => post('stage_ready'),
    'needs'        => post('needs'),
    'links'        => post('links'),
    'instagram'    => post('instagram'),
    'ip'           => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'ts'           => date('Y-m-d H:i:s'),
];

$required = ['name', 'email', 'talent_type', 'description', 'stage_ready'];
foreach ($required as $field) {
    if ($entry[$field] === '') {
        redirectTalent('error=');
    }
}

if (!filter_var($entry['email'], FILTER_VALIDATE_EMAIL)) {
    redirectTalent('error=Email%20invalide');
}

$uploadError = null;
$uploadedBlobs = handleTalentUploads('talent_media', $uploadError);
$entry['media_files'] = array_map(function ($file) {
    return [
        'original' => $file['original'] ?? '',
        'size'     => $file['size'] ?? 0,
        'mime'     => $file['mime'] ?? '',
    ];
}, $uploadedBlobs);
$entry['media_count'] = count($entry['media_files']);

if ($uploadError !== null) {
    redirectTalent('error=' . urlencode($uploadError));
}

if (!saveTalentSubmission($entry)) {
    redirectTalent('error=Sauvegarde%20impossible');
}

$e = fn($v) => htmlspecialchars($v ?: 'N/A', ENT_QUOTES, 'UTF-8');
$lines = [
    "[TALENT] Nouvelle candidature",
    "Date: {$e($entry['ts'])}",
    "IP: {$e($entry['ip'])}",
    "",
    "Nom: {$e($entry['name'])}",
    "Email: {$e($entry['email'])}",
    ($entry['phone'] !== '' ? "Telephone: {$e($entry['phone'])}" : null),
    ($entry['instagram'] !== '' ? "Instagram: {$e($entry['instagram'])}" : null),
    "Talent: {$e($entry['talent_type'])}",
    ($entry['experience'] !== '' ? "Experience: {$e($entry['experience'])}" : null),
    "Description: {$e($entry['description'])}",
    "Pret pour la scene: {$e($entry['stage_ready'])}",
    ($entry['needs'] !== '' ? "Besoins techniques: {$e($entry['needs'])}" : null),
    ($entry['links'] !== '' ? "Liens: {$e($entry['links'])}" : null),
    $entry['media_count'] > 0 ? "Fichiers: {$entry['media_count']} piece(s) sauvegardee(s)" : "Fichiers: aucun upload",
];

if ($entry['media_count'] > 0) {
    foreach ($entry['media_files'] as $file) {
        $label = $file['original'] ?? 'media';
        $sizeKb = isset($file['size']) ? round($file['size'] / 1024, 1) . 'KB' : 'n/a';
        $lines[] = "- {$e($label)} ({$sizeKb})";
    }
}

$message = implode("\n", array_filter($lines, fn($line) => $line !== null));
$ok_tg = sendTelegram($message);

$attachmentsOk = true;
if ($entry['media_count'] > 0) {
    foreach ($uploadedBlobs as $file) {
        $absolutePath = $file['temp_path'] ?? '';
        if ($absolutePath === '' || !sendTelegramAttachment($absolutePath, $file['mime'] ?? '', "Talent: {$entry['name']} ({$entry['email']})")) {
            $attachmentsOk = false;
        }
    }
}

$redirect = 'success=1';
if (!$ok_tg) {
    $redirect = 'error=Envoi%20Telegram%20%C3%A9chou%C3%A9%2C%20mais%20la%20demande%20est%20enregistr%C3%A9e';
} elseif (!$attachmentsOk) {
    error_log('Some talent attachments failed to send to Telegram, but submission saved.');
}

redirectTalent($redirect);

function handleTalentUploads(string $field, ?string &$errorMessage): array {
    $errorMessage = null;
    if (!isset($_FILES[$field]) || !is_array($_FILES[$field]['name'])) {
        return [];
    }
    $files = $_FILES[$field];
    $allowedExtensions = ['jpg','jpeg','png','gif','webp','mp4','mov','m4v','avi'];
    $maxSize = 50 * 1024 * 1024; // 50MB
    $maxFiles = 3;
    $saved = [];
    $count = count($files['name']);
    $processed = 0;

    for ($i = 0; $i < $count; $i++) {
        $original = $files['name'][$i] ?? '';
        if ($original === null || $original === '') {
            continue;
        }
        if ($processed >= $maxFiles) {
            $errorMessage = "Maximum {$maxFiles} fichiers.";
            return [];
        }
        $error = $files['error'][$i] ?? UPLOAD_ERR_NO_FILE;
        if ($error === UPLOAD_ERR_NO_FILE) {
            continue;
        }
        if ($error !== UPLOAD_ERR_OK) {
            $errorMessage = 'Erreur lors du televersement dun fichier.';
            return [];
        }
        $size = (int)($files['size'][$i] ?? 0);
        if ($size <= 0 || $size > $maxSize) {
            $errorMessage = 'Fichier trop volumineux (maximum 50MB).';
            return [];
        }
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExtensions, true)) {
            $errorMessage = 'Type de fichier non supporte : ' . $ext;
            return [];
        }
        $tmp = $files['tmp_name'][$i] ?? '';
        if ($tmp === '' || !is_uploaded_file($tmp)) {
            $errorMessage = 'Televersement invalide.';
            return [];
        }
        $saved[] = [
            'original' => $original,
            'temp_path'=> $tmp,
            'size'     => $size,
            'mime'     => $files['type'][$i] ?? '',
        ];
        $processed++;
    }

    return $saved;
}
