<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

include_once '../koneksi.php';

// Ambil ID Pesanan
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($order_id === 0) {
    echo "<p style='color:red;'>Invalid order ID.</p>";
    exit();
}

// Query Detail Pesanan untuk Creator
$query = "SELECT tb_product_orders.id, tb_products.cover, tb_products.name, tb_products.price, 
                 tb_categories.name AS category_name, tb_product_orders.is_paid, tb_product_orders.total_price, 
                 tb_product_orders.proof, tb_users.name AS buyer_name 
          FROM tb_product_orders 
          JOIN tb_products ON tb_product_orders.product_id = tb_products.id
          JOIN tb_categories ON tb_products.category_id = tb_categories.id
          JOIN tb_users ON tb_product_orders.buyer_id = tb_users.id
          WHERE tb_product_orders.id = ? AND tb_products.creator_id = ?";

$stmt = $koneksi->prepare($query);
$stmt->bind_param("ii", $order_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "<p style='color:red;'>Order not found or you do not have permission to view this order.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
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

    <section class="home-section" style="margin-left: 270px; padding: 20px;">
        <div class="py-12" style="padding-top: 50px;">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8" style="max-width: 800px; margin: auto;">
                <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg flex flex-col gap-y-5"
                    style="background-color: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 10px;">
                    <div class="item-product flex flex-col gap-y-10"
                        style="display: flex; flex-direction: column; gap: 20px;">

                        <img src="../storage/product_covers/<?php echo htmlspecialchars($order['cover']); ?>"
                            alt="Product Image" style="width: 300px; height: auto;">

                        <div>
                            <h3><?php echo htmlspecialchars($order['name']); ?></h3>
                            <p><?php echo htmlspecialchars($order['category_name']); ?></p>
                        </div>

                        <hr>
                        <p class="text-sm text-slate-500 font-bold"><?php echo htmlspecialchars($order['buyer_name']); ?></p>
                        <hr>

                        <div class="flex flex-row gap-x-5 items-center"
                            style="display: flex; gap: 20px; align-items: center;">
                            <p class="mb-2">Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></p>

                            <?php if ($order['is_paid']) { ?>
                                <span class="py-2 px-5 rounded-full bg-green-500 text-white font-bold text-sm"
                                    style="padding: 10px 20px; background-color: green; color: white; border-radius: 50px;">
                                    PAID
                                </span>
                            <?php } else { ?>
                                <span class="py-2 px-5 rounded-full bg-orange-500 text-white font-bold text-sm"
                                    style="padding: 10px 20px; background-color: orange; color: white; border-radius: 50px;">
                                    PENDING
                                </span>
                            <?php } ?>
                        </div>

                        <img src="../storage/payment_proofs/<?php echo htmlspecialchars($order['proof']); ?>"
                            alt="Payment Proof" style="width: 300px; height: auto;">

                        <?php if (!$order['is_paid']) { ?>
                            <div class="flex flex-row gap-x-3"
                                style="display: flex; gap: 10px;">
                                <form action="approve_order.php" method="POST">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <button type="submit" class="py-3 px-5 bg-indigo-500 text-white"
                                        style="padding: 10px 20px; background-color: indigo; color: white; border: none; border-radius: 5px;">
                                        Approve Now
                                    </button>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
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