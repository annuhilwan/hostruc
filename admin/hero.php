<?php
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';
require_once 'includes/upload.php';
$pageTitle = 'Hero Slides';

$action = $_GET['action'] ?? 'list';
$id     = (int)($_GET['id'] ?? 0);
$msg    = '';
$err    = '';

if ($action === 'delete' && $id) {
    $conn->query("DELETE FROM hero_slides WHERE id=$id");
    header('Location: hero.php?msg=deleted'); exit;
}
if ($action === 'toggle' && $id) {
    $conn->query("UPDATE hero_slides SET active=1-active WHERE id=$id");
    header('Location: hero.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fid      = (int)($_POST['id'] ?? 0);
    $title    = $conn->real_escape_string($_POST['title'] ?? '');
    $subtitle = $conn->real_escape_string($_POST['subtitle'] ?? '');
    $sort     = (int)($_POST['sort_order'] ?? 0);
    $active   = isset($_POST['active']) ? 1 : 0;

    // Handle image upload
    $upload = handleImageUpload('image_file', 'hero');
    if ($upload['error']) {
        $err = $upload['error'];
    } else {
        if ($upload['webPath']) {
            // New file uploaded
            $image = $conn->real_escape_string($upload['webPath']);
        } else {
            // Keep existing or use typed URL
            $image = $conn->real_escape_string($_POST['image_url'] ?? '');
        }

        if (!$err) {
            if ($fid) {
                $conn->query("UPDATE hero_slides SET title='$title',subtitle='$subtitle',image_url='$image',sort_order=$sort,active=$active WHERE id=$fid");
            } else {
                $conn->query("INSERT INTO hero_slides (title,subtitle,image_url,sort_order,active) VALUES ('$title','$subtitle','$image',$sort,$active)");
            }
            header('Location: hero.php?msg=saved'); exit;
        }
    }
}

$msgParam = $_GET['msg'] ?? '';
if ($msgParam === 'saved')   $msg = 'Slide saved.';
if ($msgParam === 'deleted') $msg = 'Slide deleted.';

$edit = null;
if ($action === 'edit' && $id) {
    $edit = $conn->query("SELECT * FROM hero_slides WHERE id=$id")->fetch_assoc();
}

require_once 'includes/header.php';
?>
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between">
    <div><h1>Hero Slides</h1><p>Manage homepage image slider.</p></div>
    <a href="?action=add" class="btn btn-primary">+ Add Slide</a>
</div>
<?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert alert-danger" style="background:#fdecea;border:1px solid #f5c6cb;color:#721c24;padding:12px 16px;border-radius:6px;margin-bottom:16px"><?= htmlspecialchars($err) ?></div><?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<div class="card">
    <div class="card-head"><h2><?= $action === 'edit' ? 'Edit' : 'Add' ?> Slide</h2><a href="hero.php" class="btn btn-sm btn-outline">← Back</a></div>
    <div class="card-body">
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
        <div class="form-grid">
            <div class="form-group"><label>Title</label><input type="text" name="title" value="<?= htmlspecialchars($edit['title'] ?? '') ?>"></div>
            <div class="form-group"><label>Subtitle</label><input type="text" name="subtitle" value="<?= htmlspecialchars($edit['subtitle'] ?? '') ?>"></div>
            <div class="form-group"><label>Sort Order</label><input type="number" name="sort_order" value="<?= $edit['sort_order'] ?? 0 ?>"></div>
        </div>

        <!-- Image upload -->
        <div class="form-group" style="margin-top:18px">
            <label style="font-weight:600">Slide Image</label>
            <?php $curImg = $edit['image_url'] ?? ''; ?>
            <?php if ($curImg): ?>
            <div style="margin:10px 0">
                <img src="<?= htmlspecialchars($curImg) ?>" alt="Current slide"
                     style="max-height:160px;max-width:100%;border-radius:8px;border:1px solid #e0e0e0;object-fit:cover"
                     onerror="this.style.display='none'">
                <p style="font-size:.78rem;color:#888;margin:4px 0 0">Current image</p>
            </div>
            <?php endif; ?>
            <input type="hidden" name="image_url" value="<?= htmlspecialchars($curImg) ?>">
            <div style="margin-top:8px">
                <label style="display:inline-block;cursor:pointer;background:#f5f7fa;border:2px dashed #c0c8d8;border-radius:8px;padding:18px 24px;text-align:center;width:100%;box-sizing:border-box" id="dropzone-hero">
                    <i class="fas fa-cloud-upload-alt" style="font-size:1.6rem;color:#8a9bb0;display:block;margin-bottom:6px"></i>
                    <span style="color:#555;font-size:.9rem">Click to upload or drag image here</span><br>
                    <span style="color:#aaa;font-size:.78rem">JPG, PNG, WebP — max 8 MB</span>
                    <input type="file" name="image_file" id="image_file_hero" accept="image/*" style="display:none" onchange="previewImg(this,'preview-hero')">
                </label>
                <img id="preview-hero" src="" alt="" style="display:none;max-height:160px;max-width:100%;margin-top:10px;border-radius:8px;border:1px solid #e0e0e0;object-fit:cover">
            </div>
            <?php if ($curImg): ?><p style="font-size:.8rem;color:#888;margin-top:6px">Upload a new file to replace the current image, or leave blank to keep it.</p><?php endif; ?>
        </div>

        <label style="display:flex;align-items:center;gap:8px;cursor:pointer;margin-top:14px">
            <input type="checkbox" name="active" <?= ($edit['active'] ?? 1) ? 'checked' : '' ?>> Active (visible on website)
        </label>
        <div style="margin-top:20px;display:flex;gap:12px">
            <button type="submit" class="btn btn-primary">💾 Save Slide</button>
            <a href="hero.php" class="btn btn-outline">Cancel</a>
        </div>
    </form>
    </div>
</div>

<?php else: ?>
<div class="card"><div class="card-body" style="padding:0">
<table class="tbl">
    <thead><tr><th>Order</th><th>Preview</th><th>Title</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
    <?php
    $res = $conn->query("SELECT * FROM hero_slides ORDER BY sort_order");
    while ($s = $res->fetch_assoc()):
    ?>
    <tr>
        <td><?= $s['sort_order'] ?></td>
        <td><?php if ($s['image_url']): ?>
            <img src="<?= htmlspecialchars($s['image_url']) ?>"
                 style="height:48px;width:80px;object-fit:cover;border-radius:4px"
                 onerror="this.style.display='none'">
        <?php endif; ?></td>
        <td>
            <strong><?= htmlspecialchars($s['title'] ?? '(no title)') ?></strong><br>
            <span style="font-size:.78rem;color:#999"><?= htmlspecialchars(substr($s['image_url'] ?? '', 0, 60)) ?></span>
        </td>
        <td><span class="badge <?= $s['active'] ? 'badge-green' : 'badge-red' ?>"><?= $s['active'] ? 'Active' : 'Hidden' ?></span></td>
        <td style="white-space:nowrap">
            <a href="?action=edit&id=<?= $s['id'] ?>" class="btn btn-sm btn-outline">Edit</a>
            <a href="?action=toggle&id=<?= $s['id'] ?>" class="btn btn-sm btn-outline" style="margin:0 4px"><?= $s['active'] ? 'Hide' : 'Show' ?></a>
            <a href="?action=delete&id=<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this slide?')">Del</a>
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
// Make dropzone click open file picker
document.getElementById('dropzone-hero')?.addEventListener('click', function(e) {
    if (e.target !== document.getElementById('image_file_hero')) {
        document.getElementById('image_file_hero').click();
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
