<?php
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';
$pageTitle = 'Contact Messages';

$id = (int)($_GET['id'] ?? 0);
$action = $_GET['action'] ?? 'list';

if ($action === 'delete' && $id) { $conn->query("DELETE FROM contacts WHERE id=$id"); header('Location: contacts.php?msg=deleted'); exit; }
if ($action === 'read' && $id) { $conn->query("UPDATE contacts SET is_read=1 WHERE id=$id"); }

$msg = '';
$msgParam = $_GET['msg'] ?? '';
if ($msgParam==='deleted') $msg='Message deleted.';

// View single
$view = null;
if ($action==='view'&&$id) {
    $view = $conn->query("SELECT * FROM contacts WHERE id=$id")->fetch_assoc();
    $conn->query("UPDATE contacts SET is_read=1 WHERE id=$id");
}

require_once 'includes/header.php';
?>
<div class="page-header"><h1>Contact Messages</h1><p>Messages submitted via the Contact form.</p></div>
<?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

<?php if ($view): ?>
<div class="card">
    <div class="card-head"><h2>Message from <?= htmlspecialchars($view['name']) ?></h2><a href="contacts.php" class="btn btn-sm btn-outline">← Back</a></div>
    <div class="card-body">
        <table style="border-collapse:collapse;width:100%;font-size:.9rem">
            <tr><td style="padding:8px 0;color:#888;width:120px">Name</td><td><?= htmlspecialchars($view['name']) ?></td></tr>
            <tr><td style="padding:8px 0;color:#888">Email</td><td><a href="mailto:<?= htmlspecialchars($view['email']) ?>"><?= htmlspecialchars($view['email']) ?></a></td></tr>
            <tr><td style="padding:8px 0;color:#888">Phone</td><td><?= htmlspecialchars($view['phone']??'-') ?></td></tr>
            <tr><td style="padding:8px 0;color:#888">Subject</td><td><?= htmlspecialchars($view['subject']??'-') ?></td></tr>
            <tr><td style="padding:8px 0;color:#888">Date</td><td><?= $view['created_at'] ?></td></tr>
            <tr><td style="padding:8px 0;color:#888;vertical-align:top">Message</td><td style="white-space:pre-wrap"><?= htmlspecialchars($view['message']) ?></td></tr>
        </table>
        <div style="margin-top:20px;display:flex;gap:12px">
            <a href="mailto:<?= htmlspecialchars($view['email']) ?>?subject=Re: <?= urlencode($view['subject']??'') ?>" class="btn btn-teal">Reply by Email</a>
            <a href="?action=delete&id=<?= $view['id'] ?>" class="btn btn-danger" onclick="return confirm('Delete?')">Delete</a>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card"><div class="card-body" style="padding:0">
<table class="tbl">
    <thead><tr><th>Date</th><th>Name</th><th>Email</th><th>Subject</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php $res=$conn->query("SELECT * FROM contacts ORDER BY created_at DESC");
    while($c=$res->fetch_assoc()): ?>
    <tr style="<?= !$c['is_read']?'font-weight:600':'' ?>">
        <td style="white-space:nowrap;font-size:.8rem"><?= date('d M Y', strtotime($c['created_at'])) ?></td>
        <td><?= htmlspecialchars($c['name']) ?></td>
        <td><?= htmlspecialchars($c['email']) ?></td>
        <td><?= htmlspecialchars(substr($c['subject']??'',0,40)) ?></td>
        <td><span class="badge <?= $c['is_read']?'badge-gray':'badge-blue' ?>"><?= $c['is_read']?'Read':'New' ?></span></td>
        <td style="white-space:nowrap">
            <a href="?action=view&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline">View</a>
            <a href="?action=delete&id=<?= $c['id'] ?>" class="btn btn-sm btn-danger" style="margin-left:4px" onclick="return confirm('Delete?')">Del</a>
        </td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div></div>
<?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
