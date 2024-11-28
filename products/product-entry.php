<?php
// Mulai session
session_start();

// Periksa apakah user sudah login (apakah session 'user_id' ada)
if (!isset($_SESSION['user_id'])) {
    // Jika tidak ada session, arahkan ke halaman login
    header("Location: /login.php");
    exit();
}

// Koneksi ke database
include_once '../koneksi.php';

// Ambil data kategori dari database
$query = "SELECT * FROM tb_categories";  // Sesuaikan dengan nama tabel kategori Anda
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../CSS/my-product.css">
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="..\assets\img\logo.png" alt="logo">
            <h2>DesignMart</h2>
        </div>
        <ul class="sidebar-links">
            <h4>
                <span>
                    Daily Use
                </span>
                <div class="menu-separator"></div>
            </h4>
            <li>
                <a href="/index.php">
                    <span class="material-symbols-outlined">
                        home
                    </span>Home</a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        Overview
                    </span>Overview</a>
            </li>
            <li>
                <a href="/transactions/my-transactions.php">
                    <span class="material-symbols-outlined">
                        credit_card
                    </span>My Transactions</a>
            </li>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        local_mall
                    </span>My Orders</a>
            </li>
            <li>
                <a href="../products/my-product.php" id="myProductLink">
                    <span class="material-symbols-outlined">
                        inventory_2
                    </span>My Products</a>
            </li>
            <h4>
                <span>
                    Others
                </span>
                <div class="menu-separator"></div>
            </h4>
            <li>
                <a href="">
                    <span class="material-symbols-outlined">
                        settings
                    </span>Settings</a>
            </li>
            <li>
                <a href="/login.php">
                    <span class="material-symbols-outlined">
                        logout
                    </span>Log Out</a>
            </li>
        </ul>
        <div class="user-account">
            <div class="user-profile">
                <!-- Menampilkan avatar dari session -->
                <img src="../<?php echo $_SESSION['avatar']; ?>" alt="User Avatar" class="user-avatar">
                <div class="user-details">
                    <!-- Menampilkan username dan occupation dari session -->
                    <h3><?php echo $_SESSION['username']; ?></h3>
                    <span><?php echo $_SESSION['occupation']; ?></span>
                </div>
            </div>
        </div>
    </aside>
    <section class="home-section">
        <div class="product-section">
            <div class="section-header">
                <h2>My Products</h2>
            </div>
            <div class="products-container">
                <div class="product-entry">
                    <h3>Add New Product</h3>
                    <form action="product-proses.php" method="POST" enctype="multipart/form-data">
                        <!-- Cover File Input -->
                        <div class="form-group">
                            <label for="cover">Cover</label>
                            <input type="file" id="cover" name="cover" class="file-input" required>

                        </div>

                        <!-- Path File Input -->
                        <div class="form-group">
                            <label for="path_file">Path File</label>
                            <input type="file" id="path_file" name="path_file" class="file-input" required>

                        </div>

                        <!-- Name Input -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="text-input" required>
                        </div>

                        <!-- Price Input -->
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" id="price" name="price" class="text-input" required>
                        </div>

                        <!-- Category Dropdown (perulangan data kategori) -->
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" id="category" class="dropdown" required>
                                <option value="">Select category</option>
                                <?php
                                if ($result->num_rows > 0) {
                                    // Perulangan untuk menampilkan kategori
                                    while ($category = $result->fetch_assoc()) {
                                        echo '<option value="' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No categories found</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <!-- About Textarea -->
                        <div class="form-group">
                            <label for="about">About</label>
                            <textarea id="about" name="about" class="text-area" required></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" class="submit-btn">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
</body>

</html>