<?php

function load_config(): array {
    return require __DIR__ . '/config.php';
}

function ensure_data_files_exist(array $config): void {
    $dir = dirname($config['data_json']);

    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    if (!file_exists($config['data_json'])) {
        file_put_contents(
            $config['data_json'],
            json_encode([], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }

    if (!file_exists($config['data_csv'])) {
        rebuild_csv_file([], $config['data_csv']);
    }
}

function normalize_phone(string $phone): string {
    $digits = preg_replace('/\D+/', '', $phone);

    if (strlen($digits) === 10) {
        $digits = '7' . $digits;
    } elseif (strlen($digits) === 11 && str_starts_with($digits, '8')) {
        $digits = '7' . substr($digits, 1);
    }

    return $digits;
}

function is_valid_phone(string $phone): bool {
    return preg_match('/^7\d{10}$/', $phone) === 1;
}

function normalize_full_name(string $name): string {
    $name = trim($name);
    $name = str_replace('ё', 'е', $name);
    $name = str_replace('Ё', 'Е', $name);
    $name = preg_replace('/\s+/u', ' ', $name);
    return mb_strtolower($name, 'UTF-8');
}

function load_registrations(string $file): array {
    if (!file_exists($file)) {
        return [];
    }

    $json = file_get_contents($file);
    $data = json_decode($json, true);

    return is_array($data) ? $data : [];
}

function save_registrations(string $file, array $registrations): bool {
    return file_put_contents(
        $file,
        json_encode($registrations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
        LOCK_EX
    ) !== false;
}

function get_counts(array $registrations, array $buses): array {
    $counts = [];
    foreach ($buses as $bus) {
        $counts[$bus] = 0;
    }

    foreach ($registrations as $item) {
        $bus = (string)($item['bus'] ?? '');
        if (array_key_exists($bus, $counts)) {
            $counts[$bus]++;
        }
    }

    return $counts;
}

function get_bus_lists(array $registrations, array $buses): array {
    $lists = [];
    foreach ($buses as $bus) {
        $lists[$bus] = [];
    }

    foreach ($registrations as $item) {
        $bus = (string)($item['bus'] ?? '');
        $fullName = trim((string)($item['fullName'] ?? ''));

        if ($fullName !== '' && array_key_exists($bus, $lists)) {
            $lists[$bus][] = $fullName;
        }
    }

    return $lists;
}

function get_normalized_names(array $registrations): array {
    $result = [];

    foreach ($registrations as $item) {
        $name = normalize_full_name((string)($item['fullName'] ?? ''));
        if ($name !== '') {
            $result[] = $name;
        }
    }

    return array_values(array_unique($result));
}

function get_normalized_phones(array $registrations): array {
    $result = [];

    foreach ($registrations as $item) {
        $phone = normalize_phone((string)($item['phone'] ?? ''));
        if ($phone !== '') {
            $result[] = $phone;
        }
    }

    return array_values(array_unique($result));
}

function get_entries_for_client(array $registrations): array {
    $result = [];

    foreach ($registrations as $item) {
        $fullName = trim((string)($item['fullName'] ?? ''));
        $phone = normalize_phone((string)($item['phone'] ?? ''));

        if ($fullName !== '' || $phone !== '') {
            $result[] = [
                'fullName' => $fullName,
                'phone' => $phone,
            ];
        }
    }

    return $result;
}

function find_duplicate_strict(array $registrations, string $normalizedName, string $normalizedPhone): array {
    foreach ($registrations as $item) {
        $existingName = normalize_full_name((string)($item['fullName'] ?? ''));
        $existingPhone = normalize_phone((string)($item['phone'] ?? ''));

        if ($existingName !== '' && $existingPhone !== '' && $existingName === $normalizedName && $existingPhone === $normalizedPhone) {
            return ['isDuplicate' => true, 'message' => 'Такая заявка уже существует.'];
        }

        if ($existingPhone !== '' && $existingPhone === $normalizedPhone) {
            return ['isDuplicate' => true, 'message' => 'Этот номер телефона уже зарегистрирован.'];
        }

        if ($existingName !== '' && $existingName === $normalizedName) {
            return ['isDuplicate' => true, 'message' => 'Это ФИО уже зарегистрировано.'];
        }
    }

    return ['isDuplicate' => false, 'message' => ''];
}

function rebuild_csv_file(array $registrations, string $csvPath): void {
    $fp = fopen($csvPath, 'w');

    if (!$fp) {
        return;
    }

    fwrite($fp, "\xEF\xBB\xBF");
    fputcsv($fp, ['Дата', 'ФИО', 'Телефон', 'Автобус'], ';');

    foreach ($registrations as $row) {
        fputcsv($fp, [
            (string)($row['createdAt'] ?? ''),
            (string)($row['fullName'] ?? ''),
            (string)($row['phone'] ?? ''),
            (string)($row['bus'] ?? ''),
        ], ';');
    }

    fclose($fp);
}

function build_state(array $base, array $registrations, array $config): array {
    return array_merge($base, [
        'counts' => get_counts($registrations, $config['buses']),
        'buses' => get_bus_lists($registrations, $config['buses']),
        'staff' => $config['staff'],
        'phones' => get_normalized_phones($registrations),
        'names' => get_normalized_names($registrations),
        'entries' => get_entries_for_client($registrations),
        'limits' => $config['bus_limits'],
        'downloadUrl' => 'data/registrations.csv',
    ]);
}

function json_response(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}