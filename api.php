<?php
// API per backup NAS Rapportini OA Osti. I dati NON devono essere salvati sotto la web root.
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['ok'=>false,'error'=>'Metodo non consentito']); exit; }
$configFile = __DIR__ . '/config.php';
if (!is_file($configFile)) { http_response_code(500); echo json_encode(['ok'=>false,'error'=>'Configurazione NAS mancante']); exit; }
$config = require $configFile;
$dataDir = isset($config['data_dir']) ? rtrim($config['data_dir'], DIRECTORY_SEPARATOR) : '';
if ($dataDir === '' || !is_dir($dataDir) || !is_writable($dataDir)) { http_response_code(500); echo json_encode(['ok'=>false,'error'=>'Cartella backup non disponibile o non scrivibile']); exit; }
$raw = file_get_contents('php://input');
if ($raw === false || strlen($raw) > 10 * 1024 * 1024) { http_response_code(413); echo json_encode(['ok'=>false,'error'=>'Richiesta vuota o troppo grande']); exit; }
$input = json_decode($raw, true);
if (!is_array($input)) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'JSON non valido']); exit; }
$identifier = isset($input['identifier']) ? strtoupper((string)$input['identifier']) : '';
if (!preg_match('/^[A-Z0-9]{2,100}$/', $identifier)) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Identificativo non valido']); exit; }
$action = isset($input['action']) ? $input['action'] : '';
$file = $dataDir . DIRECTORY_SEPARATOR . $identifier . '.json';
if ($action === 'restore') {
    if (!is_file($file)) { echo json_encode(['ok'=>true,'found'=>false]); exit; }
    $saved = file_get_contents($file);
    $backup = json_decode($saved, true);
    if (!is_array($backup) || !isset($backup['reports']) || !is_array($backup['reports'])) { http_response_code(500); echo json_encode(['ok'=>false,'error'=>'Backup presente ma non leggibile']); exit; }
    echo json_encode(['ok'=>true,'found'=>true,'backup'=>$backup], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE); exit;
}
if ($action === 'backup') {
    $backup = isset($input['backup']) ? $input['backup'] : null;
    if (!is_array($backup) || !isset($backup['reports']) || !is_array($backup['reports']) || count($backup['reports']) > 50000) { http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Contenuto backup non valido']); exit; }
    $record = ['format'=>'oaosti-backup','version'=>1,'identifier'=>$identifier,'createdAt'=>date(DATE_ATOM),'reports'=>$backup['reports']];
    $encoded = json_encode($record, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    if ($encoded === false || strlen($encoded) > 10 * 1024 * 1024) { http_response_code(413); echo json_encode(['ok'=>false,'error'=>'Backup troppo grande o non codificabile']); exit; }
    $tmp = tempnam($dataDir, '.oaosti-');
    if ($tmp === false || file_put_contents($tmp, $encoded, LOCK_EX) === false) { if ($tmp) @unlink($tmp); http_response_code(500); echo json_encode(['ok'=>false,'error'=>'Scrittura backup non riuscita']); exit; }
    @chmod($tmp, 0600);
    if (!rename($tmp, $file)) { @unlink($tmp); http_response_code(500); echo json_encode(['ok'=>false,'error'=>'Sostituzione backup non riuscita']); exit; }
    echo json_encode(['ok'=>true,'savedAt'=>$record['createdAt'],'replaced'=>true]); exit;
}
http_response_code(400); echo json_encode(['ok'=>false,'error'=>'Azione non riconosciuta']);
?>
