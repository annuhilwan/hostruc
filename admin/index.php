<?php
session_start();
if (!empty($_SESSION['admin_id'])) { header('Location: dashboard.php'); exit; }
require_once 'includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $conn->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['admin_id']       = $row['id'];
        $_SESSION['admin_username'] = $row['username'];
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Login — HOSTRUC</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',system-ui,sans-serif;background:linear-gradient(135deg,#0f1e2e 0%,#1a2f4a 100%);min-height:100vh;display:flex;align-items:center;justify-content:center}
.box{background:#fff;border-radius:12px;padding:44px 40px;width:100%;max-width:400px;box-shadow:0 20px 60px rgba(0,0,0,.35)}
.logo{text-align:center;margin-bottom:28px}
.logo-name{font-size:1.3rem;font-weight:900;color:#1a2f4a;letter-spacing:.04em}
.logo-sub{font-size:.78rem;color:#888;margin-top:3px}
h1{font-size:1.1rem;font-weight:700;color:#1a2f4a;margin-bottom:24px;text-align:center}
.form-group{display:flex;flex-direction:column;gap:6px;margin-bottom:18px}
label{font-size:.78rem;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:.5px}
input{border:1.5px solid #dde0e6;border-radius:7px;padding:11px 14px;font-size:.95rem;font-family:inherit;transition:border-color .2s}
input:focus{outline:none;border-color:#2bb5ac}
.btn{width:100%;padding:12px;background:#1a2f4a;color:#fff;border:none;border-radius:7px;font-size:.95rem;font-weight:700;cursor:pointer;transition:background .2s;margin-top:6px}
.btn:hover{background:#2c4f72}
.error{background:#ffebee;color:#c62828;border:1px solid #ef9a9a;border-radius:6px;padding:10px 14px;font-size:.85rem;margin-bottom:18px}
</style>
</head>
<body>
<div class="box">
    <div class="logo">
        <div class="logo-name">HOSTRUC</div>
        <div class="logo-sub">Admin Panel</div>
    </div>
    <h1>Sign In</h1>
    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required autocomplete="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required autocomplete="current-password">
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
</div>
</body>
</html>
