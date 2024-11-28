<?php
include 'koneksi.php'; // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input kosong
    if (empty($username) || empty($password)) {
        echo "<p style='color:red;'>Please fill in all required fields.</p>";
    } else {
        // Query untuk mencari user berdasarkan username
        $sql = "SELECT * FROM tb_users WHERE name = '$username'"; // Ganti 'name' sesuai dengan kolom yang ada di database
        $result = mysqli_query($koneksi, $sql);

        // Cek apakah user ditemukan
        if (mysqli_num_rows($result) > 0) {
            // Ambil data user
            $user = mysqli_fetch_assoc($result);

            // Cek password
            if (password_verify($password, $user['password'])) {
                // Set session untuk menyimpan informasi user yang login
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['name'];
                $_SESSION['avatar'] = $user['avatar'];
                $_SESSION['occupation'] = $user['occupation'];
                // Ganti 'name' sesuai dengan kolom yang ada di database

                // Redirect ke halaman dashboard atau halaman utama setelah login
                header("Location: products/my-product.php");
                exit();
            } else {
                echo "<p style='color:red;'>Incorrect password.</p>";
            }
        } else {
            echo "<p style='color:red;'>User not found.</p>";
        }
    }
}
