<?php
// Mulai session
session_start();

// Periksa apakah user sudah login (apakah session 'user_id' ada)
if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

// Koneksi ke database
include_once __DIR__ . '/koneksi.php';

if (!$koneksi) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch total products
$query_products = "SELECT COUNT(*) AS total_products FROM tb_products WHERE creator_id = ?";
$stmt_products = $koneksi->prepare($query_products);
$stmt_products->bind_param("i", $_SESSION['user_id']);
$stmt_products->execute();
$result_products = $stmt_products->get_result();
$total_products = $result_products->fetch_assoc()['total_products'];

// Fetch total orders
$query_orders = "SELECT COUNT(*) AS total_orders FROM tb_product_orders WHERE product_id IN (SELECT id FROM tb_products WHERE creator_id = ?)";
$stmt_orders = $koneksi->prepare($query_orders);
$stmt_orders->bind_param("i", $_SESSION['user_id']);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
$total_orders = $result_orders->fetch_assoc()['total_orders'];

// Fetch total revenue
$query_revenue = "SELECT SUM(price) AS total_revenue FROM tb_product_orders JOIN tb_products ON tb_product_orders.product_id = tb_products.id WHERE tb_products.creator_id = ? AND tb_product_orders.is_paid = 1";
$stmt_revenue = $koneksi->prepare($query_revenue);
$stmt_revenue->bind_param("i", $_SESSION['user_id']);
$stmt_revenue->execute();
$result_revenue = $stmt_revenue->get_result();
$total_revenue = $result_revenue->fetch_assoc()['total_revenue'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - My Products</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="CSS/my-product.css">
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="assets/img/logo.png" alt="logo">
            <h2>DesignMart</h2>
        </div>
        <ul class="sidebar-links">
            <h4><span>Daily Use</span>
                <div class="menu-separator"></div>
            </h4>
            <li><a href="/index.php"><span class="material-symbols-outlined">home</span>Home</a></li>
            <li><a href="" id="myProductLink"><span class="material-symbols-outlined">overview</span>Overview</a></li>
            <li><a href="product_orders/my-transactions.php"><span class="material-symbols-outlined">credit_card</span>My Transactions</a></li>
            <li><a href="product_orders/my-orders.php""><span class=" material-symbols-outlined">local_mall</span>My Orders</a></li>
            <li><a href="products/my-product.php"><span class="material-symbols-outlined">inventory_2</span>My Products</a></li>
            <h4><span>Others</span>
                <div class="menu-separator"></div>
            </h4>
            <li><a href=""><span class="material-symbols-outlined">settings</span>Settings</a></li>
            <li><a href="../logout.php"><span class="material-symbols-outlined">logout</span>Log Out</a></li>
        </ul>
        <div class="user-account">
            <div class="user-profile">
                <img src="<?php echo htmlspecialchars($_SESSION['avatar']); ?>" alt="User Avatar" class="user-avatar">
                <div class="user-details">
                    <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                    <span><?php echo htmlspecialchars($_SESSION['occupation']); ?></span>
                </div>
            </div>
        </div>
    </aside>

    <section class="home-section">

        <div class="section-header" style="margin: 20px">
            <h2>Overview</h2>
        </div>

        <div style="max-width: 3xl; margin: 0 auto; padding-left: 1.5rem; padding-right: 2rem;">
            <div style="background-color: white; overflow: hidden; padding: 2.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 0.375rem; display: flex; flex-direction: column; gap: 1.25rem;">

                <?php if (!empty($errors)) { ?>
                    <div style="background-color: #f44336; color: white; padding: 1rem; border-radius: 0.375rem;">
                        <ul>
                            <?php foreach ($errors as $error) { ?>
                                <li style="padding: 0.75rem 0; font-weight: bold; font-size: 1rem;"><?php echo htmlspecialchars($error); ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <p style="color: #4b5563; font-size: 0.875rem;">Total Product:</p>
                        <p style="color: #4c51bf; font-weight: bold; font-size: 1.25rem;"><?php echo htmlspecialchars($total_products); ?></p>
                    </div>

                    <div>
                        <p style="color: #4b5563; font-size: 0.875rem;">Total Order:</p>
                        <p style="color: #4c51bf; font-weight: bold; font-size: 1.25rem;"><?php echo htmlspecialchars($total_orders); ?></p>
                    </div>

                    <div>
                        <p style="color: #4b5563; font-size: 0.875rem;">Total Revenue:</p>
                        <p style="color: #4c51bf; font-weight: bold; font-size: 1.25rem;">Rp <?php echo number_format($total_revenue); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>

<?php
// Tutup koneksi
$stmt_products->close();
$stmt_orders->close();
$stmt_revenue->close();
$koneksi->close();
?>