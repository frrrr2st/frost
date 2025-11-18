<?php
// submit.php — no DB. Save to flat-file and send to Telegram.
require __DIR__ . '/config.php';

function post($key) { return isset($_POST[$key]) ? trim((string)$_POST[$key]) : ''; }

// Honeypot anti-spam
if (post('website') !== '') {
    header('Location: index.php?error=Spam%20bloqu%C3%A9'); exit;
}

// Collect fields (names from your form)
$entry = [
    'name'            => post('name'),
    'filiere'         => post('filiere_select'),
    'classe'          => post('classe_select'),
    'attend'          => post('attend'),
    'no_reason'       => post('no_reason'),
    'activities_free' => post('activities_free'),
    'ideas'           => post('ideas'),
    'phone'           => post('phone'),
    'email'           => post('email'),
    'media_consent'   => post('media_consent'),
    'cohort'          => post('cohort'),
    'ip'              => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'ts'              => date('Y-m-d H:i:s'),
];

// Required validations
if ($entry['name']==='' || $entry['filiere']==='' || $entry['classe']==='' || $entry['attend']==='' || $entry['media_consent']==='') {
    header('Location: index.php?error=Veuillez%20remplir%20les%20champs%20obligatoires'); exit;
}

// Save to flat-file
$ok_save = saveSubmission($entry);

// Build Telegram message
$e = fn($v)=>htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
$lines = [
  "📨 <b>Nouvelle inscription – Journée d’Intégration</b>",
  "⏰ <b>Date:</b> {$e($entry['ts'])}",
  "🌐 <b>IP:</b> {$e($entry['ip'])}",
  "",
  "👤 <b>Nom:</b> {$e($entry['name'])}",
  "🏫 <b>Filière:</b> {$e($entry['filiere'])}",
  "📚 <b>Classe:</b> {$e($entry['classe'])}",
  ($entry['cohort']!=='' ? "🧩 <b>Cohort:</b> {$e($entry['cohort'])}" : null),
  "📅 <b>Présence:</b> {$e($entry['attend'])}",
  ($entry['no_reason']!=='' ? "📝 <b>Raison (si pas Oui):</b> {$e($entry['no_reason'])}" : null),
  ($entry['activities_free']!=='' ? "🎯 <b>Suggestions d’activités:</b> {$e($entry['activities_free'])}" : null),
  ($entry['ideas']!=='' ? "💡 <b>Idées:</b> {$e($entry['ideas'])}" : null),
  ($entry['phone']!=='' ? "📱 <b>Téléphone:</b> {$e($entry['phone'])}" : null),
  ($entry['email']!=='' ? "✉️ <b>Email:</b> {$e($entry['email'])}" : null),
  "📸 <b>Consentement médias:</b> {$e($entry['media_consent'])}",
];
$message = implode("\n", array_filter($lines, fn($l)=>$l!==null));

$ok_tg = sendTelegram($message);

// Redirect
if ($ok_save) {
    $redir = 'index.php?success=1';
    if (!$ok_tg) $redir = 'index.php?error=Envoi%20Telegram%20%C3%A9chou%C3%A9%20(mais%20donn%C3%A9es%20sauv%C3%A9es)';
    header('Location: ' . $redir);
} else {
    header('Location: index.php?error=Erreur%20enregistrement%20fichier');
}
exit;
