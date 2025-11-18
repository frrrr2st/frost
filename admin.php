<?php
// admin.php — Flat-file admin panel (NO SQL)
require __DIR__ . '/config.php';
session_start();

// Login / Logout
if (isset($_GET['logout'])) { session_destroy(); header('Location: admin.php'); exit; }
if (!isset($_SESSION['auth'])) {
    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if ($_POST['password'] ?? '' === ADMIN_PASSWORD) {
            $_SESSION['auth'] = true;
            header('Location: admin.php'); exit;
        }
        $error = 'Wrong password';
    }
    ?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin – Connexion</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
  <div class="min-h-screen flex items-center justify-center">
    <form method="post" class="bg-white p-8 rounded-xl shadow-md w-full max-w-sm space-y-4">
      <h1 class="text-2xl font-bold">🔐 Admin Login</h1>
      <?php if (!empty($error)): ?><div class="text-red-600 text-sm"><?=htmlspecialchars($error)?></div><?php endif; ?>
      <input type="password" name="password" class="w-full border rounded px-3 py-2" placeholder="Password" required>
      <button class="w-full bg-orange-600 text-white py-2 rounded font-semibold">Sign in</button>
      <p class="text-xs text-gray-500">No database — flat-file only.</p>
    </form>
  </div>
</body>
</html>
<?php
    exit;
}

// Read data
$json = @file_get_contents(DATA_FILE);
$rows = json_decode($json ?: '[]', true);
if (!is_array($rows)) $rows = [];

// Search
$q = trim($_GET['q'] ?? '');
if ($q !== '') {
    $rows = array_values(array_filter($rows, function($r) use ($q) {
        foreach (['name','filiere','classe','attend','phone','email','ideas','activities_free','media_consent'] as $k) {
            if (isset($r[$k]) && stripos((string)$r[$k], $q) !== false) return true;
        }
        return false;
    }));
}

// Sort newest first
usort($rows, function($a,$b){ return strcmp($b['ts'] ?? '', $a['ts'] ?? ''); });

$total = count($rows);
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin – Submissions (Flat-file)</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-50">
  <div class="max-w-6xl mx-auto p-6 space-y-6">
    <div class="flex items-center justify-between">
      <h1 class="text-2xl font-bold">📥 Submissions <span class="text-gray-500 text-base">(<?=$total?>)</span></h1>
      <div class="space-x-2">
        <a href="export_csv.php" class="bg-green-600 text-white px-4 py-2 rounded">Export CSV</a>
        <a href="admin.php?logout=1" class="bg-gray-800 text-white px-4 py-2 rounded">Logout</a>
      </div>
    </div>

    <form class="flex gap-2" method="get">
      <input class="flex-1 border px-3 py-2 rounded" name="q" value="<?=htmlspecialchars($q)?>" placeholder="Search name, filière, classe, phone, email, ...">
      <button class="bg-orange-600 text-white px-4 py-2 rounded">Search</button>
      <?php if ($q!==''): ?><a href="admin.php" class="px-4 py-2 rounded border">Clear</a><?php endif; ?>
    </form>

    <div class="overflow-auto bg-white rounded-xl shadow">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="p-2 text-left">Date</th>
            <th class="p-2 text-left">Name</th>
            <th class="p-2 text-left">Filière</th>
            <th class="p-2 text-left">Classe</th>
            <th class="p-2 text-left">Attend</th>
            <th class="p-2 text-left">Phone</th>
            <th class="p-2 text-left">Email</th>
            <th class="p-2 text-left">Consent</th>
            <th class="p-2 text-left">Ideas</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
          <tr class="border-t">
            <td class="p-2"><?=htmlspecialchars($r['ts'] ?? '')?></td>
            <td class="p-2"><?=htmlspecialchars($r['name'] ?? '')?></td>
            <td class="p-2"><?=htmlspecialchars($r['filiere'] ?? '')?></td>
            <td class="p-2"><?=htmlspecialchars($r['classe'] ?? '')?></td>
            <td class="p-2"><?=htmlspecialchars($r['attend'] ?? '')?></td>
            <td class="p-2"><?=htmlspecialchars($r['phone'] ?? '')?></td>
            <td class="p-2"><?=htmlspecialchars($r['email'] ?? '')?></td>
            <td class="p-2"><?=htmlspecialchars($r['media_consent'] ?? '')?></td>
            <td class="p-2 max-w-md truncate" title="<?=htmlspecialchars(($r['ideas'] ?? '').' | '.($r['activities_free'] ?? ''))?>">
              <?=htmlspecialchars($r['ideas'] ?? '')?>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if ($total===0): ?>
          <tr><td class="p-4 text-center text-gray-500" colspan="9">No submissions yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <p class="text-xs text-gray-500">Flat-file storage in <code>data/submissions.json</code> — no SQL.</p>
  </div>
</body>
</html>
