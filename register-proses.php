<?php
include 'koneksi.php'; // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $occupation = $_POST['occupation'];
    $bank_name = $_POST['bank_name'];
    $bank_account = $_POST['bank_account'];
    $bank_account_number = $_POST['bank_account_number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Handle file upload
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $avatar = $_FILES['avatar'];
        $target_dir = "storage/avatars/";
        $target_file = $target_dir . basename($avatar["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi tipe file (hanya gambar)
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            // Pindahkan file yang diupload ke folder target
            if (move_uploaded_file($avatar["tmp_name"], $target_file)) {
                // Validasi input kosong
                if (empty($username) || empty($email) || empty($password)) {
                    echo "<p style='color:red;'>Please fill in all required fields.</p>";
                } else {
                    // Query untuk insert ke tabel tb_users
                    $sql = "INSERT INTO tb_users (name, email, password, avatar, occupation, bank_name, bank_account, bank_account_number) 
                            VALUES ('$username', '$email', '$password', '$target_file', '$occupation', '$bank_name', '$bank_account', '$bank_account_number')";

                    // Proses eksekusi query
                    if (mysqli_query($koneksi, $sql)) {
                        echo "<p style='color:green;'>Registration successful! You can now <a href='login.php'>login</a>.</p>";
                    } else {
                        echo "<p style='color:red;'>Error: " . mysqli_error($koneksi) . "</p>";
                    }
                }
            } else {
                echo "<p style='color:red;'>Error uploading avatar.</p>";
            }
        } else {
            echo "<p style='color:red;'>Only JPG, JPEG, PNG, and GIF files are allowed.</p>";
        }
    } else {
        echo "<p style='color:red;'>Please upload an avatar.</p>";
    }
}
