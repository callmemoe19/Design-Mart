<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

include_once '../koneksi.php';

// Validasi data POST
$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;

if ($order_id === 0) {
    echo "<p style='color:red;'>Invalid order ID.</p>";
    exit();
}

// Periksa apakah pesanan milik creator dan belum dibayar
$query = "SELECT tb_product_orders.id, tb_product_orders.is_paid, tb_products.creator_id 
          FROM tb_product_orders 
          JOIN tb_products ON tb_product_orders.product_id = tb_products.id 
          WHERE tb_product_orders.id = ? AND tb_products.creator_id = ?";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("ii", $order_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "<p style='color:red;'>Order not found or you do not have permission to approve this order.</p>";
    exit();
}

if ($order['is_paid']) {
    echo "<p style='color:red;'>Order already approved.</p>";
    exit();
}

// Update status pesanan menjadi "PAID"
$update_query = "UPDATE tb_product_orders SET is_paid = 1 WHERE id = ?";
$update_stmt = $koneksi->prepare($update_query);
$update_stmt->bind_param("i", $order_id);

if ($update_stmt->execute()) {
    echo "<script>
        alert('Order approved successfully.');
        window.location.href = 'product-order-details.php?id=$order_id';
    </script>";
} else {
    echo "<p style='color:red;'>Failed to approve order. Please try again later.</p>";
}

// Tutup koneksi
$update_stmt->close();
$stmt->close();
$koneksi->close();
