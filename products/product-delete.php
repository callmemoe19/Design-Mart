<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

// Koneksi ke database
include_once '../koneksi.php';

// Periksa apakah ada parameter 'product_id' yang dikirim
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Validasi apakah produk tersebut dimiliki oleh user yang sedang login
    $query = "SELECT creator_id FROM tb_products WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($creator_id);
    $stmt->fetch();
    $stmt->close();

    // Jika produk tidak ditemukan atau bukan milik user yang login
    if (!$creator_id || $creator_id != $_SESSION['user_id']) {
        echo "<p style='color:red;'>You don't have permission to delete this product.</p>";
        exit();
    }

    // Ambil nama file cover dan path_file untuk dihapus
    $query_files = "SELECT cover, path_file FROM tb_products WHERE id = ?";
    $stmt_files = $koneksi->prepare($query_files);
    $stmt_files->bind_param("i", $product_id);
    $stmt_files->execute();
    $stmt_files->bind_result($cover, $path_file);
    $stmt_files->fetch();
    $stmt_files->close();

    // Hapus file cover dan path_file jika ada
    $cover_path = "../storage/product_covers/" . $cover;
    $path_file_path = "../storage/product_files/" . $path_file;

    if (file_exists($cover_path)) {
        unlink($cover_path);  // Hapus file cover
    }

    if (file_exists($path_file_path)) {
        unlink($path_file_path);  // Hapus file path_file
    }

    // Hapus data produk dari database
    $query_delete = "DELETE FROM tb_products WHERE id = ? AND creator_id = ?";
    $stmt_delete = $koneksi->prepare($query_delete);
    $stmt_delete->bind_param("ii", $product_id, $_SESSION['user_id']);

    if ($stmt_delete->execute()) {
        echo "<p style='color:green;'>Product has been deleted successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error deleting product. Please try again.</p>";
    }

    // Tutup koneksi dan statement
    $stmt_delete->close();
    $koneksi->close();
} else {
    echo "<p style='color:red;'>Product ID is required to delete the product.</p>";
}
