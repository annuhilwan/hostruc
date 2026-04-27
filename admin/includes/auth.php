<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function requireLogin(): void {
    if (empty($_SESSION['admin_id'])) {
        header('Location: index.php');
        exit;
    }
}

function isLoggedIn(): bool {
    return !empty($_SESSION['admin_id']);
}
