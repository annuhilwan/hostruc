<?php
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';
require_once 'includes/upload.php';
$pageTitle = 'Services';

$action = $_GET['action'] ?? 'list';
$id     = (int)($_GET['id'] ?? 0);
$msg    = '';
$err    = '';

if ($action === 'delete' && $id) {
    $conn->query("DELETE FROM services WHERE id=$id");
    header('Location: services.php?msg=deleted'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fid     = (int)($_POST['id'] ?? 0);
    $title   = $conn->real_escape_string($_POST['title'] ?? '');
    $slug    = $conn->real_escape_string(strtolower(preg_replace('/[^a-z0-9]+/', '-', $_POST['title'] ?? '')) . ($fid ? "-$fid" : '-' . time()));
    $icon    = $conn->real_escape_string($_POST['icon'] ?? '');
    $summary = $conn->real_escape_string($_POST['summary'] ?? '');
    $detail  = $conn->real_escape_string($_POST['detail'] ?? '');
    $sort    = (int)($_POST['sort_order'] ?? 0);

    // Handle image upload
    $upload = handleImageUpload('image_file', 'services');
    if ($upload['error']) {
        $err = $upload['error'];
    } else {
        $image = $upload['webPath']
            ? $conn->real_escape_string($upload['webPath'])
            : $conn->real_escape_string($_POST['image_url'] ?? '');

        if ($fid) {
            $conn->query("UPDATE services SET title='$title',icon='$icon',summary='$summary',detail='$detail',image='$image',sort_order=$sort WHERE id=$fid");
        } else {
            $conn->query("INSERT INTO services (title,slug,icon,summary,detail,image,sort_order) VALUES ('$title','$slug','$icon','$summary','$detail','$image',$sort)");
        }
        header('Location: services.php?msg=saved'); exit;
    }
}

$msgParam = $_GET['msg'] ?? '';
if ($msgParam === 'saved')   $msg = 'Service saved.';
if ($msgParam === 'deleted') $msg = 'Service deleted.';

$edit = null;
if ($action === 'edit' && $id) {
    $edit = $conn->query("SELECT * FROM services WHERE id=$id")->fetch_assoc();
}

require_once 'includes/header.php';
?>
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between">
    <div><h1>Services</h1><p>Manage services shown on homepage slider and services page.</p></div>
    <a href="?action=add" class="btn btn-primary">+ Add Service</a>
</div>
<?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert alert-danger" style="background:#fdecea;border:1px solid #f5c6cb;color:#721c24;padding:12px 16px;border-radius:6px;margin-bottom:16px"><?= htmlspecialchars($err) ?></div><?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<div class="card">
    <div class="card-head"><h2><?= $action === 'edit' ? 'Edit' : 'Add' ?> Service</h2><a href="services.php" class="btn btn-sm btn-outline">← Back</a></div>
    <div class="card-body">
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
        <div class="form-grid">
            <div class="form-group"><label>Title *</label><input type="text" name="title" required value="<?= htmlspecialchars($edit['title'] ?? '') ?>"></div>
            <div class="form-group"><label>Icon class (FontAwesome)</label><input type="text" name="icon" placeholder="fa-drafting-compass" value="<?= htmlspecialchars($edit['icon'] ?? '') ?>"></div>
            <div class="form-group"><label>Sort Order</label><input type="number" name="sort_order" value="<?= $edit['sort_order'] ?? 0 ?>"></div>
        </div>

        <!-- Service Image (used in homepage offer slider) -->
        <div class="form-group" style="margin-top:18px">
            <label style="font-weight:600">Service Image <span style="font-weight:400;color:#888;font-size:.85rem">(shown in "What We Can Offer" homepage slider)</span></label>
            <?php $curImg = $edit['image'] ?? ''; ?>
            <?php if ($curImg): ?>
            <div style="margin:10px 0">
                <img src="<?= htmlspecialchars($curImg) ?>" alt="Current"
                     style="max-height:160px;max-width:320px;border-radius:8px;border:1px solid #e0e0e0;object-fit:cover"
                     onerror="this.style.display='none'">
                <p style="font-size:.78rem;color:#888;margin:4px 0 0">Current image</p>
            </div>
            <?php endif; ?>
            <input type="hidden" name="image_url" value="<?= htmlspecialchars($curImg) ?>">
            <div style="margin-top:8px">
                <label style="display:inline-block;cursor:pointer;background:#f5f7fa;border:2px dashed #c0c8d8;border-radius:8px;padding:18px 24px;text-align:center;width:100%;box-sizing:border-box" id="dropzone-svc">
                    <i class="fas fa-cloud-upload-alt" style="font-size:1.6rem;color:#8a9bb0;display:block;margin-bottom:6px"></i>
                    <span style="color:#555;font-size:.9rem">Click to upload or drag image here</span><br>
                    <span style="color:#aaa;font-size:.78rem">JPG, PNG, WebP — max 8 MB &nbsp;|&nbsp; Recommended: 400×480 px (portrait)</span>
                    <input type="file" name="image_file" id="image_file_svc" accept="image/*" style="display:none" onchange="previewImg(this,'preview-svc')">
                </label>
                <img id="preview-svc" src="" alt="" style="display:none;max-height:200px;max-width:100%;margin-top:10px;border-radius:8px;border:1px solid #e0e0e0;object-fit:cover">
            </div>
            <?php if ($curImg): ?><p style="font-size:.8rem;color:#888;margin-top:6px">Upload a new file to replace, or leave blank to keep the current image.</p><?php endif; ?>
            <p style="font-size:.8rem;color:#999;margin-top:6px">If no image is uploaded, the homepage slider will show a styled placeholder with the icon above.</p>
        </div>

        <div class="form-group" style="margin-top:12px"><label>Summary <span style="font-weight:400;color:#888">(shown on services page)</span></label><textarea name="summary" rows="2"><?= htmlspecialchars($edit['summary'] ?? '') ?></textarea></div>
        <div class="form-group" style="margin-top:12px"><label>Detail Description</label><textarea name="detail" rows="4"><?= htmlspecialchars($edit['detail'] ?? '') ?></textarea></div>
        <div style="margin-top:20px;display:flex;gap:12px">
            <button type="submit" class="btn btn-primary">💾 Save</button>
            <a href="services.php" class="btn btn-outline">Cancel</a>
        </div>
    </form>
    </div>
</div>

<?php else: ?>
<div class="card"><div class="card-body" style="padding:0">
<table class="tbl">
    <thead><tr><th>Order</th><th>Image</th><th>Title</th><th>Icon</th><th>Summary</th><th>Actions</th></tr></thead>
    <tbody>
    <?php
    $res = $conn->query("SELECT * FROM services ORDER BY sort_order");
    while ($s = $res->fetch_assoc()):
    ?>
    <tr>
        <td><?= $s['sort_order'] ?></td>
        <td><?php if ($s['image']): ?>
            <img src="<?= htmlspecialchars($s['image']) ?>"
                 style="height:44px;width:66px;object-fit:cover;border-radius:4px"
                 onerror="this.style.display='none'">
            <?php else: ?>
            <span style="font-size:1.4rem;color:#8a9bb0"><i class="fas <?= htmlspecialchars($s['icon'] ?? 'fa-image') ?>"></i></span>
            <?php endif; ?></td>
        <td><strong><?= htmlspecialchars($s['title']) ?></strong></td>
        <td><code style="font-size:.78rem"><?= htmlspecialchars($s['icon'] ?? '') ?></code></td>
        <td style="max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($s['summary'] ?? '') ?></td>
        <td style="white-space:nowrap">
            <a href="?action=edit&id=<?= $s['id'] ?>" class="btn btn-sm btn-outline">Edit</a>
            <a href="?action=delete&id=<?= $s['id'] ?>" class="btn btn-sm btn-danger" style="margin-left:4px" onclick="return confirm('Delete this service?')">Del</a>
        </td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div></div>
<?php endif; ?>

<script>
function previewImg(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
document.getElementById('dropzone-svc')?.addEventListener('click', function(e) {
    if (e.target !== document.getElementById('image_file_svc')) {
        document.getElementById('image_file_svc').click();
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
