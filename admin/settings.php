<?php
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';
$pageTitle = 'Site Settings';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['setting'] ?? [] as $key => $val) {
        $k = $conn->real_escape_string($key);
        $v = $conn->real_escape_string($val);
        $conn->query("UPDATE `settings` SET `value`='$v' WHERE `key_name`='$k'");
    }
    $msg = 'Settings saved successfully.';
}

$rows = $conn->query("SELECT * FROM `settings` ORDER BY grp, id");
$groups = [];
while ($r = $rows->fetch_assoc()) $groups[$r['grp']][] = $r;

require_once 'includes/header.php';
?>

<div class="page-header">
    <h1>Site Settings</h1>
    <p>Edit global site information, contact details, and more.</p>
</div>

<?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

<form method="POST">
<?php foreach ($groups as $grp => $settings): ?>
<div class="card">
    <div class="card-head"><h2><?= ucfirst($grp) ?></h2></div>
    <div class="card-body">
        <div class="form-grid">
        <?php foreach ($settings as $s): ?>
        <div class="form-group">
            <label><?= htmlspecialchars($s['label']) ?></label>
            <?php if (strlen($s['value'] ?? '') > 80 || in_array($s['key_name'],['address','about_intro','vision','mission','hero_title'])): ?>
            <textarea name="setting[<?= htmlspecialchars($s['key_name']) ?>]" rows="3"><?= htmlspecialchars($s['value'] ?? '') ?></textarea>
            <?php else: ?>
            <input type="text" name="setting[<?= htmlspecialchars($s['key_name']) ?>]" value="<?= htmlspecialchars($s['value'] ?? '') ?>">
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endforeach; ?>
<button type="submit" class="btn btn-primary">💾 Save All Settings</button>
</form>

<?php require_once 'includes/footer.php'; ?>
