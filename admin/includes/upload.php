<?php
/**
 * Handle a single image upload from $_FILES.
 *
 * @param string $field   - $_FILES key (e.g. 'image_file')
 * @param string $subdir  - folder under /assets/uploads/ (e.g. 'hero', 'projects')
 * @return array          - ['webPath' => string|null, 'error' => string]
 */
function handleImageUpload(string $field, string $subdir): array {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE || empty($_FILES[$field]['name'])) {
        return ['webPath' => null, 'error' => ''];
    }

    $file = $_FILES[$field];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $msg = [
            UPLOAD_ERR_INI_SIZE   => 'File exceeds server size limit.',
            UPLOAD_ERR_FORM_SIZE  => 'File exceeds form size limit.',
            UPLOAD_ERR_PARTIAL    => 'File only partially uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temp folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write to disk.',
        ][$file['error']] ?? 'Upload error (code ' . $file['error'] . ').';
        return ['webPath' => null, 'error' => $msg];
    }

    // Validate by actual MIME type, not extension
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
    if (!isset($allowed[$mime])) {
        return ['webPath' => null, 'error' => 'Only JPG, PNG, GIF, or WebP images are allowed.'];
    }

    if ($file['size'] > 8 * 1024 * 1024) {
        return ['webPath' => null, 'error' => 'Image too large (max 8 MB).'];
    }

    // Filesystem path: admin/includes/upload.php → ../../assets/uploads/{subdir}/
    $siteRoot  = realpath(__DIR__ . '/../../');
    $uploadDir = $siteRoot . '/assets/uploads/' . $subdir . '/';

    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        return ['webPath' => null, 'error' => 'Cannot create upload directory.'];
    }

    $ext      = $allowed[$mime];
    $filename = date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $destPath = $uploadDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        return ['webPath' => null, 'error' => 'Failed to save the uploaded file.'];
    }

    // Convert filesystem path → web path (e.g. /hostruc/assets/uploads/hero/xxx.jpg)
    $docRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
    $webPath = str_replace('\\', '/', $destPath);
    $webPath = '/' . ltrim(str_replace($docRoot, '', $webPath), '/');

    return ['webPath' => $webPath, 'error' => ''];
}
