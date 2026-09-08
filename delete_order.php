<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($order_id > 0) {
    // ลบรายการสั่งซื้อโดยใช้อ้างอิงจาก orders_id เท่านั้น
    $stmt = $conn->prepare("DELETE FROM orders WHERE orders_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
    }
}

// ถ้าในเครื่องชื่อ my_order.php
header("Location: my_order.php");
exit();
?>