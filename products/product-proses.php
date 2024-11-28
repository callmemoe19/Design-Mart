<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

// Koneksi ke database
include_once '../koneksi.php';

// Cek apakah form disubmit untuk update atau tambah produk
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null; // Ambil product_id jika ada (untuk update)

    // Ambil data dari form
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $about = $_POST['about'];

    // Validasi input form
    if (empty($name) || empty($price) || empty($category_id) || empty($about)) {
        echo "<p style='color:red;'>All fields are required.</p>";
        exit();
    }

    // Membuat slug dari nama produk
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

    // Cek apakah slug sudah ada di database (untuk mencegah duplikat)
    $query_check_slug = "SELECT COUNT(*) FROM tb_products WHERE slug = ? AND id != ?";
    $stmt_check_slug = $koneksi->prepare($query_check_slug);
    $stmt_check_slug->bind_param("si", $slug, $product_id); // Bind parameter untuk pengecekan slug dan id produk (untuk update)
    $stmt_check_slug->execute();
    $stmt_check_slug->bind_result($slug_count);
    $stmt_check_slug->fetch();
    $stmt_check_slug->close();

    // Jika slug sudah ada, tambahkan angka unik
    if ($slug_count > 0) {
        $slug .= '-' . uniqid();  // Menambahkan ID unik untuk memastikan slug tidak duplikat
    }

    // Tangani file cover yang diunggah
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == UPLOAD_ERR_OK) {
        $cover = $_FILES['cover'];
        $target_dir = "../storage/product_covers";  // Folder untuk menyimpan file
        $cover_target_file = $target_dir . basename($cover["name"]);
        $cover_imageFileType = strtolower(pathinfo($cover_target_file, PATHINFO_EXTENSION));

        // Validasi tipe file cover
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($cover_imageFileType, $allowed_types)) {
            echo "<p style='color:red;'>Only JPG, JPEG, PNG, and GIF files are allowed for cover image.</p>";
            exit();
        }

        // Pindahkan file cover ke folder uploads
        $cover_new_filename = uniqid() . '.' . $cover_imageFileType;
        if (!move_uploaded_file($cover["tmp_name"], $target_dir . '/' . $cover_new_filename)) {
            echo "<p style='color:red;'>Error uploading cover image.</p>";
            exit();
        }
    } else {
        $cover_new_filename = $_POST['existing_cover'];  // Jika tidak ada file baru, pakai cover lama
    }

    // Tangani file path_file yang diunggah
    if (isset($_FILES['path_file']) && $_FILES['path_file']['error'] == UPLOAD_ERR_OK) {
        $path_file = $_FILES['path_file'];
        $path_target_dir = "../storage/product_files";  // Folder untuk menyimpan file
        $path_target_file = $path_target_dir . basename($path_file["name"]);
        $path_imageFileType = strtolower(pathinfo($path_target_file, PATHINFO_EXTENSION));

        // Validasi tipe file path_file
        $allowed_types = ['zip', 'rar', 'tar'];
        if (!in_array($path_imageFileType, $allowed_types)) {
            echo "<p style='color:red;'>Only ZIP, RAR, and TAR files are allowed for the product path file.</p>";
            exit();
        }

        // Pindahkan file path_file ke folder uploads
        $path_new_filename = uniqid() . '.' . $path_imageFileType;
        if (!move_uploaded_file($path_file["tmp_name"], $path_target_dir . '/' . $path_new_filename)) {
            echo "<p style='color:red;'>Error uploading product path file.</p>";
            exit();
        }
    } else {
        $path_new_filename = $_POST['existing_path_file'];  // Jika tidak ada file baru, pakai file lama
    }

    // Jika $product_id ada, maka itu adalah proses update
    if ($product_id) {
        // Update query produk
        $query = "UPDATE tb_products SET slug = ?, name = ?, price = ?, category_id = ?, about = ?, cover = ?, path_file = ? WHERE id = ? AND creator_id = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ssiiisssi", $slug, $name, $price, $category_id, $about, $cover_new_filename, $path_new_filename, $product_id, $_SESSION['user_id']);
    } else {
        // Insert query untuk produk baru
        $query = "INSERT INTO tb_products (slug, creator_id, name, price, category_id, about, cover, path_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("sisissss", $slug, $_SESSION['user_id'], $name, $price, $category_id, $about, $cover_new_filename, $path_new_filename);
    }

    // Eksekusi query
    if ($stmt->execute()) {
        echo "<p style='color:green;'>Product has been updated successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error updating product. Please try again.</p>";
    }

    // Tutup koneksi dan statement
    $stmt->close();
    $koneksi->close();
}
