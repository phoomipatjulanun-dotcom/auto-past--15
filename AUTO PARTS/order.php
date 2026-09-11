<?php
// เปิดดักจับ Error เพื่อการตรวจสอบ
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

// 1. ตรวจสอบการล็อกอิน
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
$product_id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['product_id']) ? intval($_POST['product_id']) : 0);

if ($product_id <= 0) {
    header("Location: index.php");
    exit();
}

// 2. ดึงข้อมูลสินค้าที่จะสั่งซื้อ
$stmt = $conn->prepare("SELECT * FROM products WHERE products_id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$product) {
    echo "<script>alert('ไม่พบข้อมูลสินค้านี้'); window.location='index.php';</script>";
    exit();
}

// 3. ประมวลผลเมื่อผู้ใช้กดปุ่ม "ยืนยันการสั่งซื้อ" (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qty = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    // เช็กว่าสต็อกพอหรือไม่
    if ($qty > $product['stock']) {
        echo "<script>alert('จำนวนสินค้าในสต็อกไม่พอ'); window.history.back();</script>";
        exit();
    }

    $total_price = $product['price'] * $qty;

    // บันทึกคำสั่งซื้อลงตาราง orders
    $stmt_insert = $conn->prepare("INSERT INTO orders (orders_name, product_id, quantity, total_price) VALUES (?, ?, ?, ?)");
    $stmt_insert->bind_param("siid", $user_name, $product_id, $qty, $total_price);
    
    if ($stmt_insert->execute()) {
        $stmt_insert->close();

        // ตัดสต็อกสินค้าในตาราง products
        $stmt_update = $conn->prepare("UPDATE products SET stock = stock - ? WHERE products_id = ?");
        $stmt_update->bind_param("ii", $qty, $product_id);
        $stmt_update->execute();
        $stmt_update->close();

        // บันทึกสำเร็จ เด้งไปหน้า my_order.php (ย้อนกลับหน้าประวัติสั่งซื้อ)
        header("Location: my_order.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกคำสั่งซื้อ: " . $conn->error;
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยืนยันการสั่งซื้อ - AUTO PARTS STORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.95)), 
                        url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat fixed;
            font-family: 'Prompt', sans-serif;
            min-height: 100vh;
            color: #f8fafc;
            display: flex;
            align-items: center;
        }
        .glass-card { 
            background: rgba(30, 41, 59, 0.85); 
            backdrop-filter: blur(12px); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 16px; 
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="glass-card p-4 p-md-5 shadow-lg">
                    <h3 class="text-warning fw-bold text-center mb-4">
                        <i class="fa-solid fa-cart-shopping me-2"></i>ยืนยันการสั่งซื้อ
                    </h3>

                    <div class="text-center mb-4">
                        <img src="<?= htmlspecialchars(!empty($product['image_url']) ? $product['image_url'] : 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=600&q=80') ?>" 
                             class="img-fluid rounded border border-secondary mb-3 shadow" 
                             style="max-height: 180px; object-fit: cover;"
                             alt="Product Image">
                        <h5 class="fw-bold text-white"><?= htmlspecialchars($product['products_name']) ?></h5>
                        <p class="text-muted mb-0">ราคาชิ้นละ: <span class="text-danger fw-bold fs-5">฿<?= number_format($product['price'], 2) ?></span></p>
                        <small class="text-info"><i class="fa-solid fa-boxes-stacked me-1"></i>สินค้าคงเหลือ: <?= $product['stock'] ?> ชิ้น</small>
                    </div>

                    <form action="order.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['products_id'] ?>">
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-light">ระบุจำนวนที่ต้องการสั่งซื้อ</label>
                            <input type="number" 
                                   name="quantity" 
                                   class="form-control form-control-lg bg-dark text-white border-secondary text-center fw-bold" 
                                   value="1" 
                                   min="1" 
                                   max="<?= $product['stock'] ?>" 
                                   required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold shadow">
                                <i class="fa-solid fa-check me-2"></i>ยืนยันการสั่งซื้อ
                            </button>
                            <a href="index.php" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-xmark me-1"></i>ยกเลิก
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>