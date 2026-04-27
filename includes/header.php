<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db_connect.php';
if (!isset($settings)) {
    $settings = loadSettings($conn);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'HOSTRUC - Building Value Through Holistic Vision' ?></title>
    <link rel="stylesheet" href="<?= BASE ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<!-- Mobile nav backdrop -->
<div class="nav-backdrop" id="navBackdrop"></div>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <a href="<?= BASE ?>/index.php" class="nav-logo">
            <img src="<?= BASE ?>/assets/images/logo.jpeg" alt="HOSTRUC Logo" class="nav-logo-img">
        </a>

        <button class="hamburger" id="hamburger" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>

        <ul class="nav-menu" id="nav-menu">
            <li><a href="<?= BASE ?>/index.php" class="nav-link <?= ($activePage ?? '') === 'home' ? 'active' : '' ?>">HOME</a></li>
            <li><a href="<?= BASE ?>/pages/about.php" class="nav-link <?= ($activePage ?? '') === 'about' ? 'active' : '' ?>">ABOUT US</a></li>
            <li><a href="<?= BASE ?>/pages/services.php" class="nav-link <?= ($activePage ?? '') === 'services' ? 'active' : '' ?>">SERVICES</a></li>
            <li><a href="<?= BASE ?>/pages/projects.php" class="nav-link <?= ($activePage ?? '') === 'projects' ? 'active' : '' ?>">PROJECTS</a></li>
            <li><a href="<?= BASE ?>/pages/career.php" class="nav-link <?= ($activePage ?? '') === 'career' ? 'active' : '' ?>">CAREER</a></li>
            <li><a href="<?= BASE ?>/pages/contact.php" class="nav-link <?= ($activePage ?? '') === 'contact' ? 'active' : '' ?>">CONTACT</a></li>
        </ul>
    </div>
</nav>
