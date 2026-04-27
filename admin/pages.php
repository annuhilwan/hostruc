<?php
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';
$pageTitle = 'Page Content';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['pc'] ?? [] as $id => $val) {
        $i = (int)$id;
        $v = $conn->real_escape_string($val);
        $conn->query("UPDATE page_content SET value='$v' WHERE id=$i");
    }
    // Save settings too (hero_title, about_intro, vision, mission)
    foreach ($_POST['setting'] ?? [] as $key => $val) {
        $k = $conn->real_escape_string($key);
        $v = $conn->real_escape_string($val);
        $conn->query("UPDATE settings SET value='$v' WHERE key_name='$k'");
    }
    $msg = 'Content saved.';
}

// Load page content from DB
$pcRows = $conn->query("SELECT * FROM page_content ORDER BY page,section,id");
$pcByPage = [];
while ($r = $pcRows->fetch_assoc()) $pcByPage[$r['page']][] = $r;

// Load text settings
$settingRows = $conn->query("SELECT * FROM settings WHERE key_name IN ('hero_title','about_intro','vision','mission','company_name','company_tagline')");
$settings = [];
while ($r = $settingRows->fetch_assoc()) $settings[$r['key_name']] = $r;

require_once 'includes/header.php';
?>
<div class="page-header"><h1>Page Content</h1><p>Edit text content for each page.</p></div>
<?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

<form method="POST">

<!-- Home page -->
<div class="card">
    <div class="card-head"><h2>🏠 Home Page</h2></div>
    <div class="card-body"><div class="form-grid">
        <?php foreach (['hero_title'=>'Hero Title','company_name'=>'Company Name','company_tagline'=>'Tagline'] as $k=>$lbl): ?>
        <div class="form-group">
            <label><?= $lbl ?></label>
            <textarea name="setting[<?= $k ?>]" rows="2"><?= htmlspecialchars($settings[$k]['value'] ?? '') ?></textarea>
        </div>
        <?php endforeach; ?>
    </div></div>
</div>

<!-- About page -->
<div class="card">
    <div class="card-head"><h2>ℹ️ About Us Page</h2></div>
    <div class="card-body"><div class="form-grid one">
        <?php foreach (['about_intro'=>'About Intro Text','vision'=>'Vision','mission'=>'Mission'] as $k=>$lbl): ?>
        <div class="form-group">
            <label><?= $lbl ?></label>
            <textarea name="setting[<?= $k ?>]" rows="4"><?= htmlspecialchars($settings[$k]['value'] ?? '') ?></textarea>
        </div>
        <?php endforeach; ?>
    </div></div>
</div>

<?php if (!empty($pcByPage)): ?>
<?php foreach ($pcByPage as $pageName => $blocks): ?>
<div class="card">
    <div class="card-head"><h2>📄 <?= ucfirst($pageName) ?> Page (Custom Blocks)</h2></div>
    <div class="card-body"><div class="form-grid one">
    <?php foreach ($blocks as $b): ?>
    <div class="form-group">
        <label><?= htmlspecialchars($b['label']) ?> <span class="form-hint">[<?= htmlspecialchars($b['section']) ?> › <?= htmlspecialchars($b['key_name']) ?>]</span></label>
        <textarea name="pc[<?= $b['id'] ?>]" rows="3"><?= htmlspecialchars($b['value'] ?? '') ?></textarea>
    </div>
    <?php endforeach; ?>
    </div></div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<button type="submit" class="btn btn-primary">💾 Save All Content</button>
</form>

<?php require_once 'includes/footer.php'; ?>
