<?php
session_start();
include_once '../koneksi.php';

// Function to display a listing of the resource
function index()
{
    global $koneksi;
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM tb_product_orders WHERE creator_id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $my_orders = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    include 'views/admin/product_orders/index.php';
}

// Function to display transactions
function transactions()
{
    global $koneksi;
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM tb_product_orders WHERE buyer_id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $my_transactions = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    include 'views/admin/product_orders/transactions.php';
}

// Function to display transaction details
function transactions_details($order_id)
{
    global $koneksi;
    $query = "SELECT * FROM tb_product_orders WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
    include 'views/admin/product_orders/transaction_details.php';
}

// Function to download file
function download_file($order_id)
{
    global $koneksi;
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM tb_product_orders WHERE id = ? AND buyer_id = ? AND is_paid = 1";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();

    if (!$order) {
        $_SESSION['error'] = 'You must purchase before download';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $query = "SELECT * FROM tb_products WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $order['product_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    $filePath = $product['path_file'];
    $fullPath = "../storage/product_files/" . $filePath;

    if (!file_exists($fullPath)) {
        http_response_code(404);
        exit();
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fullPath) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fullPath));
    readfile($fullPath);
    exit();
}

// Function to update the specified resource in storage
function update($order_id)
{
    global $koneksi;
    $query = "UPDATE tb_product_orders SET is_paid = 1 WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message'] = 'Order successfully updated';
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

// Function to display the specified resource
function show($order_id)
{
    global $koneksi;
    $query = "SELECT * FROM tb_product_orders WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
    include 'views/admin/product_orders/details.php';
}

// Function to remove the specified resource from storage
function destroy($order_id)
{
    global $koneksi;
    $query = "DELETE FROM tb_product_orders WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['message'] = 'Order successfully deleted';
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
