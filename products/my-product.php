<?php
// Mulai session
session_start();

// Periksa apakah user sudah login (apakah session 'user_id' ada)
if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

// Koneksi ke database
include_once '../koneksi.php';

// Query untuk mengambil produk yang dimiliki oleh pengguna yang sedang login
$query = "SELECT tb_products.id, tb_products.cover, tb_products.name, tb_products.price, tb_categories.name AS category_name 
          FROM tb_products 
          JOIN tb_categories ON tb_products.category_id = tb_categories.id
          WHERE tb_products.creator_id = ?";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
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
            <img src="../assets/img/logo.png" alt="logo">
            <h2>DesignMart</h2>
        </div>
        <ul class="sidebar-links">
            <h4><span>Daily Use</span>
                <div class="menu-separator"></div>
            </h4>
            <li><a href="/index.php"><span class="material-symbols-outlined">home</span>Home</a></li>
            <li><a href="../dashboard.php"><span class="material-symbols-outlined">overview</span>Overview</a></li>
            <li><a href="../product_orders/my-transactions.php"><span class="material-symbols-outlined">credit_card</span>My Transactions</a></li>
            <li><a href="../product_orders/my-orders.php"><span class="material-symbols-outlined">local_mall</span>My Orders</a></li>
            <li><a href="" id="myProductLink"><span class="material-symbols-outlined">inventory_2</span>My Products</a></li>
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
                <h2>My Products</h2>
                <button class="add-product-btn">
                    <a href="product-entry.php" class="add-product-btn">Add New Product</a>
                </button>
            </div>
            <div class="products-container">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="product-card">
                        <!-- Menampilkan gambar cover produk -->
                        <img src="../storage/product_covers/<?php echo htmlspecialchars($row['cover']); ?>" alt="Product Image">

                        <div class="product-details">
                            <div class="product-info">
                                <!-- Menampilkan nama produk -->
                                <h3><?php echo htmlspecialchars($row['name']); ?></h3>

                                <!-- Menampilkan kategori produk -->
                                <span class="product-type"><?php echo htmlspecialchars($row['category_name']); ?></span>

                                <!-- Menampilkan harga produk -->
                                <p><b>Rp<?php echo number_format($row['price'], 0, ',', '.'); ?></b></p>
                            </div>

                            <div class="product-actions">
                                <!-- Edit Button -->
                                <a href="product-edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>

                                <!-- Delete Button -->
                                <form action="product-delete.php" method="GET" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_product" class="delete-btn">Delete Product</button>
                                </form>
                            </div>

                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</body>

</html>

<?php
// Tutup koneksi
$stmt->close();
$koneksi->close();
?>