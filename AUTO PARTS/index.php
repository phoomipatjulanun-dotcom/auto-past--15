<?php
require_once 'config.php';

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if (!empty($search)) {
    $search_clean = $conn->real_escape_string($search);
    $sql = "SELECT * FROM products WHERE products_name LIKE '%$search_clean%' OR category LIKE '%$search_clean%' ORDER BY products_id ASC";
} else {
    $sql = "SELECT * FROM products ORDER BY products_id ASC";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTO PARTS STORE - อะไหล่แต่งซิ่ง</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background: #0f172a; 
            font-family: 'Prompt', sans-serif; 
            color: #f8fafc; 
        }
        .navbar { background: rgba(15, 23, 42, 0.95) !important; backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .hero-banner { 
            background: linear-gradient(135deg, #1e1b4b 0%, #311042 100%); 
            border-radius: 20px; 
            padding: 40px; 
            margin-bottom: 30px; 
            border: 1px solid rgba(255,255,255,0.1); 
        }
        .product-card { 
            background: rgba(30, 41, 59, 0.7); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 16px; 
            overflow: hidden; 
            transition: transform 0.2s, box-shadow 0.2s; 
        }
        .product-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 10px 20px rgba(0,0,0,0.4); 
        }
        .product-img { height: 220px; object-fit: cover; width: 100%; }
        .category-badge { position: absolute; top: 12px; left: 12px; font-size: 0.75rem; text-transform: uppercase; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning fs-4 d-flex align-items-center" href="index.php">
                <i class="fa-solid fa-car-rear me-2 text-primary"></i>AUTO PARTS STORE
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-lg-4">
                    <li class="nav-item"><a class="nav-link active fw-bold" href="index.php"><i class="fa-solid fa-house me-1"></i> หน้าแรก</a></li>
                    <li class="nav-item"><a class="nav-link" href="my_orders.php"><i class="fa-solid fa-cart-shopping me-1"></i> รายการสั่งซื้อ</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold text-info"><i class="fa-solid fa-circle-user me-1"></i><?= htmlspecialchars($user_name) ?></span>
                    <a href="my_order.php">รายการสั่งซื้อ</a>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm p-2" title="ออกจากระบบ"><i class="fa-solid fa-power-off"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="hero-banner shadow-lg">
            <span class="badge bg-warning text-dark mb-2 px-3 py-2 fw-bold">PROMOTION SALE 2026</span>
            <h1 class="fw-bold text-white mb-2">อะไหล่แต่งซิ่ง & อะไหล่แท้ตรงรุ่น</h1>
            <p class="text-light opacity-75">ยินดีต้อนรับคุณ <strong class="text-warning"><?= htmlspecialchars($user_name) ?></strong> | เลือกชมอะไหล่แต่งคุณภาพ สินค้าพร้อมส่งทุกชิ้น</p>
        </div>

        <form action="index.php" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control bg-dark text-white border-secondary" placeholder="ค้นหาชื่อสินค้า หรือหมวดหมู่..." value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-primary px-4 fw-bold" type="submit"><i class="fa-solid fa-magnifying-glass me-1"></i> ค้นหา</button>
            </div>
        </form>

        <div class="row g-4">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="product-card h-100 d-flex flex-column position-relative">
                            <span class="badge bg-info text-dark category-badge"><?= htmlspecialchars($row['category'] ?? 'ทั่วไป') ?></span>
                            <img src="<?= htmlspecialchars(!empty($row['image_url']) ? $row['image_url'] : 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=600&q=80') ?>" 
                                 class="product-img" 
                                 alt="<?= htmlspecialchars($row['products_name']) ?>"
                                 onerror="this.src='https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?auto=format&fit=crop&w=600&q=80'">
                            
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">ID: #<?= $row['products_id'] ?></small>
                                    <small class="text-success"><i class="fa-solid fa-circle-check me-1"></i>คงเหลือ <?= $row['stock'] ?> ชิ้น</small>
                                </div>
                                <h5 class="fw-bold text-white mb-3 text-truncate"><?= htmlspecialchars($row['products_name']) ?></h5>
                                
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted d-block">ราคา</small>
                                        <span class="fs-4 fw-bold text-danger">฿<?= number_format($row['price'], 2) ?></span>
                                    </div>
                                    <a href="order.php?id=<?= $row['products_id'] ?>" class="btn btn-primary px-3 py-2 fw-bold rounded-pill">
                                        <i class="fa-solid fa-cart-shopping me-1"></i> สั่งซื้อ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">ไม่พบข้อมูลสินค้าที่ค้นหา</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>