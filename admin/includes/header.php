<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $pageTitle ?? 'Admin' ?> — HOSTRUC Admin</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',system-ui,sans-serif;background:#f0f2f5;color:#222;min-height:100vh;display:flex}

/* Sidebar */
.sidebar{width:240px;background:#0f1e2e;color:#fff;display:flex;flex-direction:column;min-height:100vh;flex-shrink:0;position:fixed;top:0;left:0;height:100%;overflow-y:auto}
.sidebar-brand{padding:24px 20px 18px;border-bottom:1px solid rgba(255,255,255,.1)}
.sidebar-brand-name{font-size:.85rem;font-weight:700;color:#fff;line-height:1.3}
.sidebar-brand-sub{font-size:.72rem;color:rgba(255,255,255,.5);margin-top:2px}
.sidebar-nav{flex:1;padding:16px 0}
.nav-label{font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:rgba(255,255,255,.35);padding:14px 20px 6px}
.nav-link{display:flex;align-items:center;gap:10px;padding:10px 20px;color:rgba(255,255,255,.75);text-decoration:none;font-size:.875rem;transition:background .15s,color .15s}
.nav-link:hover,.nav-link.active{background:rgba(78,205,196,.15);color:#4ecdc4}
.nav-link svg{flex-shrink:0;opacity:.8}
.sidebar-footer{padding:16px 20px;border-top:1px solid rgba(255,255,255,.1);font-size:.8rem;color:rgba(255,255,255,.4)}

/* Main */
.main{margin-left:240px;flex:1;display:flex;flex-direction:column;min-height:100vh}
.topbar{background:#fff;padding:14px 32px;border-bottom:1px solid #e0e4ea;display:flex;align-items:center;justify-content:space-between}
.topbar-title{font-size:1.1rem;font-weight:700;color:#1a2f4a}
.topbar-user{font-size:.85rem;color:#666}
.topbar-logout{margin-left:16px;font-size:.82rem;color:#e53935;text-decoration:none;font-weight:600}
.topbar-logout:hover{text-decoration:underline}
.content{padding:32px;flex:1}

/* Cards */
.page-header{margin-bottom:28px}
.page-header h1{font-size:1.4rem;font-weight:800;color:#1a2f4a}
.page-header p{font-size:.88rem;color:#777;margin-top:4px}

.stat-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;margin-bottom:32px}
.stat-card{background:#fff;border-radius:10px;padding:20px 24px;box-shadow:0 1px 4px rgba(0,0,0,.06)}
.stat-card .num{font-size:2rem;font-weight:800;color:#1a2f4a}
.stat-card .lbl{font-size:.8rem;color:#888;margin-top:4px}
.stat-card .ico{font-size:1.6rem;float:right;margin-top:-4px;opacity:.18}

/* Form styles */
.card{background:#fff;border-radius:10px;box-shadow:0 1px 4px rgba(0,0,0,.06);overflow:hidden;margin-bottom:24px}
.card-head{padding:18px 24px;border-bottom:1px solid #eee;display:flex;align-items:center;justify-content:space-between}
.card-head h2{font-size:1rem;font-weight:700;color:#1a2f4a}
.card-body{padding:24px}

.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.form-grid.one{grid-template-columns:1fr}
.form-group{display:flex;flex-direction:column;gap:6px}
.form-group label{font-size:.8rem;font-weight:600;color:#444;text-transform:uppercase;letter-spacing:.5px}
.form-group input,.form-group textarea,.form-group select{border:1.5px solid #dde0e6;border-radius:6px;padding:9px 12px;font-size:.9rem;font-family:inherit;transition:border-color .2s;background:#fff}
.form-group input:focus,.form-group textarea:focus,.form-group select:focus{outline:none;border-color:#2bb5ac}
.form-group textarea{resize:vertical;min-height:100px}
.form-hint{font-size:.75rem;color:#999}

.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:6px;font-size:.85rem;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:background .2s,opacity .2s}
.btn-primary{background:#1a2f4a;color:#fff}
.btn-primary:hover{background:#2c4f72}
.btn-teal{background:#2bb5ac;color:#fff}
.btn-teal:hover{background:#239e96}
.btn-danger{background:#e53935;color:#fff}
.btn-danger:hover{background:#c62828}
.btn-sm{padding:6px 14px;font-size:.78rem}
.btn-outline{background:transparent;border:1.5px solid #1a2f4a;color:#1a2f4a}
.btn-outline:hover{background:#1a2f4a;color:#fff}

/* Table */
.tbl{width:100%;border-collapse:collapse;font-size:.875rem}
.tbl th{text-align:left;padding:11px 14px;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#666;border-bottom:2px solid #eee;background:#fafbfc}
.tbl td{padding:12px 14px;border-bottom:1px solid #f0f0f0;vertical-align:middle}
.tbl tr:hover td{background:#fafbfc}
.badge{display:inline-block;padding:3px 9px;border-radius:20px;font-size:.72rem;font-weight:700}
.badge-green{background:#e8f5e9;color:#2e7d32}
.badge-red{background:#ffebee;color:#c62828}
.badge-blue{background:#e3f2fd;color:#1565c0}
.badge-gray{background:#f5f5f5;color:#555}

/* Alert */
.alert{padding:12px 18px;border-radius:7px;margin-bottom:20px;font-size:.88rem;font-weight:500}
.alert-success{background:#e8f5e9;color:#2e7d32;border:1px solid #a5d6a7}
.alert-error{background:#ffebee;color:#c62828;border:1px solid #ef9a9a}

/* Toggle */
.toggle{position:relative;display:inline-block;width:42px;height:24px}
.toggle input{opacity:0;width:0;height:0}
.toggle-slider{position:absolute;cursor:pointer;inset:0;background:#ccc;border-radius:24px;transition:.3s}
.toggle-slider:before{content:'';position:absolute;height:18px;width:18px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.3s}
.toggle input:checked+.toggle-slider{background:#2bb5ac}
.toggle input:checked+.toggle-slider:before{transform:translateX(18px)}
</style>
</head>
<body>

<?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-name">HOSTRUC Admin</div>
        <div class="sidebar-brand-sub">Content Management</div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Overview</div>
        <a href="dashboard.php" class="nav-link <?= $currentPage==='dashboard.php'?'active':'' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>

        <div class="nav-label">Content</div>
        <a href="settings.php" class="nav-link <?= $currentPage==='settings.php'?'active':'' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Site Settings
        </a>
        <a href="hero.php" class="nav-link <?= $currentPage==='hero.php'?'active':'' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="m3 9 4-4 4 4 4-6 4 6"/></svg>
            Hero Slides
        </a>
        <a href="pages.php" class="nav-link <?= $currentPage==='pages.php'?'active':'' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            Page Content
        </a>
        <a href="projects.php" class="nav-link <?= $currentPage==='projects.php'?'active':'' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
            Projects
        </a>
        <a href="services.php" class="nav-link <?= $currentPage==='services.php'?'active':'' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Services
        </a>
        <a href="career.php" class="nav-link <?= $currentPage==='career.php'?'active':'' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
            Career Positions
        </a>
        <a href="contacts.php" class="nav-link <?= $currentPage==='contacts.php'?'active':'' ?>">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            Contact Messages
        </a>
    </nav>
    <div class="sidebar-footer">HOSTRUC © 2026</div>
</aside>

<div class="main">
    <div class="topbar">
        <div class="topbar-title"><?= $pageTitle ?? 'Admin Panel' ?></div>
        <div>
            <span class="topbar-user">👤 <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
            <a href="logout.php" class="topbar-logout">Logout</a>
        </div>
    </div>
    <div class="content">
