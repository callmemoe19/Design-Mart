<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

// Koneksi ke database
include_once '../koneksi.php';

// Periksa apakah ada parameter `id` produk
if (!isset($_GET['id'])) {
    header("Location: my-product.php");
    exit();
}

$product_id = intval($_GET['id']);

// Ambil data produk berdasarkan `id` dan `creator_id`
$query = "SELECT * FROM tb_products WHERE id = ? AND creator_id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("ii", $product_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Product not found or you don't have permission to edit this product.";
    exit();
}

$product = $result->fetch_assoc();

// Ambil data kategori untuk dropdown
$query_categories = "SELECT * FROM tb_categories";
$result_categories = $koneksi->query($query_categories);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../CSS/my-product.css">
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="../assets/img/logo.png" alt="logo">
            <h2>DesignMart</h2>
        </div>
        <ul class="sidebar-links">
            <h4><span>Daily Use</span>
                <div class="menu-separator"></div>
            </h4>
            <li><a href="/index.php"><span class="material-symbols-outlined">home</span>Home</a></li>
            <li><a href=""><span class="material-symbols-outlined">overview</span>Overview</a></li>
            <li><a href="/transactions/my-transactions.php"><span class="material-symbols-outlined">credit_card</span>My Transactions</a></li>
            <li><a href=""><span class="material-symbols-outlined">local_mall</span>My Orders</a></li>
            <li><a href="../products/my-product.php" id="myProductLink"><span class="material-symbols-outlined">inventory_2</span>My Products</a></li>
            <h4><span>Others</span>
                <div class="menu-separator"></div>
            </h4>
            <li><a href=""><span class="material-symbols-outlined">settings</span>Settings</a></li>
            <li><a href="../logout.php"><span class="material-symbols-outlined">logout</span>Log Out</a></li>
        </ul>
        <div class="user-account">
            <div class="user-profile">
                <img src="../<?php echo $_SESSION['avatar']; ?>" alt="User Avatar" class="user-avatar">
                <div class="user-details">
                    <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                    <span><?php echo htmlspecialchars($_SESSION['occupation']); ?></span>
                </div>
            </div>
        </div>
    </aside>

    <section class="home-section">
        <div class="product-section">
            <div class="section-header">
                <h2>Edit Product</h2>
            </div>
            <div class="products-container">
                <div class="product-entry">
                    <form action="product-proses.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                        <!-- Cover File Input (Tidak Required) -->
                        <div class="form-group">
                            <label for="cover">Cover Image (optional)</label>
                            <input type="file" id="cover" name="cover" class="file-input">
                            <small>Current Cover: <?php echo htmlspecialchars($product['cover']); ?></small>
                        </div>

                        <!-- Path File Input (Tidak Required) -->
                        <div class="form-group">
                            <label for="path_file">Product File (optional)</label>
                            <input type="file" id="path_file" name="path_file" class="file-input">
                            <small>Current File: <?php echo htmlspecialchars($product['path_file']); ?></small>
                        </div>

                        <!-- Menambahkan input hidden untuk cover dan path file lama -->
                        <input type="hidden" name="existing_cover" value="<?php echo htmlspecialchars($product['cover']); ?>">
                        <input type="hidden" name="existing_path_file" value="<?php echo htmlspecialchars($product['path_file']); ?>">

                        <!-- Name Input -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="text-input" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                        </div>

                        <!-- Price Input -->
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" id="price" name="price" class="text-input" value="<?php echo $product['price']; ?>" required>
                        </div>

                        <!-- Category Dropdown -->
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" id="category" class="dropdown" required>
                                <?php
                                while ($category = $result_categories->fetch_assoc()) {
                                    $selected = ($category['id'] == $product['category_id']) ? 'selected' : '';
                                    echo '<option value="' . $category['id'] . '" ' . $selected . '>' . htmlspecialchars($category['name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <!-- About Textarea -->
                        <div class="form-group">
                            <label for="about">About</label>
                            <textarea id="about" name="about" class="text-area" required><?php echo htmlspecialchars($product['about']); ?></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button type="submit" name="update_product" class="submit-btn">Update Product</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</body>

</html>

<?php
$stmt->close();
$koneksi->close();
?>