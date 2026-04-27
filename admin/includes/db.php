<?php
$conn = new mysqli('localhost', 'root', '', 'hostruc_db');

if ($conn->connect_error) {
    // Show friendly error instead of HTTP 500
    $err = htmlspecialchars($conn->connect_error);
    die('<!DOCTYPE html><html><head><meta charset="UTF-8"><title>DB Error</title>
    <style>body{font-family:sans-serif;max-width:600px;margin:80px auto;padding:0 20px}
    .box{background:#fff3cd;border:1px solid #ffc107;border-radius:8px;padding:24px}
    h2{color:#856404;margin:0 0 12px}p{color:#533f03}code{background:#fff;padding:2px 6px;border-radius:3px}
    a{color:#1a2f4a;font-weight:bold}</style></head><body>
    <div class="box">
    <h2>⚠ Database Not Found</h2>
    <p>Cannot connect to <code>hostruc_db</code>: <strong>' . $err . '</strong></p>
    <p>Please run the setup first: <a href="../setup.php">admin/setup.php</a></p>
    </div></body></html>');
}

$conn->set_charset('utf8mb4');
