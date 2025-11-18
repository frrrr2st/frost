<?php
// export_csv.php — Export flat-file submissions as CSV (requires admin session)
require __DIR__ . '/config.php';
session_start();
if (!isset($_SESSION['auth'])) { http_response_code(403); echo "Forbidden"; exit; }

$rows = json_decode(@file_get_contents(DATA_FILE) ?: '[]', true);
if (!is_array($rows)) $rows = [];

// Output
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="submissions.csv"');

$out = fopen('php://output', 'w');
fputcsv($out, ['ts','name','filiere','classe','attend','no_reason','activities_free','ideas','phone','email','media_consent','cohort','ip']);
foreach ($rows as $r) {
    fputcsv($out, [
        $r['ts'] ?? '',
        $r['name'] ?? '',
        $r['filiere'] ?? '',
        $r['classe'] ?? '',
        $r['attend'] ?? '',
        $r['no_reason'] ?? '',
        $r['activities_free'] ?? '',
        $r['ideas'] ?? '',
        $r['phone'] ?? '',
        $r['email'] ?? '',
        $r['media_consent'] ?? '',
        $r['cohort'] ?? '',
        $r['ip'] ?? '',
    ]);
}
fclose($out);
