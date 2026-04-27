<?php
require_once 'includes/auth.php';
requireLogin();
require_once 'includes/db.php';
require_once 'includes/upload.php';
$pageTitle = 'Projects';

$msg = $err = '';
$action = $_GET['action'] ?? 'list';
$id     = (int)($_GET['id'] ?? 0);

if ($action === 'delete' && $id) {
    $conn->query("DELETE FROM projects WHERE id=$id");
    header('Location: projects.php?msg=deleted'); exit;
}
if ($action === 'toggle' && $id) {
    $conn->query("UPDATE projects SET active = 1-active WHERE id=$id");
    header('Location: projects.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fid       = (int)($_POST['id'] ?? 0);
    $no_urut   = (int)($_POST['no_urut'] ?? 0);
    $title     = $conn->real_escape_string($_POST['title'] ?? '');
    $client    = $conn->real_escape_string($_POST['client'] ?? '');
    $category  = $conn->real_escape_string($_POST['category'] ?? 'Multipurpose');
    $location  = $conn->real_escape_string($_POST['location'] ?? '');
    $year      = $conn->real_escape_string($_POST['year'] ?? '');
    $structure = $conn->real_escape_string($_POST['structure'] ?? '');
    $desc      = $conn->real_escape_string($_POST['description'] ?? '');
    $slug      = $conn->real_escape_string(strtolower(preg_replace('/[^a-z0-9]+/', '-', $_POST['title'] ?? '')) . ($fid ? "-$fid" : '-' . time()));
    $active    = isset($_POST['active'])   ? 1 : 0;
    $featured  = isset($_POST['featured']) ? 1 : 0;

    // Handle image upload
    $upload = handleImageUpload('image_file', 'projects');
    if ($upload['error']) {
        $err = $upload['error'];
    } else {
        $image = $upload['webPath']
            ? $conn->real_escape_string($upload['webPath'])
            : $conn->real_escape_string($_POST['image_url'] ?? '');

        if ($fid) {
            $conn->query("UPDATE projects SET no_urut=$no_urut,title='$title',client='$client',category='$category',location='$location',year='$year',structure='$structure',description='$desc',image='$image',active=$active,featured=$featured WHERE id=$fid");
        } else {
            $conn->query("INSERT INTO projects (no_urut,title,slug,client,category,location,year,structure,description,image,active,featured) VALUES ($no_urut,'$title','$slug','$client','$category','$location','$year','$structure','$desc','$image',$active,$featured)");
        }
        header('Location: projects.php?msg=saved'); exit;
    }
}

$msgParam = $_GET['msg'] ?? '';
if ($msgParam === 'saved')   $msg = 'Project saved successfully.';
if ($msgParam === 'deleted') $msg = 'Project deleted.';

$edit = null;
if ($action === 'edit' && $id) {
    $edit = $conn->query("SELECT * FROM projects WHERE id=$id")->fetch_assoc();
}

require_once 'includes/header.php';
?>

<div class="page-header" style="display:flex;align-items:center;justify-content:space-between">
    <div><h1>Projects</h1><p>Manage all project entries.</p></div>
    <a href="?action=add" class="btn btn-primary">+ Add Project</a>
</div>

<?php if ($msg): ?><div class="alert alert-success"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<?php if ($err): ?><div class="alert alert-danger" style="background:#fdecea;border:1px solid #f5c6cb;color:#721c24;padding:12px 16px;border-radius:6px;margin-bottom:16px"><?= htmlspecialchars($err) ?></div><?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
<div class="card">
    <div class="card-head"><h2><?= $action === 'edit' ? 'Edit' : 'Add New' ?> Project</h2><a href="projects.php" class="btn btn-sm btn-outline">← Back</a></div>
    <div class="card-body">
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
        <div class="form-grid">
            <div class="form-group"><label>No. Urut</label><input type="number" name="no_urut" value="<?= htmlspecialchars($edit['no_urut'] ?? '') ?>"></div>
            <div class="form-group"><label>Project Title *</label><input type="text" name="title" required value="<?= htmlspecialchars($edit['title'] ?? '') ?>"></div>
            <div class="form-group"><label>Client</label><input type="text" name="client" value="<?= htmlspecialchars($edit['client'] ?? '') ?>"></div>
            <div class="form-group"><label>Category</label>
                <select name="category">
                    <?php foreach (['Residential','Commercial','Industrial','Infrastructure','Hospitality','Multipurpose'] as $c): ?>
                    <option <?= ($edit['category'] ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group"><label>Location</label><input type="text" name="location" value="<?= htmlspecialchars($edit['location'] ?? '') ?>"></div>
            <div class="form-group"><label>Year</label><input type="text" name="year" value="<?= htmlspecialchars($edit['year'] ?? '') ?>"></div>
            <div class="form-group"><label>Structure Type</label><input type="text" name="structure" placeholder="e.g. Concrete &amp; Steel" value="<?= htmlspecialchars($edit['structure'] ?? '') ?>"></div>
        </div>

        <!-- Project Image -->
        <div class="form-group" style="margin-top:18px">
            <label style="font-weight:600">Project Image</label>
            <?php $curImg = $edit['image'] ?? ''; ?>
            <?php if ($curImg): ?>
            <div style="margin:10px 0">
                <img src="<?= htmlspecialchars($curImg) ?>" alt="Current project image"
                     style="max-height:180px;max-width:100%;border-radius:8px;border:1px solid #e0e0e0;object-fit:cover"
                     onerror="this.style.display='none'">
                <p style="font-size:.78rem;color:#888;margin:4px 0 0">Current image</p>
            </div>
            <?php endif; ?>
            <input type="hidden" name="image_url" value="<?= htmlspecialchars($curImg) ?>">
            <div style="margin-top:8px">
                <label style="display:inline-block;cursor:pointer;background:#f5f7fa;border:2px dashed #c0c8d8;border-radius:8px;padding:18px 24px;text-align:center;width:100%;box-sizing:border-box" id="dropzone-proj">
                    <i class="fas fa-cloud-upload-alt" style="font-size:1.6rem;color:#8a9bb0;display:block;margin-bottom:6px"></i>
                    <span style="color:#555;font-size:.9rem">Click to upload or drag image here</span><br>
                    <span style="color:#aaa;font-size:.78rem">JPG, PNG, WebP — max 8 MB</span>
                    <input type="file" name="image_file" id="image_file_proj" accept="image/*" style="display:none" onchange="previewImg(this,'preview-proj')">
                </label>
                <img id="preview-proj" src="" alt="" style="display:none;max-height:180px;max-width:100%;margin-top:10px;border-radius:8px;border:1px solid #e0e0e0;object-fit:cover">
            </div>
            <?php if ($curImg): ?><p style="font-size:.8rem;color:#888;margin-top:6px">Upload a new file to replace the current image, or leave blank to keep it.</p><?php endif; ?>
        </div>

        <div class="form-group" style="margin-top:16px"><label>Description</label><textarea name="description" rows="3"><?= htmlspecialchars($edit['description'] ?? '') ?></textarea></div>
        <div style="display:flex;gap:24px;margin-top:16px;align-items:center">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                <input type="checkbox" name="active" <?= ($edit['active'] ?? 1) ? 'checked' : '' ?>> Active
            </label>
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                <input type="checkbox" name="featured" <?= ($edit['featured'] ?? 0) ? 'checked' : '' ?>> Featured
            </label>
        </div>
        <div style="margin-top:20px;display:flex;gap:12px">
            <button type="submit" class="btn btn-primary">💾 Save Project</button>
            <a href="projects.php" class="btn btn-outline">Cancel</a>
        </div>
    </form>
    </div>
</div>

<?php else: ?>
<div class="card">
    <div class="card-body" style="padding:0">
    <table class="tbl">
        <thead><tr><th>No</th><th>Image</th><th>Title</th><th>Client</th><th>Location</th><th>Year</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
        <?php
        $res = $conn->query("SELECT * FROM projects ORDER BY no_urut, id");
        while ($p = $res->fetch_assoc()):
        ?>
        <tr>
            <td><?= $p['no_urut'] ?: $p['id'] ?></td>
            <td><?php if ($p['image']): ?>
                <img src="<?= htmlspecialchars($p['image']) ?>"
                     style="height:44px;width:72px;object-fit:cover;border-radius:4px"
                     onerror="this.style.display='none'">
                <?php else: ?>
                <span style="color:#ccc;font-size:.8rem">No image</span>
                <?php endif; ?></td>
            <td><strong><?= htmlspecialchars($p['title']) ?></strong></td>
            <td><?= htmlspecialchars($p['client'] ?? '-') ?></td>
            <td><?= htmlspecialchars($p['location'] ?? '-') ?></td>
            <td><?= htmlspecialchars($p['year'] ?? '-') ?></td>
            <td><span class="badge <?= $p['active'] ? 'badge-green' : 'badge-red' ?>"><?= $p['active'] ? 'Active' : 'Hidden' ?></span></td>
            <td style="white-space:nowrap">
                <a href="?action=edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline">Edit</a>
                <a href="?action=toggle&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline" style="margin:0 4px"><?= $p['active'] ? 'Hide' : 'Show' ?></a>
                <a href="?action=delete&id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this project?')">Del</a>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
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
document.getElementById('dropzone-proj')?.addEventListener('click', function(e) {
    if (e.target !== document.getElementById('image_file_proj')) {
        document.getElementById('image_file_proj').click();
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
