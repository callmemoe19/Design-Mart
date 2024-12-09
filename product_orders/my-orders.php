<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

include_once '../koneksi.php';

// Query untuk mendapatkan pesanan produk yang dibuat oleh Creator
$query = "SELECT tb_product_orders.id, tb_products.cover, tb_products.name, tb_products.price, tb_categories.name AS category_name, tb_product_orders.is_paid 
          FROM tb_product_orders 
          JOIN tb_products ON tb_product_orders.product_id = tb_products.id
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
    <title>Dashboard - My Products</title>
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
            <li><a href="" id="myProductLink"><span class="material-symbols-outlined">local_mall</span>My Orders</a></li>
            <li><a href="../products/my-product.php"><span class="material-symbols-outlined">inventory_2</span>My Products</a></li>
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
                <h2>My Orders</h2>
            </div>
            <div class="products-container">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="product-card">
                        <img src="../storage/product_covers/<?php echo htmlspecialchars($row['cover']); ?>" alt="Product Image">

                        <div class="product-details">
                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                                <span class="product-type"><?php echo htmlspecialchars($row['category_name']); ?></span>
                                <p><b>Rp<?php echo number_format($row['price'], 0, ',', '.'); ?></b></p>
                            </div>

                            <div style="margin-top: 5px;">
                                <a class="status-text" style="margin-bottom: 5px;">Status: </a>
                                <?php if ($row['is_paid']) { ?>
                                    <span class="status-success" style="text-decoration: none; color: white; background-color: green; padding: 15px 15px; border-radius: 50px;">
                                        PAID
                                    </span>
                                <?php } else { ?>
                                    <span class="status-pending" style="text-decoration: none; color: white; background-color: orange; padding: 15px 15px; border-radius: 50px;">
                                        PENDING
                                    </span>
                                <?php } ?>
                            </div>

                            <div class="button-container" style="margin-top: 5px; margin-right:80px;">
                                <a href="product-order-details.php?id=<?php echo $row['id']; ?>" class="view-details-button" style="text-decoration: none; color: white; background-color: blue; padding: 15px 20px; border-radius: 50px;">
                                    View Details
                                </a>
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