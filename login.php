<?php
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $_SESSION['user_name'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = 'กรุณากรอกข้อมูลให้ครบถ้วน!';
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - AUTO PARTS STORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.95)), 
                        url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat fixed;
            font-family: 'Prompt', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f8fafc;
        }
        .login-card {
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 420px;
        }
    </style>
</head>
<body>
    <div class="login-card p-4 p-md-5">
        <div class="text-center mb-4">
            <i class="fa-solid fa-car-side fa-3x text-warning mb-2"></i>
            <h3 class="fw-bold text-white">เข้าสู่ระบบ</h3>
            <p class="text-muted small">AUTO PARTS STORE</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                <div><?= htmlspecialchars($error) ?></div>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label class="form-label text-light">ชื่อผู้ใช้ (Username)</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-muted"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="username" class="form-control bg-dark text-white border-secondary" placeholder="กรอกชื่อผู้ใช้" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label text-light">รหัสผ่าน (Password)</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-muted"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" class="form-control bg-dark text-white border-secondary" placeholder="กรอกรหัสผ่าน" required>
                </div>
            </div>

            <button type="submit" class="btn btn-warning w-100 py-2 fw-bold rounded-pill shadow mb-3">
                <i class="fa-solid fa-right-to-bracket me-2"></i>เข้าสู่ระบบ
            </button>
        </form>
    </div>
</body>
</html>