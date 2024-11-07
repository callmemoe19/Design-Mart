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
            <img src="/assets/img/logo.png" alt="logo">
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
                <a href="" id="myProductLink">
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
                <img src="/assets/img/moe.jpg" alt="">
                <div class="user-details">
                    <h3>Jamil Moe</h3>
                    <span>Web Developer</span>
                </div>
            </div>
        </div>
    </aside>
    <section class="home-section">
        <div class="product-section">
            <div class="section-header">
                <h2>My Products</h2>
                <button class="add-product-btn">Add New Product</button>
            </div>
            <div class="products-container">
                <div class="product-card">
                    <img src="/assets/img/image.png" alt="Product Image">
                    <div class="product-details">
                        <div class="product-info">
                            <h3>Real Estate App Mobile UI Kit</h3>
                            <span class="product-type">Template</span>
                            <p><b> Rp80,000</b></p>
                        </div>
                        <div class="product-actions">
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>