<?php
// เปิดระบบแสดงข้อผิดพลาดเพื่อตรวจหาสาเหตุได้ง่ายขึ้น
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
$user_name_clean = $conn->real_escape_string($user_name);

// ดึงข้อมูลรายการสั่งซื้อเฉพาะของผู้ใช้งานคนนี้
$sql = "SELECT orders.orders_id, orders.quantity, orders.total_price, products.products_name, products.price, products.image_url 
        FROM orders 
        JOIN products ON orders.product_id = products.products_id 
        WHERE orders.orders_name = '$user_name_clean' 
        ORDER BY orders.orders_id DESC";

$result = $conn->query($sql);

if (!$result) {
    die("เกิดข้อผิดพลาดในการดึงข้อมูลจากฐานข้อมูล: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการสั่งซื้อ - AUTO PARTS STORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(rgba(15, 23, 42, 0.88), rgba(15, 23, 42, 0.92)), 
                        url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat fixed;
            font-family: 'Prompt', sans-serif;
            min-height: 100vh;
            color: #f8fafc;
        }
        .navbar { background: rgba(15, 23, 42, 0.95) !important; backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .glass-card { background: rgba(30, 41, 59, 0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; }
        .table { color: #f8fafc; vertical-align: middle; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning d-flex align-items-center fs-4" href="index.php">
                <i class="fa-solid fa-car-rear me-2 fa-lg text-primary"></i>AUTO PARTS STORE
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fa-solid fa-house me-1"></i> หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="my_order.php"><i class="fa-solid fa-cart-shopping me-1"></i> รายการสั่งซื้อ</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold text-info"><i class="fa-solid fa-circle-user me-1"></i><?= htmlspecialchars($user_name) ?></span>
                    <a href="index.php" class="btn btn-warning btn-sm fw-bold px-3 py-2 shadow"><i class="fa-solid fa-plus me-1"></i> สั่งซื้อเพิ่ม</a>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm p-2" title="ออกจากระบบ"><i class="fa-solid fa-power-off"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="glass-card p-4 p-md-5 shadow-lg">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-warning mb-0"><i class="fa-solid fa-receipt me-2"></i>รายการสั่งซื้อของคุณ</h3>
                <a href="index.php" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> กลับไปเลือกสินค้า</a>
            </div>

            <?php if ($result && $result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-dark table-hover border-secondary align-middle">
                        <thead>
                            <tr class="text-warning border-bottom border-secondary">
                                <th scope="col" class="py-3">รหัสคำสั่งซื้อ</th>
                                <th scope="col" class="py-3">สินค้า</th>
                                <th scope="col" class="py-3 text-center">ราคา/ชิ้น</th>
                                <th scope="col" class="py-3 text-center">จำนวน</th>
                                <th scope="col" class="py-3 text-end">ราคารวม</th>
                                <th scope="col" class="py-3 text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="fw-bold text-info">#<?= $row['orders_id'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="<?= htmlspecialchars(!empty($row['image_url']) ? $row['image_url'] : 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=600&q=80') ?>" 
                                                 style="width: 50px; height: 50px; object-fit: cover;" 
                                                 class="rounded border border-secondary" 
                                                 alt="Product Image"
                                                 onerror="this.src='https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=600&q=80'">
                                            <span class="fw-semibold text-white"><?= htmlspecialchars($row['products_name']) ?></span>
                                        </div>
                                    </td>
                                    <td class="text-center">฿<?= number_format($row['price'], 2) ?></td>
                                    <td class="text-center"><span class="badge bg-secondary fs-6"><?= $row['quantity'] ?></span></td>
                                    <td class="text-end fw-bold text-danger">฿<?= number_format($row['total_price'], 2) ?></td>
                                    <td class="text-center">
                                        <a href="delete_order.php?id=<?= $row['orders_id'] ?>" 
                                           class="btn btn-outline-danger btn-sm" 
                                           onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการยกเลิกคำสั่งซื้อนี้?');">
                                            <i class="fa-solid fa-trash me-1"></i> ยกเลิก
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fa-solid fa-cart-arrow-down fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">คุณยังไม่มีรายการสั่งซื้อ</h5>
                    <a href="index.php" class="btn btn-warning fw-bold mt-3 rounded-pill px-4">ไปเลือกซื้อสินค้า</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>