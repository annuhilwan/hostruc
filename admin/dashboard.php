<?php
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';
$pageTitle = 'Dashboard';

// Safe count helper — returns 0 if table doesn't exist
function safeCount($conn, $table, $where = '') {
    $sql = "SELECT COUNT(*) c FROM `$table`" . ($where ? " WHERE $where" : '');
    $r = $conn->query($sql);
    return ($r && $row = $r->fetch_assoc()) ? (int)$row['c'] : 0;
}

// Check if tables exist; redirect to setup if not
$tablesOk = $conn->query("SHOW TABLES LIKE 'admin_users'")->num_rows > 0;
if (!$tablesOk) {
    header('Location: setup.php');
    exit;
}

$counts = [
    'projects'         => safeCount($conn, 'projects'),
    'services'         => safeCount($conn, 'services'),
    'career_positions' => safeCount($conn, 'career_positions'),
    'contacts'         => safeCount($conn, 'contacts'),
];
$unread = safeCount($conn, 'contacts', 'is_read=0');

require_once 'includes/header.php';
?>

<div class="page-header">
    <h1>Dashboard</h1>
    <p>Welcome back, <?= htmlspecialchars($_SESSION['admin_username']) ?>. Here's a quick overview.</p>
</div>

<div class="stat-grid">
    <div class="stat-card"><div class="ico">🏗</div><div class="num"><?= $counts['projects'] ?></div><div class="lbl">Projects</div></div>
    <div class="stat-card"><div class="ico">⚙</div><div class="num"><?= $counts['services'] ?></div><div class="lbl">Services</div></div>
    <div class="stat-card"><div class="ico">💼</div><div class="num"><?= $counts['career_positions'] ?></div><div class="lbl">Career Positions</div></div>
    <div class="stat-card"><div class="ico">✉</div><div class="num"><?= $counts['contacts'] ?></div><div class="lbl">Messages <span style="font-size:.75rem;color:#e53935">(<?= $unread ?> unread)</span></div></div>
</div>

<div class="card">
    <div class="card-head"><h2>Quick Actions</h2></div>
    <div class="card-body" style="display:flex;flex-wrap:wrap;gap:12px">
        <a href="projects.php?action=add" class="btn btn-primary">+ Add Project</a>
        <a href="career.php?action=add" class="btn btn-primary">+ Add Position</a>
        <a href="services.php?action=add" class="btn btn-teal">+ Add Service</a>
        <a href="settings.php" class="btn btn-outline">Edit Site Settings</a>
        <a href="contacts.php" class="btn btn-outline">View Messages <?php if($unread): ?><span style="background:#e53935;color:#fff;border-radius:10px;padding:1px 7px;font-size:.72rem;margin-left:4px"><?= $unread ?></span><?php endif; ?></a>
        <a href="../index.php" target="_blank" class="btn btn-outline">View Website ↗</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
