<?php
/**
 * Graceful DB connection — site still works if DB is unavailable.
 */
if (!isset($conn)) {
    $conn = @new mysqli('localhost', 'root', '', 'hostruc_db');
    if ($conn->connect_errno) {
        $conn = null;
    } else {
        $conn->set_charset('utf8mb4');
    }
}

/**
 * Load all settings from DB into an associative array.
 */
function loadSettings($conn): array {
    if (!$conn) return [];
    $r = @$conn->query("SELECT key_name, value FROM settings");
    if (!$r) return [];
    $out = [];
    while ($row = $r->fetch_assoc()) $out[$row['key_name']] = $row['value'];
    return $out;
}

/**
 * Get a single setting, HTML-escaped, with fallback.
 */
function setting(array $s, string $key, string $default = ''): string {
    return htmlspecialchars($s[$key] ?? $default);
}

/**
 * Get raw (unescaped) setting value.
 */
function settingRaw(array $s, string $key, string $default = ''): string {
    return $s[$key] ?? $default;
}
