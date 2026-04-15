<?php

require __DIR__ . '/function.php';

$config = load_config();
ensure_data_files_exist($config);

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$action = $_GET['action'] ?? '';

if ($method === 'GET' && $action === 'state') {
    $registrations = load_registrations($config['data_json']);

    json_response(build_state([
        'ok' => true
    ], $registrations, $config));
}

if ($method !== 'POST' || $action !== 'submit') {
    json_response([
        'ok' => false,
        'message' => 'Неверный запрос.'
    ], 400);
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

$fullNameRaw = trim((string)($data['fullName'] ?? ''));
$fullNameNormalized = normalize_full_name($fullNameRaw);
$phoneRaw = trim((string)($data['phone'] ?? ''));
$phoneNormalized = normalize_phone($phoneRaw);
$bus = trim((string)($data['bus'] ?? ''));

if ($fullNameRaw === '' || $phoneNormalized === '' || $bus === '') {
    json_response([
        'ok' => false,
        'message' => 'Пожалуйста, заполните все поля.'
    ], 422);
}

if (!in_array($bus, $config['buses'], true)) {
    json_response([
        'ok' => false,
        'message' => 'Некорректный автобус.'
    ], 422);
}

if (!is_valid_phone($phoneNormalized)) {
    json_response([
        'ok' => false,
        'message' => 'Введите корректный номер телефона.'
    ], 422);
}

$fp = fopen($config['data_json'], 'c+');
if (!$fp) {
    json_response([
        'ok' => false,
        'message' => 'Не удалось открыть хранилище.'
    ], 500);
}

flock($fp, LOCK_EX);

$contents = stream_get_contents($fp);
$registrations = json_decode($contents ?: '[]', true);
if (!is_array($registrations)) {
    $registrations = [];
}

$duplicate = find_duplicate_strict($registrations, $fullNameNormalized, $phoneNormalized);
if ($duplicate['isDuplicate']) {
    flock($fp, LOCK_UN);
    fclose($fp);

    json_response(build_state([
        'ok' => false,
        'message' => $duplicate['message']
    ], $registrations, $config), 409);
}

$counts = get_counts($registrations, $config['buses']);
$busLimit = (int)($config['bus_limits'][$bus] ?? 0);

if ($busLimit <= 0) {
    flock($fp, LOCK_UN);
    fclose($fp);

    json_response([
        'ok' => false,
        'message' => 'Для автобуса ' . $bus . ' не задан лимит.'
    ], 500);
}

if (($counts[$bus] ?? 0) >= $busLimit) {
    flock($fp, LOCK_UN);
    fclose($fp);

    json_response(build_state([
        'ok' => false,
        'message' => 'На автобус ' . $bus . ' мест больше нет.'
    ], $registrations, $config), 409);
}

$record = [
    'createdAt' => date('Y-m-d H:i:s'),
    'fullName' => $fullNameRaw,
    'phone' => $phoneNormalized,
    'bus' => $bus,
];

$registrations[] = $record;

rewind($fp);
ftruncate($fp, 0);
fwrite($fp, json_encode($registrations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
fflush($fp);
flock($fp, LOCK_UN);
fclose($fp);

rebuild_csv_file($registrations, $config['data_csv']);

json_response(build_state([
    'ok' => true,
    'message' => 'Вы записаны в автобус ' . $bus . '.'
], $registrations, $config));