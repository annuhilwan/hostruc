<?php
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';
$pageTitle = 'Career Positions';

$action = $_GET['action'] ?? 'list';
$id     = (int)($_GET['id'] ?? 0);
$msg    = '';

if ($action === 'delete' && $id) {
    $conn->query("DELETE FROM career_positions WHERE id=$id");
    header('Location: career.php?msg=deleted'); exit;
}
if ($action === 'toggle' && $id) {
    $conn->query("UPDATE career_positions SET active=1-active WHERE id=$id");
    header('Location: career.php'); exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fid   = (int)($_POST['id'] ?? 0);
    $title = $conn->real_escape_string($_POST['title'] ?? '');
    $loc   = $conn->real_escape_string($_POST['location'] ?? '');
    $desc  = $conn->real_escape_string($_POST['description'] ?? '');
    $jd    = $conn->real_escape_string($_POST['job_desc'] ?? '');
    $req   = $conn->real_escape_string($_POST['requirements'] ?? '');
    $sort  = (int)($_POST['sort_order'] ?? 0);
    $active= isset($_POST['active']) ? 1 : 0;
    if ($fid) {
        $conn->query("UPDATE career_positions SET title='$title',location='$loc',description='$desc',job_desc='$jd',requirements='$req',sort_order=$sort,active=$active WHERE id=$fid");
    } else {
        $conn->query("INSERT INTO career_positions (title,location,description,job_desc,requirements,sort_order,active) VALUES ('$title','$loc','$desc','$jd','$req',$sort,$active)");
    }
    header('Location: career.php?msg=saved'); exit;
}

$msgParam = $_GET['msg'] ?? '';
if ($msgParam === 'saved')   $msg = 'Position saved.';
if ($msgParam === 'deleted') $msg = 'Position deleted.';

$edit = null;
if ($action === 'edit' && $id) {
    $edit = $conn->query("SELECT * FROM career_positions WHERE id=$id")->fetch_assoc();
}

require_once 'includes/header.php';
?>

<div class="page-header" style="display:flex;align-items:center;justify-content:space-between">
    <div><h1>Career Positions</h1><p>Manage open job positions.</p></div>
    <a href="?action=add" class="btn btn-primary">+ Add Position</a>
</div>

<?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<div class="card">
    <div class="card-head"><h2><?= $action==='edit'?'Edit':'Add' ?> Position</h2><a href="career.php" class="btn btn-sm btn-outline">← Back</a></div>
    <div class="card-body">
    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
        <div class="form-grid">
            <div class="form-group"><label>Position Title *</label><input type="text" name="title" required value="<?= htmlspecialchars($edit['title'] ?? '') ?>"></div>
            <div class="form-group"><label>Location</label><input type="text" name="location" value="<?= htmlspecialchars($edit['location'] ?? '') ?>"></div>
            <div class="form-group"><label>Sort Order</label><input type="number" name="sort_order" value="<?= $edit['sort_order'] ?? 0 ?>"></div>
            <div class="form-group" style="align-self:end">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;padding-bottom:10px">
                    <input type="checkbox" name="active" <?= ($edit['active']??1)?'checked':'' ?>> Active / Visible
                </label>
            </div>
        </div>
        <div class="form-group" style="margin-top:12px"><label>Short Description (shown on card)</label><textarea name="description" rows="2"><?= htmlspecialchars($edit['description'] ?? '') ?></textarea></div>
        <div class="form-group" style="margin-top:12px"><label>Job Descriptions (one per line or numbered)</label><textarea name="job_desc" rows="6"><?= htmlspecialchars($edit['job_desc'] ?? '') ?></textarea></div>
        <div class="form-group" style="margin-top:12px"><label>Requirements (one per line or numbered)</label><textarea name="requirements" rows="8"><?= htmlspecialchars($edit['requirements'] ?? '') ?></textarea></div>
        <div style="margin-top:20px;display:flex;gap:12px">
            <button type="submit" class="btn btn-primary">💾 Save Position</button>
            <a href="career.php" class="btn btn-outline">Cancel</a>
        </div>
    </form>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body" style="padding:0">
    <table class="tbl">
        <thead><tr><th>Order</th><th>Title</th><th>Location</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php
        $res = $conn->query("SELECT * FROM career_positions ORDER BY sort_order, id");
        while ($p = $res->fetch_assoc()):
        ?>
        <tr>
            <td><?= $p['sort_order'] ?></td>
            <td><strong><?= htmlspecialchars($p['title']) ?></strong><br><span style="font-size:.8rem;color:#888"><?= htmlspecialchars($p['description']) ?></span></td>
            <td><?= htmlspecialchars($p['location'] ?? '-') ?></td>
            <td><span class="badge <?= $p['active']?'badge-green':'badge-red' ?>"><?= $p['active']?'Active':'Hidden' ?></span></td>
            <td style="white-space:nowrap">
                <a href="?action=edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline">Edit</a>
                <a href="?action=toggle&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline" style="margin:0 4px"><?= $p['active']?'Hide':'Show' ?></a>
                <a href="?action=delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Del</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
